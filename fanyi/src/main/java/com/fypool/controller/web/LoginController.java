package com.fypool.controller.web;

import com.fypool.component.HelperController;
import com.fypool.model.Message;
import com.fypool.model.User;
import com.fypool.repository.AttributeRepository;
import com.fypool.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.web.authentication.RememberMeServices;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

@Controller
public class LoginController {
    @Autowired
    AttributeRepository attributeRepository;

    @Autowired
    UserRepository userRepository;

    @Autowired
    HelperController helper;

    @Autowired
    RememberMeServices rememberMeServices;



    @GetMapping("login")
    public String login(){
        return "web/login";
    }


    @GetMapping("/login/phone")
    public String loginPhone(Model model){
        model.addAttribute("tab",new Message(1));
        return "web/login";
    }


    @PostMapping("/login/phone")
    public String loginByPhone(
            @RequestParam("phone") String phone,
            @RequestParam("sms") Integer sms,
            @RequestParam("password2") String password,
            @RequestParam(value = "remember-me",required = false) String rememberMe,
            RedirectAttributes redirect,
            HttpSession session,
            HttpServletResponse response,
            HttpServletRequest request
    ){

        //检查手机号是否存在
        User user =  userRepository.findByAttribute_Phone(phone);
        if(user == null){
            redirect.addFlashAttribute("secondMessage",new Message(0,"手机号或者密码错误"));
            return "redirect:/login/phone";
        }

        //检查密码
        if(password.length() != 0){
            BCryptPasswordEncoder crypt = new BCryptPasswordEncoder();
            if(crypt.matches(password,user.getPassword())){
                //手动创建授权
                    Authentication authentication = new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities());

                //刷新授权并登入
                SecurityContextHolder.getContext().setAuthentication(authentication);

                //记住我
                if("on".equals(rememberMe)){
                    rememberMeServices.loginSuccess(request, response, authentication);
                }


                session.setAttribute("user",user);
                return "redirect:/info";
            }else{
                redirect.addFlashAttribute("secondMessage",new Message(0,"手机号或密码错误"));
                return "redirect:/login/phone";
            }
        }

        //检查短信
        if(helper.verifySms(phone,sms)){
            //手动创建授权
            Authentication authentication = new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities());
            //刷新授权并登入
            SecurityContextHolder.getContext().setAuthentication(authentication);

            //记住我
            if("on".equals(rememberMe)){
                rememberMeServices.loginSuccess(request, response, authentication);
            }

            session.setAttribute("user",user);
            return "redirect:/market";
        }else{
            redirect.addFlashAttribute("secondMessage",new Message(0,"短信验证码错误"));
            return "redirect:/login/phone";
        }
    }
}
