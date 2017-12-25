package com.fypool.controller.admin;

import com.fypool.repository.BillRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

@Controller
public class AdminShowEmailController {
    @Autowired
    BillRepository billRepository;

    //显示月结账单邮件
    @GetMapping("/admin/show/email/emailBill/one")
    public String showEmailBillOne(Model model){
        model.addAttribute("title","测试标题");
        model.addAttribute("head","您好！张爱玲女士：");
        model.addAttribute("bill",billRepository.findOne(4));
        return "email/emailBill";
    }

    //显示次结账单邮件
    @GetMapping("/admin/show/email/emailBill/two")
    public String showEmailBillTwo(Model model){
        model.addAttribute("title","测试标题");
        model.addAttribute("head","您好！张爱玲女士：");
        model.addAttribute("bill",billRepository.findOne(1));
        return "email/emailBill";
    }

    //显示普通回复邮件
    @GetMapping("/admin/show/email/emailRespond")
    public String showEmailRespond(Model model){
        model.addAttribute("title","测试标题");
        model.addAttribute("head","您好！张爱玲女士：");
        model.addAttribute("content","测试内容");
        return "email/emailRespond";
    }

    @GetMapping("/admin/show/email/emailTemplate")
    public String showEmailTemplate(Model model){
        model.addAttribute("username","张爱玲");
        return "email/emailTemplate";
    }
}
