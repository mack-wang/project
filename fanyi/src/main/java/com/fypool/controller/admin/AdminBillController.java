package com.fypool.controller.admin;

import com.fypool.component.HelperController;
import com.fypool.component.SmsUtils;
import com.fypool.model.Bill;
import com.fypool.model.BillSpec;
import com.fypool.model.Message;
import com.fypool.model.User;
import com.fypool.repository.BillRepository;
import com.fypool.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.http.HttpRequest;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

@Controller
public class AdminBillController {

    @Autowired
    BillRepository billRepository;

    @Autowired
    EntityManager entityManager;

    @Autowired
    SmsUtils smsUtils;

    @Autowired
    HelperController helper;

    @Autowired
    UserRepository userRepository;

    @Value("${customer.service.phone}")
    private String servicePhone;

    //显示所有用户账单
    @GetMapping("/admin/bill")
    public String bill(
            HttpServletRequest request,
            HttpSession session,
            Model model
    ) {
        session.setAttribute("menu", "adminvip");
        Map<String, String[]> map = request.getParameterMap();
        Integer page = map.containsKey("page") ? Integer.valueOf(map.get("page")[0]) : 0;//从0开始的页数
        Integer id = map.containsKey("id") ? Integer.valueOf(map.get("id")[0]) : null;
        Integer pay = map.containsKey("pay") ? Integer.valueOf(map.get("pay")[0]) : null;
        Pageable pageable = new PageRequest(page, 10);
        User user = null;
        String month = map.containsKey("month") ? map.get("month")[0] : null;
        Integer send = map.containsKey("send") ? Integer.valueOf(map.get("send")[0]) : null;
        Integer type = map.containsKey("type") ? Integer.valueOf(map.get("type")[0]) : null;

        if (map.containsKey("phone")) {
            user = userRepository.findByAttribute_Phone(map.get("phone")[0]);
        }
        if (map.containsKey("username")) {
            user = userRepository.findByUsername(map.get("username")[0]);
        }

        Page<Bill> bills = billRepository.findAll(BillSpec.getSpec(pay, id, user, month, send,type), pageable);

        model.addAttribute("bills", bills);
        return "admin/task/bill";
    }

    //显示账单详情
    @GetMapping("/admin/bill/detail")
    public String bill(
            @RequestParam("id") Integer id,
            Model model,
            RedirectAttributes redirect
    ) {
        Bill bill = billRepository.findOne(id);
        if (bill == null) {
            redirect.addFlashAttribute("message", new Message(0, "该账单详情不存在"));
            return "redirect:/admin/bill";
        }

        model.addAttribute("bill", bill);
        return "admin/task/billDetail";
    }


    //发送1个，多个，全部月账单,选择发送
    @PostMapping("/admin/selected/bill/send")
    public String selectedBillSend(
            @RequestParam("ids") String ids,
            RedirectAttributes redirect
    ) {

        //找出所有没发送的月结账单 send = 0
        List<Integer> idList = new ArrayList<>();
        if (ids.length() == 0) {
            redirect.addFlashAttribute("message", new Message(0, "未选择任何月账单"));
            return "redirect:/admin/bill";
        }
        String[] idStrs = ids.split(",");

        for (String idStr : idStrs) {
            idList.add(Integer.valueOf(idStr));
        }

        List<Bill> bills = billRepository.findAllBySendAndTypeAndIdIn(0, 1, idList);

        for (Bill bill : bills) {
            User user = bill.getUser();
            //发邮件
            String email = user.getAttribute().getEmail();
            if (email != null) {
                helper.sendEmailBill(email, "领骄翻易VIP客户" + bill.getMonth() + "月月结账单已出，请查收。", bill, user);
            }

            //发送账单短信
            smsUtils.sendBill(user.getAttribute().getPhone(), user.getAttribute().getNickname(), bill.getMonth() + "VIP月结", bill.getPrice().toString(), servicePhone);

            //账单设置为发送状态
            bill.setSend(1);
            billRepository.save(bill);
        }


        redirect.addFlashAttribute("message", new Message(1, "月结账单已经全部发送"));
        return "redirect:/admin/bill";
    }


}
