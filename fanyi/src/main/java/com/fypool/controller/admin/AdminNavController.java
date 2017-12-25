package com.fypool.controller.admin;


import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpSession;
import java.util.Calendar;
import java.util.Date;

@Controller
public class AdminNavController {

    @Autowired
    EntityManager entityManager;

    @GetMapping("/admin/nav")
    public String adminNav(Model model, HttpSession session){
        Calendar c = Calendar.getInstance();
        c.setTime(new Date());
        c.add(Calendar.DATE,-7);

        Object users = entityManager.createQuery("select count(*) from User where createdAt > :day")
                .setParameter("day",c.getTime())
                .getSingleResult();

        Object questions = entityManager.createQuery("select count(*) from Question where result = 0")
                .getSingleResult();

        Object reports = entityManager.createQuery("select count(*) from ReportIllegal where result = 0")
                .getSingleResult();

        Object checks = entityManager.createQuery("select count(*) from AdminCheckCertificate where certificateCheck = 0 or companyCheck = 0 or realNameCheck = 0")
                .getSingleResult();

        Object invoices = entityManager.createQuery("select count(*) from InvoiceRequest where result = 0")
                .getSingleResult();

        Object signatures = entityManager.createQuery("select count(*) from SignatureRequest where result = 0")
                .getSingleResult();

        Object fileClean = entityManager.createQuery("select sum(counts),sum(size) from FileClean")
                .getSingleResult();

        model.addAttribute("users",users);
        model.addAttribute("questions",questions);
        model.addAttribute("reports",reports);
        model.addAttribute("checks",checks);
        model.addAttribute("invoices",invoices);
        model.addAttribute("signatures",signatures);
        model.addAttribute("fileClean",fileClean);
        session.setAttribute("menu","nav");
        return "admin/nav";
    }
}
