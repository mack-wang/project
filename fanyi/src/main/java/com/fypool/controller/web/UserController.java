package com.fypool.controller.web;

import com.fypool.component.HelperController;
import com.fypool.model.*;
import com.fypool.repository.*;
import com.sun.mail.util.MailSSLSocketFactory;
import org.hashids.Hashids;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.data.redis.core.ValueOperations;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;
import org.thymeleaf.context.Context;
import org.thymeleaf.spring4.SpringTemplateEngine;

import javax.mail.internet.MimeMessage;
import java.security.GeneralSecurityException;
import java.security.Principal;
import java.util.*;
import java.util.concurrent.TimeUnit;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import javax.mail.Authenticator;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.servlet.http.HttpSession;

@Controller
public class UserController {

    @Autowired
    AttributeRepository attributeRepository;

    @Autowired
    UserRepository userRepository;

    @Autowired
    UserInfoRepository userInfoRepository;

    @Autowired
    private RedisTemplate redisTemplate;

    @Autowired
    MhCityRepository mhCityRepository;

    //注入邮件实例
//    @Autowired
//    private JavaMailSender javaMailSender; //自动注入的Bean

    //注入邮件发送者
    @Value("${customer.hashid.salt}")
    private String salt;

    //使用thymeleaf作为邮件模板
    @Autowired
    SpringTemplateEngine springTemplateEngine;

    @Autowired
    HelperController helper;

    @Value("${spring.mail.username}")
    private String username;//登录用户名
    @Value("${spring.mail.password}")
    private String password;        //登录密码
    @Value("${spring.mail.from}")
    private String from;        //发件地址
    @Value("${spring.mail.host}")
    private String host;        //服务器地址
    @Value("${spring.mail.port}")
    private String port;        //端口
    @Value("${spring.mail.protocol}")
    private String protocol; //协议

    @Autowired
    AccountRepository accountRepository;




    //修改用户头像
    @PostMapping("/user/avatar")
    public @ResponseBody
    boolean uploadAvatar(
            @RequestParam("croppedImage") String file,
            HttpSession session,
            Principal principal
    ) {
        User user = userRepository.findByUsername(principal.getName());
        String path = helper.uploadImgBase64(file, "avatar");
        user.getAttribute().setAvatar(path);
        attributeRepository.save(user.getAttribute());
        //修改头像后，刷新缓存
        session.setAttribute("user", user);
        return true;
    }

    //修改用户昵称
    @GetMapping("/update/nickname/{nickname}")
    public @ResponseBody
    void updateNickname(
            @PathVariable("nickname") String nickname,
            Principal principal,
            HttpSession session
    ) {
        User user = userRepository.findByUsername(principal.getName());
        user.getAttribute().setNickname(nickname);
        userRepository.save(user);
        session.setAttribute("user",user);
    }


    //修改用户性别
    @GetMapping("/update/sex/{sex}")
    public @ResponseBody
    void updateSex(
            @PathVariable("sex") Integer sex,
            HttpSession session
    ) {
        User user = (User) session.getAttribute("user");
        UserInfo userInfo = userInfoRepository.findByUser(user);
        userInfo.setSex(sex);
        userInfoRepository.save(userInfo);
    }


    //修改用户简介
    @GetMapping("/update/introduce/{introduce}")
    public @ResponseBody
    void updateIntroduce(
            @PathVariable("introduce") String introduce,
            Principal principal
    ) {
        User user = userRepository.findByUsername(principal.getName());
        UserInfo userInfo = userInfoRepository.findByUser(user);
        userInfo.setIntroduce(introduce);
        userInfoRepository.save(userInfo);
    }

    //修改用户所在城市
    @PostMapping("/update/city")
    public @ResponseBody
    boolean updateCity(
            @RequestParam("city") String city,
            HttpSession session,
            Principal principal
    ) {
        User user = userRepository.findByUsername(principal.getName());
        UserInfo userInfo = userInfoRepository.findByUser(user);
        userInfo.setCity(mhCityRepository.findOne(Integer.valueOf(city)));
        userInfoRepository.save(userInfo);
        return true;
    }

