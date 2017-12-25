package com.fypool.controller.web;

import com.fypool.model.Role;
import com.fypool.model.User;
import com.fypool.repository.RoleRepository;
import com.fypool.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.security.Principal;
import java.util.ArrayList;
import java.util.Collection;
import java.util.List;

@Controller
public class SwitchController {
    @Autowired
    UserRepository userRepository;

    @Autowired
    RoleRepository roleRepository;

    @GetMapping({"/switch/user"})
    public String switchToUser(HttpServletRequest request,HttpSession session){
        User user = userRepository.findByUsername(request.getUserPrincipal().getName());
        //判断是否已经有译员角色
        if(request.isUserInRole("ROLE_USER")){
            //是的话，把当前角色设置成ROLE_USER,再回到userHome
            user.setCurrentRole("ROLE_USER");
            userRepository.save(user);
            //刷新缓存
            session.setAttribute("user",user);
            return "redirect:/info";
        }else{
            //否的话，要先注册译员
            return "web/client/registerUser";
        }
    }

    @GetMapping("/client/registerUser")
    public String registerUser(HttpServletRequest request,HttpSession session){
        User user = userRepository.findByUsername(request.getUserPrincipal().getName());
        List<Role> roles = user.getRoles();
        roles.add(roleRepository.findByName("ROLE_USER"));
        user.setRoles(roles);
        user.setCurrentRole("ROLE_USER");
        userRepository.save(user);
        Authentication authentication = new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities());
        SecurityContextHolder.getContext().setAuthentication(authentication);
        //刷新缓存
        session.setAttribute("user",user);
        return "redirect:/info";
    }

    @GetMapping({"/switch/client"})
    public String switchToClient(HttpServletRequest request,HttpSession session){
        User user = userRepository.findByUsername(request.getUserPrincipal().getName());
        if(request.isUserInRole("ROLE_CLIENT")){
            user.setCurrentRole("ROLE_CLIENT");
            userRepository.save(user);
            session.setAttribute("user",user);
            return "redirect:/info";
        }else{
            return "web/user/registerClient";
        }
    }

    @GetMapping("/user/registerClient")
    public String registerClient(HttpServletRequest request,HttpSession session){
        User user = userRepository.findByUsername(request.getUserPrincipal().getName());
        List<Role> roles = user.getRoles();
        roles.add(roleRepository.findByName("ROLE_CLIENT"));
        user.setRoles(roles);
        user.setCurrentRole("ROLE_CLIENT");
        userRepository.save(user);
        Authentication authentication = new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities());
        SecurityContextHolder.getContext().setAuthentication(authentication);
        //刷新缓存
        session.setAttribute("user",user);
        return "redirect:/info";
    }


}
