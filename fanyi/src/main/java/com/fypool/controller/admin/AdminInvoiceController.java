package com.fypool.controller.admin;


import com.fypool.model.InvoiceRequest;
import com.fypool.model.InvoiceRequestSpec;
import com.fypool.model.Message;
import com.fypool.model.User;
import com.fypool.repository.InvoiceRequestRepository;
import com.fypool.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.util.Map;

@Controller
public class AdminInvoiceController {

    @Autowired
    InvoiceRequestRepository invoiceRequestRepository;

    @Autowired
    UserRepository userRepository;

    //显示发票列表
    @GetMapping("/admin/invoice")
    public String adminInvoice(
            HttpServletRequest request,
            Model model,
            HttpSession session
    ) {
        Map<String, String[]> map = request.getParameterMap();
        Integer page = map.containsKey("page") ? Integer.valueOf(map.get("page")[0]) : 0;//从0开始的页数
        Integer result = map.containsKey("result") ? Integer.valueOf(map.get("result")[map.get("result").length - 1]) : null;//从0开始的页数
        User user = null;
        if (map.containsKey("username")) {
            user = userRepository.findByUsername(map.get("username")[0]);
        }

        if (map.containsKey("phone")) {
            user = userRepository.findByAttribute_Phone(map.get("phone")[0]);
        }

        Sort sort = new Sort(Sort.Direction.DESC, "createdAt");
        Pageable pageable = new PageRequest(page, 10, sort);

        Page<InvoiceRequest> invoices = invoiceRequestRepository.findAll(InvoiceRequestSpec.getSpec(user, result), pageable);

        model.addAttribute("invoices", invoices);
        session.setAttribute("menu", "user");
        return "admin/invoice";
    }

    //提交发票处理
    @GetMapping("/admin/invoice/deal")
    public String adminInvoice(
            @RequestParam("id") Integer id,
            @RequestParam("trackingNumber") String trackingNumber,
            RedirectAttributes redirect
    ) {
        if (trackingNumber.length() == 0) {
            redirect.addFlashAttribute("message", new Message(0, "未填写任何快递信息"));
            return "redirect:/admin/invoice";
        }
        InvoiceRequest invoiceRequest = invoiceRequestRepository.findOne(id);
        invoiceRequest.setResult(1);
        //填写快递信息
        invoiceRequest.setTrackingNumber(trackingNumber);
        invoiceRequestRepository.save(invoiceRequest);
        redirect.addFlashAttribute("message", new Message(1, "处理成功"));
        return "redirect:/admin/invoice";
    }


}