    //修改用户手机号
    //验证身份，如果正确，则根据path返回相关的视图，该视图有有效期
    @PostMapping("/auth/check")
    public String authCheck(
            RedirectAttributes redirect,
            Principal principal,
            @RequestParam("phone") String phone,
            @RequestParam("sms") Integer sms,
            @RequestParam("path") String path
    ) {
        User user = userRepository.findByUsername(principal.getName());
        if (!user.getAttribute().getPhone().equals(phone)) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/auth/check/" + path;
        }

        //对最终短信验证码进行验证
        if (!helper.verifySms(phone, sms)) {
            redirect.addFlashAttribute("message", new Message(0, "手机号或者验证码出错"));
            return "redirect:/auth/check/" + path;
        }

        ValueOperations<String, Integer> ops = this.redisTemplate.opsForValue();
        switch (path) {
            case "phone":
                //设置修改手机的过期时间
                ops.set("ephone:" + user.getUsername(), 5 * 60, 5 * 60, TimeUnit.SECONDS);
                return "redirect:/auth/checked/phone";
            case "email":
                //设置修改邮箱的过期时间
                ops.set("eemail:" + user.getUsername(), 5 * 60, 5 * 60, TimeUnit.SECONDS);
                return "redirect:/auth/checked/email";
            case "password":
                //设置修改密码的过期时间
                ops.set("epassword:" + user.getUsername(), 5 * 60, 5 * 60, TimeUnit.SECONDS);
                return "redirect:/auth/checked/password";
            case "pay":
                //设置修改支付密码的过期时间
                ops.set("epay:" + user.getUsername(), 5 * 60, 5 * 60, TimeUnit.SECONDS);
                return "redirect:/auth/checked/pay";
        }

