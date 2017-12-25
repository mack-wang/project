package com.fypool.controller.admin;

import com.fypool.model.*;
import com.fypool.repository.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.util.ArrayList;

@Controller
public class AdminCustomerServiceController {

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
    CustomerServiceRepository customerServiceRepository;

    //在线客服管理,分页
    @GetMapping("/admin/customer/service")
    public String customerService(Model model, @RequestParam(value = "page", required = false) Integer page, HttpSession session) {
        session.setAttribute("menu", "manager");
        Integer getPage = page == null ? 0 : page;
        Sort sort = new Sort(Sort.Direction.DESC, "createdAt");
        Pageable pageable = new PageRequest(getPage, 10, sort);
        model.addAttribute("services", customerServiceRepository.findAll(pageable));
        return "admin/customerService";
    }

    //添加管理员到客服
    @PostMapping("/admin/customer/service/add")
    public String customerServiceAdd(
            @RequestParam("username") String username,
            RedirectAttributes redirect
    ) {
        //判断管理员是否存在
        User user = userRepository.findByUsernameAndCurrentRole(username,"ROLE_ADMIN");
        if (user == null) {
            redirect.addFlashAttribute("message", new Message(0, "该管理员不存在"));
            return "redirect:/admin/customer/service";
        }

        if(customerServiceRepository.existsByUser(user)){
            redirect.addFlashAttribute("message", new Message(0, "该管理员已经成为客服，不能重复添加！"));
            return "redirect:/admin/customer/service";
        }

        //添加新客服
        customerServiceRepository.save(new CustomerService(user,1));

        redirect.addFlashAttribute("message", new Message(1, "新客服添加成功"));
        return "redirect:/admin/customer/service";
    }

    //客服上线
    @GetMapping("/admin/customer/service/online")
    public String customerServiceOnline(RedirectAttributes redirect, @RequestParam("id") Integer id) {
        CustomerService customerService = customerServiceRepository.findOne(id);
        customerService.setOnline(1);
        customerServiceRepository.save(customerService);

        redirect.addFlashAttribute("message", new Message(1, "上线成功"));
        return "redirect:/admin/customer/service";
    }

    @GetMapping("/admin/customer/service/offline")
    public String customerServiceOffline(RedirectAttributes redirect, @RequestParam("id") Integer id) {
        CustomerService customerService = customerServiceRepository.findOne(id);
        customerService.setOnline(0);
        customerServiceRepository.save(customerService);

        redirect.addFlashAttribute("message", new Message(1, "下线成功"));
        return "redirect:/admin/customer/service";
    }


}
