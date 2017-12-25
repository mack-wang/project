package com.fypool.controller.wechat;

import com.fypool.model.*;
import com.fypool.repository.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.util.Date;
import java.util.Map;

@Controller
public class WechatVipController {

    @Autowired
    UserRepository userRepository;

    @Autowired
    VipTaskRepository vipTaskRepository;

    @Autowired
    BillRepository billRepository;

    @Autowired
    InvoiceRepository invoiceRepository;

    @Autowired
    InvoiceRequestRepository invoiceRequestRepository;

    @Autowired
    SignatureRequestRepository signatureRequestRepository;

    @Autowired
    AddressRepository addressRepository;

    @Autowired
    TicketRepository ticketRepository;

    @Autowired
    EntityManager entityManager;

    //显示所有vip任务
    @GetMapping("/wechat/auth/vip")
    public String taskList(Model model, HttpServletRequest request, HttpSession session) {
        User user = (User) session.getAttribute("user");
        Map<String, String[]> map = request.getParameterMap();
        Integer page = map.containsKey("page") ? Integer.valueOf(map.get("page")[0]) : 0;//从0开始的页数
        Integer off = map.containsKey("off") ? Integer.valueOf(map.get("off")[map.get("off").length - 1]) : null;
        String title = map.containsKey("title") ? map.get("title")[0] : null;
        Integer type = map.containsKey("type") ? Integer.valueOf(map.get("type")[0]) : null;

        //方便显示账单所对应的任务　
        Bill bill = null;
        if (map.containsKey("bill")) {
            bill = billRepository.findByIdAndUser(Integer.valueOf(map.get("bill")[0]), user);
        }

        Pageable pageable = new PageRequest(page, 5);
        Page<VipTask> vipTasks = vipTaskRepository.findAll(VipTaskSpec.getSpec(off, user, title, bill,type,null), pageable);

        //未支付账单的数量和未支付账单的总金额1
        Object unpay = entityManager
                .createQuery("select count(*),sum(price) from Bill where pay = 0 and user = :user")
                .setParameter("user", user)
                .getSingleResult();

        model.addAttribute("vipTasks", vipTasks);
        model.addAttribute("unpay", unpay);
        session.setAttribute("menu","vip");
        return "web/wechat/vip";
    }


}
