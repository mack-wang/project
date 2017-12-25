package com.fypool.controller.wechat;

import com.fypool.component.HelperController;
import com.fypool.model.Message;
import com.fypool.model.User;
import com.fypool.repository.UserRepository;
import me.chanjar.weixin.common.exception.WxErrorException;
import me.chanjar.weixin.mp.api.WxMpService;
import me.chanjar.weixin.mp.bean.result.WxMpOAuth2AccessToken;
import me.chanjar.weixin.mp.bean.result.WxMpUser;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.authentication.RememberMeAuthenticationToken;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.web.authentication.RememberMeServices;
import org.springframework.security.web.authentication.logout.CookieClearingLogoutHandler;
import org.springframework.security.web.authentication.logout.SecurityContextLogoutHandler;
import org.springframework.security.web.authentication.rememberme.AbstractRememberMeServices;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletRequestWrapper;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.security.Principal;

@Controller
public class WechatLoginController {

    @Autowired
    private WxMpService wxMpService;

    @Autowired
    UserRepository userRepository;

    @Autowired
    HelperController helper;

    @Autowired
    RememberMeServices rememberMeServices;

    //登入
    @GetMapping("/wechat/public/login")
    public String login(HttpServletRequest request, HttpSession session) throws WxErrorException {

        //判断用户是否登入
        if (session.getAttribute("user") == null) {
            //如果会话中没有openId，就主动去获取，如果有了，就跳过
            if (session.getAttribute("openId") == null) {
                String code = request.getParameter("code");
                WxMpOAuth2AccessToken wxMpOAuth2AccessToken = wxMpService.oauth2getAccessToken(code);
                WxMpUser wxMpUser = wxMpService.oauth2getUserInfo(wxMpOAuth2AccessToken, null);
                session.setAttribute("openId", wxMpUser.getOpenId());
            }

            //跳转去登入
            return "redirect:/wechat/login";
        } else {
            //跳转到市场
            return "redirect:/wechat/auth/market";
        }
    }

    //显示重新登入的页面
    @GetMapping("/wechat/public/relogin")
    public String relogin(){
        return "web/wechat/relogin";
    }

    //如果用户没有openId，则重新获取，并重新登入
    @GetMapping("/wechat/public/relogin/openid")
    public String relogin(HttpServletRequest request, HttpSession session) throws WxErrorException {
        String code = request.getParameter("code");
        WxMpOAuth2AccessToken wxMpOAuth2AccessToken = wxMpService.oauth2getAccessToken(code);
        WxMpUser wxMpUser = wxMpService.oauth2getUserInfo(wxMpOAuth2AccessToken, null);
        session.setAttribute("openId", wxMpUser.getOpenId());
        //判断用户是否登入
        return "redirect:/wechat/login";
    }


    //个人中心
    @GetMapping("/wechat/public/info")
    public String fastQuery(HttpServletRequest request, HttpSession session) throws WxErrorException {

        //如果会话中没有openId，就主动去获取，如果有了，就跳过
        if (session.getAttribute("openId") == null) {
            String code = request.getParameter("code");
            WxMpOAuth2AccessToken wxMpOAuth2AccessToken = wxMpService.oauth2getAccessToken(code);
            WxMpUser wxMpUser = wxMpService.oauth2getUserInfo(wxMpOAuth2AccessToken, null);
            session.setAttribute("openId", wxMpUser.getOpenId());
        }

        //跳转去
        return "redirect:/wechat/auth/info";
    }

    //快速查询
    @GetMapping("/wechat/public/market")
    public String market(HttpServletRequest request, HttpSession session) throws WxErrorException {

        //如果会话中没有openId，就主动去获取，如果有了，就跳过
        if (session.getAttribute("openId") == null) {
            String code = request.getParameter("code");
            WxMpOAuth2AccessToken wxMpOAuth2AccessToken = wxMpService.oauth2getAccessToken(code);
            WxMpUser wxMpUser = wxMpService.oauth2getUserInfo(wxMpOAuth2AccessToken, null);
            session.setAttribute("openId", wxMpUser.getOpenId());
        }

        //跳转去
        return "redirect:/wechat/auth/market";
    }

