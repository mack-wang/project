package com.fypool.controller.web;

import com.fypool.model.*;
import com.fypool.model.Process;
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
public class VipController {

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


    @GetMapping("/public/vip")
    public String publicVip() {

        return "web/vip";
    }


    //显示所有vip任务
    @GetMapping("/vip")
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

        //未支付账单的数量和未支付账单的总金额
        Object unpay = entityManager
                .createQuery("select count(*),sum(price) from Bill where pay = 0 and user = :user")
                .setParameter("user", user)
                .getSingleResult();

        model.addAttribute("vipTasks", vipTasks);
        model.addAttribute("unpay", unpay);
        session.setAttribute("menu","vip");
        return "web/client/vip";
    }

    //显示vip任务
    @GetMapping("/vip/task/detail")
    public String taskDetail(@RequestParam("id") Integer id, Model model, HttpSession session) {
        User user = (User) session.getAttribute("user");
        //只能显示自己的任务
        if (user.getCurrentRole().equals("ROLE_ADMIN")) {
            model.addAttribute("task", vipTaskRepository.findOne(id));
        } else {
            model.addAttribute("task", vipTaskRepository.findByIdAndUser(id, user));
        }
        return "web/client/vipTaskDetail";
    }

    //申请发票
    @GetMapping("/vipTask/invoice")
    public String taskInvoice(
            @RequestParam("id") Integer id,
            HttpSession session,
            Model model
    ) {
        User user = (User) session.getAttribute("user");
        model.addAttribute("invoices", invoiceRepository.findByUserAndDeleted(user, 0));
        model.addAttribute("taskId", id);
        return "web/client/invoiceVip";
    }

    //选择发票
    @GetMapping("/select/invoiceVip")
    public String selectInvoice(
            @RequestParam("taskId") Integer taskId,
            @RequestParam("invoiceId") Integer invoiceId,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");

        //判断这个任务进程是不是这个用户的,并且这个vip任务是否已经付款
        VipTask task = vipTaskRepository.findByIdAndUserAndOff(taskId, user,4);

        if (task == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/vip";
        }

        if (invoiceRequestRepository.existsByVipTask(task)) {
            redirect.addFlashAttribute("message", new Message(0, "发票已经申请，请不要重复申请"));
            return "redirect:/vip";
        }

        Address address = addressRepository.findByUser(user);
        if (address == null) {
            redirect.addFlashAttribute("message", new Message(0, "请先在个人中心中填写邮寄地址后再申请发票"));
            return "redirect:/vip";
        }

        //获取是当前用户，且未被软删除的发发票
        Invoice invoice = invoiceRepository.findByUserAndDeletedAndId(user, 0, invoiceId);
        if (invoice == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/vip";
        }

        //创建发票请求，并保存
        InvoiceRequest invoiceRequest = invoiceRequestRepository.save(new InvoiceRequest(invoice, address, task, user));
        task.setInvoiceRequest(invoiceRequest);
        vipTaskRepository.save(task);

        redirect.addFlashAttribute("message", new Message(1, "发票申请成功"));
        return "redirect:/vip";
    }


    //申请签章
    @GetMapping("/vipTask/signature")
    public String vipTaskSignature(
            @RequestParam("id") Integer id,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");
        //判断这个任务进程是不是这个用户的,并且这个任务已经付款
        VipTask vipTask = vipTaskRepository.findByIdAndUserAndOff(id, user,4);
        if (vipTask == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/vip";
        }

        Address address = addressRepository.findByUser(user);
        if (address==null) {
            redirect.addFlashAttribute("message", new Message(0, "请先在个人中心中填写邮寄地址后再申请签章"));
            return "redirect:/vip";
        }

        if(signatureRequestRepository.existsByVipTask(vipTask)){
            redirect.addFlashAttribute("message", new Message(0, "盖章已经申请，请不要重复申请！"));
            return "redirect:/vip";
        }

        SignatureRequest signatureRequest = signatureRequestRepository.save(new SignatureRequest(address,vipTask,user));

        vipTask.setSignatureRequest(signatureRequest);
        vipTaskRepository.save(vipTask);
        redirect.addFlashAttribute("message", new Message(1, "盖章申请成功"));
        return "redirect:/vip";
    }


    //确认收稿
    @GetMapping("/vip/task/confirm")
    public String taskConfirm(
            @RequestParam("id") Integer id,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");
        //判断这个任务是不是用户所拥有，并且已经有译稿了
        VipTask vipTask = vipTaskRepository.findByIdAndUser(id,user);
        if(vipTask==null){
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/vip";
        }

        //当任务是笔译时，一定要有译稿才能确认完成
        if(vipTask.getType()==1 && vipTask.getOff()!=2){
            redirect.addFlashAttribute("message", new Message(0, "笔译要收到译稿后才可以确认完成"));
            return "redirect:/vip";
        }

        //当任务是口译时，只要是0 或 2 就可以确认完成
        if(vipTask.getType()==0 && vipTask.getOff()!=0 && vipTask.getOff()!=2){
            redirect.addFlashAttribute("message", new Message(0, "口译只有在正在进行和完成翻译两种状态时才能确认完成。"));
            return "redirect:/vip";
        }

        //设置状态为已经收到稿件,并且更新完成日期
        vipTask.setOff(6);
        vipTask.setDoneTime(new Date());
        vipTaskRepository.save(vipTask);

        redirect.addFlashAttribute("message", new Message(1, "已经确认完成"));
        return "redirect:/vip";
    }


}
