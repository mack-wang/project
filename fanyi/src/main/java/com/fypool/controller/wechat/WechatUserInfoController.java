package com.fypool.controller.wechat;

import com.fypool.model.User;
import com.fypool.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ResponseBody;

import javax.servlet.http.HttpSession;
import java.security.Principal;

@Controller
public class WechatUserInfoController {

    @Autowired
    UserRepository userRepository;

    @GetMapping("/wechat/auth/fastQuery")
    public @ResponseBody
    String fastQuery(HttpSession session, Principal principal){
        User user = userRepository.findByUsername(principal.getName());
        if(user.getOpenId()==null){
            //如果用户没有openId，则立即保存用户的openId
            String openId = session.getAttribute("openId").toString();
            user.setOpenId(openId);
            userRepository.save(user);
        }
        return session.getAttribute("openId").toString();
    }
}