    @GetMapping("/wechat/login")
    public String wechatLogin() {
        return "web/wechat/login";
    }

    @GetMapping("/wechat/login/phone")
    public String loginPhone(Model model) {
        model.addAttribute("tab", new Message(1));
        return "web/wechat/login";
    }


    @PostMapping("/wechat/login")
    public String loginByUsername(
            @RequestParam("username") String username,
            @RequestParam("password") String password,
            @RequestParam(value = "remember-me",required = false) String rememberMe,
            RedirectAttributes redirect,
            HttpSession session,
            HttpServletRequest request,
            HttpServletResponse response
    ) {
        User user = userRepository.findByUsername(username);
        if (user == null) {
            redirect.addFlashAttribute("firstMessage", new Message(0, "用户名或密码错误"));
            return "redirect:/wechat/login";
        }
        //检查密码
        BCryptPasswordEncoder crypt = new BCryptPasswordEncoder();
        if (crypt.matches(password, user.getPassword())) {
            //手动创建授权
            Authentication authentication = new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities());
            //刷新授权并登入
            SecurityContextHolder.getContext().setAuthentication(authentication);

            //记住我
            if("on".equals(rememberMe)){
                rememberMeServices.loginSuccess(request, response, authentication);
            }

            session.setAttribute("user", user);
            return "redirect:/wechat/auth/market";
        } else {
            redirect.addFlashAttribute("firstMessage", new Message(0, "用户名或密码错误"));
            return "redirect:/wechat/login";
        }
    }

    @PostMapping("/wechat/login/phone")
    public String loginByPhone(
            @RequestParam("phone") String phone,
            @RequestParam("sms") Integer sms,
            @RequestParam("password2") String password,
            @RequestParam(value = "remember-me",required = false) String rememberMe,
            RedirectAttributes redirect,
            HttpSession session,
            HttpServletRequest request,
            HttpServletResponse response
    ) {
        //检查手机号是否存在
        User user = userRepository.findByAttribute_Phone(phone);
        if (user == null) {
            redirect.addFlashAttribute("secondMessage", new Message(0, "手机号或者密码错误"));
            return "redirect:/login/phone";
        }

        //检查密码
        if (password.length() != 0) {
            BCryptPasswordEncoder crypt = new BCryptPasswordEncoder();
            if (crypt.matches(password, user.getPassword())) {
                //手动创建授权
                Authentication authentication = new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities());

                //刷新授权并登入
                SecurityContextHolder.getContext().setAuthentication(authentication);

                //记住我
                if("on".equals(rememberMe)){
                    rememberMeServices.loginSuccess(request, response, authentication);
                }

                session.setAttribute("user", user);
                return "redirect:/wechat/auth/market";
            } else {
                redirect.addFlashAttribute("secondMessage", new Message(0, "手机号或密码错误"));
                return "redirect:/wechat/login/phone";
            }
        }

        //检查短信
        if (helper.verifySms(phone, sms)) {
            //手动创建授权
            Authentication authentication = new UsernamePasswordAuthenticationToken(user, user.getPassword(), user.getAuthorities());
            //刷新授权并登入
            SecurityContextHolder.getContext().setAuthentication(authentication);
            session.setAttribute("user", user);
            return "redirect:/wechat/auth/market";
        } else {
            redirect.addFlashAttribute("secondMessage", new Message(0, "短信验证码错误"));
            return "redirect:/wechat/login/phone";
        }
    }

    //手动退出
    @PostMapping("/wechat/logout")
    public String logoutPage(HttpServletRequest request, HttpServletResponse response) {
        Authentication auth = SecurityContextHolder.getContext().getAuthentication();
        if (auth != null) {
            CookieClearingLogoutHandler cookieClearingLogoutHandler = new CookieClearingLogoutHandler(AbstractRememberMeServices.SPRING_SECURITY_REMEMBER_ME_COOKIE_KEY);
            SecurityContextLogoutHandler securityContextLogoutHandler = new SecurityContextLogoutHandler();
            cookieClearingLogoutHandler.logout(request, response, auth);
            securityContextLogoutHandler.logout(request, response, auth);
        }

        return "redirect:/wechat/login";
    }

}
