package com.fypool.controller.web;

import com.fypool.model.Article;
import com.fypool.model.ArticleSpec;
import com.fypool.model.Catalog;
import com.fypool.model.User;
import com.fypool.repository.*;
import org.hashids.Hashids;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpSession;
import java.security.Principal;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

@Controller
public class InfoController {


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

    @GetMapping("/info")
    public String info(Model model, Principal principal, HttpSession session) {

        User user = userRepository.findByUsername(principal.getName());

        //如果是管理员，则直接跳转到nav
        if(user.getCurrentRole().equals("ROLE_ADMIN")){
            return "redirect:/admin/nav";
        }

        Integer active = 0;
        Integer translate = 0;
        Integer checked = 0;
        Integer comment = 0;
        Hashids hashids = new Hashids(salt, 6);

        if(user.getCurrentRole().equals("ROLE_CLIENT")){
            //已经发布
            active = taskRepository.countAllByUser(user);
            //正在翻译
            translate = taskRepository.countAllByUserAndProcess_Process(user,1);
            //等待审核
            checked = taskRepository.countAllByUserAndProcess_Process(user,2);
            //等待评价
            comment = taskRepository.countAllByUserAndProcess_Process(user,3);
        }else{
            //已投标
            active = taskUserRepository.countAllByUser(user);
            //待翻译
            translate = processRepository.countAllByUserAndProcess(user,1);
            //待审核
            checked = processRepository.countAllByUserAndProcess(user,2);
            //待评价
            comment = processRepository.countAllByUserAndProcess(user,3);
        }


        model.addAttribute("user", user);
        model.addAttribute("active", active);
        model.addAttribute("translate", translate);
        model.addAttribute("checked", checked);
        model.addAttribute("comment", comment);
        model.addAttribute("hashid", hashids.encode(user.getId()));
        session.setAttribute("menu","info");
        return "web/information";
    }


}