        return "redirect:/auth/check";

    }


    //修改手机号
    @PostMapping("/auth/checked/phone")
    public String updatePhone(
            HttpSession session,
            Principal principal,
            RedirectAttributes redirectAttributes,
            @RequestParam("phone") String phone,
            @RequestParam("sms") Integer sms
    ) {

        User user = userRepository.findByUsername(principal.getName());

        if (!this.redisTemplate.hasKey("ephone:" + user.getUsername())) {
            return "redirect:/auth/check/phone";
        }

        //对最终短信验证码进行验证
        if (!helper.verifySms(phone, sms)) {
            redirectAttributes.addFlashAttribute("message", new Message(0, "手机号或者验证码出错"));
            redirectAttributes.addFlashAttribute("phone", new Message(phone));
            return "redirect:/auth/checked/phone";
        } else {
            user.getAttribute().setPhone(phone);
            userRepository.save(user);
            //修改成功后，删除redis缓存，以便用户可以快速进行下次获取短信验证码
            redirectAttributes.addFlashAttribute("securityMessage", new Message(1, "手机号修改成功"));
            this.redisTemplate.delete("ephone:" + user.getUsername());
            this.redisTemplate.delete("sms:" + phone);
            return "redirect:/home?tab=2";
        }
    }

    @PostMapping("/public/email/exists")
    public @ResponseBody
    Boolean existsEmail(@RequestParam("email") String email) {
        return attributeRepository.existsByEmail(email);
    }

    //用于发邮箱：用户名密码验证，需要实现抽象类Authenticator的抽象方法PasswordAuthentication
    static class MyAuthenricator extends Authenticator {
        String u = null;
        String p = null;

        public MyAuthenricator(String u, String p) {
            this.u = u;
            this.p = p;
        }

        @Override
        public PasswordAuthentication getPasswordAuthentication() {
            return new PasswordAuthentication(u, p);
        }
    }

    //修改邮箱
    @PostMapping("/auth/checked/email")
    public String updateEmail(
            Principal principal,
            RedirectAttributes redirectAttributes,
            @RequestParam("email") String email
    ) {
        User user = userRepository.findByUsername(principal.getName());

        if (!this.redisTemplate.hasKey("eemail:" + user.getUsername())) {
            return "redirect:/auth/check/email";
        }

        ValueOperations<String, String> ops = this.redisTemplate.opsForValue();
        //24小时有效的邮箱验证码,保存着用户的id和邮箱，如果没有失效就取出邮箱
        ops.set("eemailid:" + user.getId(), email, 60 * 60 * 24, TimeUnit.SECONDS);

        //腾讯企业邮箱
        Properties prop = new Properties();
        //协议
        prop.setProperty("mail.transport.protocol", protocol);
        //服务器
        prop.setProperty("mail.smtp.host", host);
        //端口
        prop.setProperty("mail.smtp.port", port);
        //使用smtp身份验证
        prop.setProperty("mail.smtp.auth", "true");
        //使用SSL，企业邮箱必需！
        //开启安全协议
        MailSSLSocketFactory sf = null;
        try {
            sf = new MailSSLSocketFactory();
            sf.setTrustAllHosts(true);
        } catch (GeneralSecurityException e1) {
            e1.printStackTrace();
        }
        prop.put("mail.smtp.ssl.enable", "true");
        prop.put("mail.smtp.ssl.socketFactory", sf);

        Session sessions = Session.getDefaultInstance(prop, new MyAuthenricator(username, password));
        sessions.setDebug(true);
        MimeMessage message = new MimeMessage(sessions);
        try {

            //如果不加UTF-8的话，会乱码　
            MimeMessageHelper helper = new MimeMessageHelper(message, true, "UTF-8");
            helper.setFrom(from);//邮件发送者
            helper.setTo(email);//邮件接收者
            helper.setSubject("领骄翻易邮箱绑定验证");

            //使用thymeleaf作为邮箱模板
            Context context = new Context();

            //设置变量
            context.setVariable("username", user.getUsername());

            //生成32位的hashid
            Hashids hashids = new Hashids(salt, 32);
            context.setVariable("id", hashids.encode(user.getId()));
            //发送thymeleaf模板
            String emailContent = springTemplateEngine.process("email/emailTemplate", context);
            helper.setText(emailContent, true);

            //原先用javaMailSender来发邮件，在企业邮箱下不起作用，所以换了Transport
            Transport.send(message);
        } catch (Exception e) {
            e.printStackTrace();
        }

        redirectAttributes.addFlashAttribute("message", new Message(1, "验证邮件已发送，请查收并激活"));
        return "redirect:/auth/checked/email";
    }

    //点击邮箱，激活邮箱
    @GetMapping("/public/email/valid/{hashid}")
    public String EmailValid(
            @PathVariable("hashid") String hashid,
            Model model,
            HttpSession session
    ) {
        Hashids hashids = new Hashids(salt, 32);
        //dv5KZgrQpE6q1eLMPlnxVXD8YAPoG0MB 测试id=2
        String id = String.valueOf(hashids.decode(hashid)[0]);
        User user = userRepository.findOne(Integer.valueOf(id));

        if (this.redisTemplate.hasKey("eemailid:" + id)) {
            Message message = new Message(1, "邮箱绑定", "邮箱绑定成功", "邮箱绑定结果");
            model.addAttribute("info", message);
            String email = this.redisTemplate.opsForValue().get("eemailid:" + id).toString();
            user.getAttribute().setEmail(email);
            userRepository.save(user);
            //删除缓存
            this.redisTemplate.delete("eemailid:" + id);

            return "web/info";
        } else {
            Message message = new Message(0, "邮箱绑定", "邮箱绑定失败", "邮箱绑定结果");
            model.addAttribute("info", message);
            return "web/info";
        }
    }

    //修改密码
    @PostMapping("/auth/checked/password")
    public String updatePassword(
            HttpSession session,
            Principal principal,
            RedirectAttributes redirectAttributes,
            @RequestParam("password") String password
    ) {

        User user = userRepository.findByUsername(principal.getName());

        if (!this.redisTemplate.hasKey("epassword:" + user.getUsername())) {
            return "redirect:/auth/check/password";
        }

        if (password.length() < 6 || password.length() > 32) {
            redirectAttributes.addFlashAttribute("message", new Message(0, "密码必须在6位到32位之间"));
            return "redirect:/auth/checked/password";
        }

        user.setPassword(password);
        userRepository.save(user);
        session.setAttribute("user", user);
        redirectAttributes.addFlashAttribute("securityMessage", new Message(1, "密码修改成功"));
        //修改成功后，删除redis缓存，以便用户可以快速进行下次获取短信验证码
        this.redisTemplate.delete("epassword:" + user.getUsername());
        return "redirect:/home?tab=2";

    }


    //创建新的支付密码
    @PostMapping("/auth/checked/pay/add")
    public String payAdd(
            Principal principal,
            RedirectAttributes redirectAttributes,
            @RequestParam("password") String password
    ) {

        User user = userRepository.findByUsername(principal.getName());
        Account account = user.getAccount();

        //创建新的支付密码页面认证超时
        if (!this.redisTemplate.hasKey("epay:" + user.getUsername())) {
            return "redirect:/auth/check/pay";
        }

        //密码必须为6位，并且为数字
        if (password.length() != 6 || !isNumeric(password)) {
            redirectAttributes.addFlashAttribute("message", new Message(0, "支付密码必须为6位，且为数字！"));
            return "redirect:/auth/checked/pay";
        }

        //如果已经有密码了
        if(account.getPassword()!=null){
            redirectAttributes.addFlashAttribute("message", new Message(0, "非法操作，您已经设置了支付密码！"));
            return "redirect:/auth/checked/pay";
        }

        account.setPassword(password);
        accountRepository.save(account);

        redirectAttributes.addFlashAttribute("securityMessage", new Message(1, "支付密码设置成功"));
        //修改成功后，删除redis缓存，以便用户可以快速进行下次获取短信验证码
        this.redisTemplate.delete("epay:" + user.getUsername());
        return "redirect:/home?tab=2";

    }

    //修改支付密码
    @PostMapping("/auth/checked/pay/update")
    public String payUpdate(
            Principal principal,
            RedirectAttributes redirectAttributes,
            @RequestParam("passwordOld") String passwordOld,
            @RequestParam("password") String password
    ) {

        User user = userRepository.findByUsername(principal.getName());
        Account account = user.getAccount();

        //创建新的支付密码页面认证超时
        if (!this.redisTemplate.hasKey("epay:" + user.getUsername())) {
            return "redirect:/auth/check/pay";
        }

        if(!new BCryptPasswordEncoder().matches(passwordOld,account.getPassword())){
            redirectAttributes.addFlashAttribute("message", new Message(0, "老密码不正确"));
            return "redirect:/auth/checked/pay";
        }

        //密码必须为6位，并且为数字
        if (password.length() != 6 || !isNumeric(password)) {
            redirectAttributes.addFlashAttribute("message", new Message(0, "支付密码必须为6位，且为数字！"));
            return "redirect:/auth/checked/pay";
        }

        account.setPassword(password);
        accountRepository.save(account);

        redirectAttributes.addFlashAttribute("securityMessage", new Message(1, "支付密码修改成功"));
        //修改成功后，删除redis缓存，以便用户可以快速进行下次获取短信验证码
        this.redisTemplate.delete("epay:" + user.getUsername());
        return "redirect:/home?tab=2";

    }

    public boolean isNumeric(String str){
        Pattern pattern = Pattern.compile("[0-9]*");
        Matcher isNum = pattern.matcher(str);
        if( !isNum.matches() ){
            return false;
        }
        return true;
    }


}
