package com.fypool.controller.wechat;

import com.fypool.model.User;
import com.fypool.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;

import javax.servlet.http.HttpSession;
import java.security.Principal;

@Controller
public class WechatMyTaskController {

    @Autowired
    UserRepository userRepository;

    @GetMapping("/wechat/auth/mytask")
    public String myTask(Principal principal, HttpSession session) {
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

        if (user.getCurrentRole().equals("ROLE_CLIENT")) {
            //如果是客户，则显示他的发布任务
            return "redirect:/wechat/auth/process";
        } else {
            //如果是译员，则显示他接的任务
            return "redirect:/wechat/auth/tender";
        }
    }
}
