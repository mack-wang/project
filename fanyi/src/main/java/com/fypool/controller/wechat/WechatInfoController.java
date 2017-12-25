package com.fypool.controller.wechat;

import com.fypool.model.User;
import com.fypool.repository.ProcessRepository;
import com.fypool.repository.TaskRepository;
import com.fypool.repository.TaskUserRepository;
import com.fypool.repository.UserRepository;
import org.hashids.Hashids;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpSession;
import java.security.Principal;

@Controller
public class WechatInfoController {


    @Autowired
    UserRepository userRepository;

    @Autowired
    EntityManager entityManager;

    @Autowired
    TaskRepository taskRepository;

    @Autowired
    TaskUserRepository taskUserRepository;

    @Autowired
    ProcessRepository processRepository;


    @Value("${customer.hashid.salt}")
    private String salt;

    @GetMapping("/wechat/auth/info")
    public String info(Model model, Principal principal, HttpSession session) {

        User user = userRepository.findByUsername(principal.getName());

        if (user.getOpenId() == null) {
            Object openId = session.getAttribute("openId");
            if(openId==null){
                //如果openId不存在，则跳转前去获取
                return "redirect:/wechat/public/relogin";
            }else{
                //如果用户没有openId，则立即保存用户的openId
                String openIdStr = openId.toString();
                //检查这个openId是否已经被使用
                User user1 = userRepository.findByOpenId(openIdStr);
                if (user1 != null) {
                    //把已经有这个openid的用户的openid重置为null
                    user1.setOpenId(null);
                    userRepository.save(user1);
                } else {
                    user.setOpenId(openIdStr);
                    userRepository.save(user);
                }
            }
        }

        Integer active = 0;
        Integer translate = 0;
        Integer checked = 0;
        Integer comment = 0;
        Hashids hashids = new Hashids(salt, 6);

        if (user.getCurrentRole().equals("ROLE_CLIENT")) {
            //已经发布
            active = taskRepository.countAllByUser(user);
            //正在翻译
            translate = taskRepository.countAllByUserAndProcess_Process(user, 1);
            //等待审核
            checked = taskRepository.countAllByUserAndProcess_Process(user, 2);
            //等待评价
            comment = taskRepository.countAllByUserAndProcess_Process(user, 3);
        } else {
            //已投标
            active = taskUserRepository.countAllByUser(user);
            //待翻译
            translate = processRepository.countAllByUserAndProcess(user, 1);
            //待审核
            checked = processRepository.countAllByUserAndProcess(user, 2);
            //待评价
            comment = processRepository.countAllByUserAndProcess(user, 3);
        }


        model.addAttribute("user", user);
        model.addAttribute("active", active);
        model.addAttribute("translate", translate);
        model.addAttribute("checked", checked);
        model.addAttribute("comment", comment);
        model.addAttribute("hashid", hashids.encode(user.getId()));
        session.setAttribute("menu", "info");
        return "web/wechat/information";
    }


}
