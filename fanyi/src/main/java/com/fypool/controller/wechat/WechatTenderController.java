package com.fypool.controller.wechat;

import com.fypool.model.*;
import com.fypool.repository.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;

import javax.servlet.http.HttpSession;

@Controller
//译员已接任务展示，译员已经投标的任务展示
public class WechatTenderController {

    @Autowired
    TaskUserRepository taskUserRepository;

    @GetMapping("/wechat/auth/tender")
    public String tender(
            @RequestParam(value = "page", required = false) Integer page,
            @RequestParam(value = "process", required = false) Integer process,
            @RequestParam(value = "type", required = false) Integer type,
            HttpSession session,
            Model model
    ) {
        Integer getPage = page == null ? 0 : page;
        //找出译员所有的投标任务
        User user = (User) session.getAttribute("user");
        Sort sort = new Sort(Sort.Direction.DESC, "createdAt");
        Pageable pageable = new PageRequest(getPage, 5, sort);
        Page<TaskUser> taskUsers = taskUserRepository.findAll(TaskUserSpec.getSpec(process,type,user),pageable);

        model.addAttribute("taskUsers",taskUsers);
        session.setAttribute("menu","tender");
        return "web/wechat/taskTender";
    }



}
