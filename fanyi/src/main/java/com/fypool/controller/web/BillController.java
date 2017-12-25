package com.fypool.controller.web;

import com.fypool.component.HelperController;
import com.fypool.model.*;
import com.fypool.repository.BillRepository;
import com.fypool.repository.UserRepository;
import com.fypool.repository.VipTaskRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.security.Principal;
import java.util.List;

@Controller
public class BillController {

    @Autowired
    BillRepository billRepository;

    @Autowired
    EntityManager entityManager;

    @Autowired
    UserRepository userRepository;

    @Autowired
    HelperController helper;

    @Autowired
    VipTaskRepository vipTaskRepository;

    //显示用户账单
    @GetMapping("/bill")
    public String bill(
            @RequestParam(value = "pay", required = false) Integer pay,
            @RequestParam(value = "id", required = false) Integer id,
            @RequestParam(value = "page", required = false) Integer page,
            HttpSession session,
            Model model
    ) {
        User user = (User) session.getAttribute("user");
        Integer getPage = page == null ? 0 : page;//从0开始的页数
        Pageable pageable = new PageRequest(getPage, 10);
        Page<Bill> bills = billRepository.findAll(BillSpec.getSpec(pay, id, user,null,1,null), pageable);
        Object unpay = entityManager
                .createQuery("select count(*),sum(price) from Bill where pay = 0 and user = :user")
                .setParameter("user", user)
                .getSingleResult();

        model.addAttribute("bills", bills);
        model.addAttribute("account", user.getAccount());
        model.addAttribute("unpay", unpay);
        return "web/client/bill";
    }

    //显示账单详情
    @GetMapping("/bill/detail")
    public String bill(
            @RequestParam("id") Integer id,
            HttpSession session,
            Model model,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");
        Bill bill = billRepository.findByIdAndUser(id, user);
        if (bill == null) {
            redirect.addFlashAttribute("message", new Message(0, "该账单详情不存在"));
            return "redirect:/bill";
        }

        model.addAttribute("bill", bill);
        return "web/client/billDetail";
    }

    //支付单个账单
    @PostMapping("/bill/pay")
    public String billPay(
            @RequestParam("password") String password,
            @RequestParam("id") Integer id,
            HttpSession session,
            Principal principal,
            RedirectAttributes redirect
    ) {
        User user = userRepository.findByUsername(principal.getName());
        Bill bill = billRepository.findByIdAndUserAndPay(id, user, 0);
        if (bill == null) {
            redirect.addFlashAttribute("message", new Message(0, "该账单已结或不存在"));
            return "redirect:/bill";
        }

        //验证支付密码，余额，错误次数
        Message message = helper.checkPayPassword(bill.getPrice(), user, password);
        if (message.getStatus() == 0) {
            redirect.addFlashAttribute("message", message);
            return "redirect:/bill";
        }

        //已经在saveBill中将账单设置为已经支付
        helper.saveBill(bill.getPrice(), user, bill.getType() == 0 ? "vipOnce" : "vipMonth", bill);

        //获取该账单关联的所有账单，并将这所有的账单都设置为已经支付，即off=4
        List<VipTask> vipTasks = bill.getVipTasks();
        for (VipTask vipTask : vipTasks) {
            vipTask.setOff(4);
            vipTaskRepository.save(vipTask);
        }

        redirect.addFlashAttribute("message", new Message(1, "支付成功"));
        return "redirect:/bill";
    }

    //支付全部账单
    @PostMapping("/bill/all/pay")
    public String billAllPay(
            @RequestParam("password") String password,
            HttpSession session,
            Principal principal,
            RedirectAttributes redirect
    ) {
        User user = userRepository.findByUsername(principal.getName());

        //计算未结总额
        Object unpay = entityManager
                .createQuery("select sum(price) from Bill where pay = 0 and user = :user")
                .setParameter("user", user)
                .getSingleResult();

        if (unpay == null) {
            redirect.addFlashAttribute("message", new Message(0, "您没有未结账单"));
            return "redirect:/bill";
        }

        //验证支付密码，余额，错误次数
        Message message = helper.checkPayPassword(new BigDecimal(unpay.toString()), user, password);
        if (message.getStatus() == 0) {
            redirect.addFlashAttribute("message", message);
            return "redirect:/bill";
        }

        //找出所有的未结账单，一个一个付
        List<Bill> bills = billRepository.findAllByUserAndPay(user, 0);

        if (bills.size() == 0) {
            redirect.addFlashAttribute("message", new Message(0, "您没有未结账单"));
            return "redirect:/bill";
        }

        for (Bill bill : bills) {
            //先付钱
            helper.saveBill(bill.getPrice(), user, bill.getType() == 0 ? "vipOnce" : "vipMonth", bill);
            //获取该账单关联的所有账单，并将这所有的账单都设置为已经支付，即off=4
            List<VipTask> vipTasks = bill.getVipTasks();
            for (VipTask vipTask : vipTasks) {
                vipTask.setOff(4);
                vipTaskRepository.save(vipTask);
            }
        }

        redirect.addFlashAttribute("message", new Message(1, "全部支付成功"));
        return "redirect:/bill";
    }

}
