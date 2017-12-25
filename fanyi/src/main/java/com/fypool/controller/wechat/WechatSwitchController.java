package com.fypool.controller.wechat;

import com.fypool.model.Role;
import com.fypool.model.User;
import com.fypool.repository.*;
import org.hashids.Hashids;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.security.Principal;
import java.util.List;

@Controller
public class WechatSwitchController {


    @Autowired
    UserRepository userRepository;

    @Autowired
    RoleRepository roleRepository;

    @GetMapping("/wechat/auth/switch/user")
    public String switchToUser(HttpServletRequest request, HttpSession session){
        User user = userRepository.findByUsername(request.getUserPrincipal().getName());
        //判断是否已经有译员角色
        if(request.isUserInRole("ROLE_USER")){
            //是的话，把当前角色设置成ROLE_USER,再回到userHome
            user.setCurrentRole("ROLE_USER");
            userRepository.save(user);
            //刷新缓存
            session.setAttribute("user",user);
            return "redirect:/wechat/auth/info";
        }else{
            //非法操作，去重新登入
            return "redirect:/wechat/public/relogin";
        }
    }

    @GetMapping("/wechat/auth/switch/client")
    public String switchToClient(HttpServletRequest request,HttpSession session){
        User user = userRepository.findByUsername(request.getUserPrincipal().getName());
        if(request.isUserInRole("ROLE_CLIENT")){
            user.setCurrentRole("ROLE_CLIENT");
            userRepository.save(user);
            session.setAttribute("user",user);
            return "redirect:/wechat/auth/info";
        }else{
            //非法操作，去重新登入
            return "redirect:/wechat/public/relogin";
        }
    }



}
