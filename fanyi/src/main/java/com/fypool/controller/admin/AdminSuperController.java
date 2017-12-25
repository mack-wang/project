package com.fypool.controller.admin;

import com.fypool.component.SmsUtils;
import com.fypool.model.*;
import com.fypool.repository.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.Random;

@Controller
public class AdminSuperController {

    @Autowired
    RoleRepository roleRepository;

    @Autowired
    UserRepository userRepository;

    @Autowired
    AttributeRepository attributeRepository;

    @Autowired
    AccountRepository accountRepository;

    @Autowired
    UserInfoRepository userInfoRepository;

    @Autowired
    SmsUtils smsUtils;

    //超级管理员

    //创建管理员账号
    @GetMapping("/admin/super/add/admin")
    public String addAdmin(HttpSession session) {
        session.setAttribute("menu","superAdmin");
        return "admin/super/addAdmin";
    }

    @PostMapping("/admin/super/add/admin")
    public String addAdminPost(
            @RequestParam("username") String username,
            @RequestParam("phone") String phone,
            @RequestParam("password") String password,
            RedirectAttributes redirect
    ) {
        Boolean hasUsername = userRepository.existsByUsername(username);
        if (hasUsername) {
            redirect.addFlashAttribute("message", new Message(0, "该用户已经被使用，请更换"));
            return "redirect:/admin/super/add/admin";
        }

        Boolean hasPhone = attributeRepository.existsByPhone(phone);
        if (hasPhone) {
            redirect.addFlashAttribute("message", new Message(0, "该手机号已经被使用，请更换"));
            return "redirect:/admin/super/add/admin";
        }

        ArrayList<Role> roles = new ArrayList<>();
        roles.add(roleRepository.findByName("ROLE_ADMIN"));
        //创建用户
        User user = new User();
        user.setRoles(roles);
        user.setUsername(username);
        user.setPassword(password);
        user.setCurrentRole("ROLE_ADMIN");
        userRepository.save(user);

        //再创建属性
        Attribute attribute = new Attribute("翻易管理员", phone, user);
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

        redirect.addFlashAttribute("message", new Message(1, "新管理员账号创建成功"));
        return "redirect:/admin/super/add/admin";
    }

    //修改管理员或用户的密码
    //管理员离职后修改密码
    //用户忘记密码并且手机号也无法使用时重置密码
    @GetMapping("/admin/super/reset/password")
    public String resetPassword(HttpSession session) {
        session.setAttribute("menu","superAdmin");
        return "admin/super/resetPassword";
    }

    @PostMapping("/admin/super/reset/password")
    public String resetPasswordPost(
            @RequestParam("username") String username,
            @RequestParam("password") String password,
            RedirectAttributes redirect
    ) {
        User user = userRepository.findByUsername(username);
        if (user == null) {
            redirect.addFlashAttribute("message", new Message(0, "用户不存在"));
            return "redirect:/admin/super/reset/password";
        }

        user.setPassword(password);
        userRepository.save(user);

        redirect.addFlashAttribute("message", new Message(1, "用户密码重置成功"));
        return "redirect:/admin/super/reset/password";
    }

    //重置手机号
    @GetMapping("/admin/super/reset/phone")
    public String resetPhone(HttpSession session) {
        session.setAttribute("menu","superAdmin");
        return "admin/super/resetPhone";
    }

    @PostMapping("/admin/super/reset/phone")
    public String resetPhonePost(
            @RequestParam("username") String username,
            @RequestParam("phone") String phone,
            RedirectAttributes redirect
    ) {
        User user = userRepository.findByUsername(username);
        if (user == null) {
            redirect.addFlashAttribute("message", new Message(0, "用户不存在"));
            return "redirect:/admin/super/reset/phone";
        }

        user.getAttribute().setPhone(phone);
        userRepository.save(user);

        redirect.addFlashAttribute("message", new Message(1, "用户手机号重置成功"));
        return "redirect:/admin/super/reset/phone";
    }

    //重置支付密码
    @GetMapping("/admin/super/reset/payPassword")
    public String resetPayPassword(HttpSession session) {
        session.setAttribute("menu","superAdmin");
        return "admin/super/resetPayPassword";
    }

    @PostMapping("/admin/super/reset/payPassword")
    public String resetPayPasswordPost(
            @RequestParam("username") String username,
            RedirectAttributes redirect
    ) {
        User user = userRepository.findByUsername(username);
        if (user == null) {
            redirect.addFlashAttribute("message", new Message(0, "用户不存在"));
            return "redirect:/admin/super/reset/payPassword";
        }

        //随机生成6位数字的支付密码
        Random rand = new Random();
        Integer randNumber = rand.nextInt(800000)+100000;
        String password = randNumber.toString();
        user.getAccount().setPassword(password);
        userRepository.save(user);

        smsUtils.sendPayPassword(user.getAttribute().getPhone(),user.getAttribute().getNickname(),password);
        redirect.addFlashAttribute("message", new Message(1, "用户支付密码重置成功"));
        return "redirect:/admin/super/reset/payPassword";
    }

    //管理员离职
    //先将手机号更换为11位随机数字
    //再将密码更换为私有密码

    //等下一位新职员来的时候，更换绑定手机号和登入密码
}
