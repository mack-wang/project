package com.fypool.controller.web;


import com.fypool.component.HelperController;
import com.fypool.component.SmsUtils;
import com.fypool.model.*;
import com.fypool.repository.*;
import org.apache.http.protocol.HTTP;
import org.hashids.Hashids;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.data.redis.core.StringRedisTemplate;
import org.springframework.data.redis.core.ValueOperations;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Controller;
import org.springframework.validation.BindingResult;
import org.springframework.validation.ObjectError;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpSession;
import javax.validation.Valid;
import java.math.BigDecimal;
import java.util.*;
import java.util.concurrent.TimeUnit;

@Controller
public class RegisterController {

    @Value("${customer.hashid.salt}")
    private String salt;

    @Autowired
    UserRepository userRepository;

    @Autowired
    RoleRepository roleRepository;

    @Autowired
    SmsRepository smsRepository;

    @Autowired
    AttributeRepository attributeRepository;

    @Autowired
    UserInfoRepository userInfoRepository;

    @Autowired
    private StringRedisTemplate stringRedisTemplate;

    @Autowired
    private RedisTemplate redisTemplate;

    @Autowired
    AccountRepository accountRepository;

    @Autowired
    private HelperController helper;

    @Autowired
    InviteRepository inviteRepository;

    @Autowired
    TicketRepository ticketRepository;

    @Autowired
    SmsUtils smsUtils;



    //检查用户名是否存在
    @PostMapping("/public/user/exists")
    public @ResponseBody
    boolean existsUser(@RequestParam("username") String username) {
        User user = userRepository.findByUsername(username);
        if (user == null) {
            return false;
        } else {
            return true;
        }
    }


    //检查昵称是否已经被使用
    @PostMapping("/public/nickname/exists")
    public @ResponseBody
    boolean existsNickname(@RequestParam("nickname") String nickname) {
        Attribute attribute = attributeRepository.findByNickname(nickname);
        if (attribute == null) {
            return false;
        } else {
            return true;
        }
    }

    //检查手机号是否已经被使用
    @PostMapping("/public/phone/exists")
    public @ResponseBody
    boolean existsPhone(@RequestParam("phone") String phone) {
        Attribute attribute = attributeRepository.findByPhone(phone);
        if (attribute == null) {
            return false;
        } else {
            return true;
        }
    }

    @PostMapping("/public/sendSms")
    public @ResponseBody
    String sendSms(
            @RequestParam("phone") String phone,
            @RequestParam("captcha") String captcha,
            HttpSession session
    ) {
        //把用户的短信储存到数据库，并缓存到redis，
        //验证有效期5分钟、允许重新获取并覆盖短信时间1分钟
        if (phone.length() != 11) {
            //手机号错误
            return "phoneError";
        }

        //验证图形验证码
        if(!helper.captchaCheck(captcha,session)){
            return "captchaError";
        }

        Boolean result = this.redisTemplate.hasKey("sms:" + phone);
        Long expire = this.redisTemplate.getExpire("sms:" + phone);//测试发现默认单位是秒

        if (result && expire > 4 * 60) {
            //获取短信太过频繁
            return "tooOften";
        } else {
            ValueOperations<String, Integer> ops = this.redisTemplate.opsForValue();
            //生成随机数
            Random rand = new Random();
            Integer randNumber = rand.nextInt(800000)+100000;

            //发送短信
            if(!smsUtils.sendValid(phone,randNumber.toString())){
                return "sendError";//短信发送失败
            }

            //保存到redis中
            ops.set("sms:" + phone, randNumber, 5 * 60, TimeUnit.SECONDS);

            return "success";
        }
    }

    @PostMapping("/register")
    public String register(
            @Valid User user,//传递的所有参数都会注入到user中进行验证
            BindingResult result,
            RedirectAttributes redirect,
            @RequestParam("role") String role,
            @RequestParam("phone") String phone,
            @RequestParam("sms") Integer sms,
            @RequestParam("username") String username,
            @RequestParam("code") String code,
            HttpSession session
    ) {
        //对最终短信验证码进行验证
        if (!helper.verifySms(phone, sms)) {
            redirect.addFlashAttribute("message", new Message(0, "手机号或者验证码出错"));
            return "redirect:/register/user";
        }

        //验证
        if (result.hasErrors()) {
            List<ObjectError> list = result.getAllErrors();//Errors是一个 ObjectError对象的数组
            ArrayList<String> arr = new ArrayList<>();//创建个空字符串数组
            for (ObjectError error : list) {
                arr.add(error.getDefaultMessage());
            }
            redirect.addFlashAttribute("errors", arr);
            if(role.equals("ROLE_USER")){
                return "redirect:/register/user";
            }else{
                return "redirect:/register/client";
            }

        } else {
            ArrayList<Role> roles = new ArrayList<>();
            //检查提交的用户权限
            if (role.equals("ROLE_USER") || role.equals("ROLE_CLIENT")) {
                roles.add(roleRepository.findByName(role));
            } else {
                redirect.addFlashAttribute("message", new Message(0, "非法操作"));
                return "redirect:/register/user";
            }

            //取消级联后，要一个一个保存

            //先创建用户，没有账户和属性
            user.setRoles(roles);
            user.setCurrentRole(role);
            userRepository.save(user);

            //再创建属性
            Attribute attribute = new Attribute(username, phone, user);
            attributeRepository.save(attribute);

            //再创建账户
            Account account = new Account(new BigDecimal(0.00), user);
            accountRepository.save(account);

            //再把属性和账户保存到用户
            user.setAttribute(attribute);
            user.setAccount(account);
            userRepository.save(user);

            //要在用户生成之后，再新建用户信息
            UserInfo userInfo = new UserInfo(user);
            userInfoRepository.save(userInfo);

            //处理邀请码
            if (code.length() > 0) {
                Hashids hashids = new Hashids(salt,6);
                Long idLong = hashids.decode(code)[0];
                Integer id = idLong.intValue();
                User user1 = userRepository.findOne(id);
                if (user1 != null) {
                    //user1是邀请人，user是被邀请的。
                    inviteRepository.save(new Invite(user1, user));

                    //每个人最多只能有10张优惠券
                    if(ticketRepository.countAllByUser(user1)<=10){
                        //暂定有效期为90天
                        //奖励1张有效期为90天的优惠券
                        Calendar c = Calendar.getInstance();
                        c.setTime(new Date());
                        c.add(Calendar.DATE,90);

                        ticketRepository.save(new Ticket(
                                0,
                                "任务金额满100元返现20元",
                                new BigDecimal("20"),
                                new BigDecimal("100"),
                                user1,
                                c.getTime()
                        ));
                    }
                }
            }
            //直接登入
            Authentication authentication = new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities());
            SecurityContextHolder.getContext().setAuthentication(authentication);
            //刷新缓存
            session.setAttribute("user",user);
            redirect.addFlashAttribute("registerUsername",user.getUsername());
            return "redirect:/home";
        }

    }


}
