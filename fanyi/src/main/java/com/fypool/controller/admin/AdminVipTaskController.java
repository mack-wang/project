package com.fypool.controller.admin;


import com.fypool.component.HelperController;
import com.fypool.component.SmsUtils;
import com.fypool.model.*;
import com.fypool.repository.*;
import me.chanjar.weixin.common.exception.WxErrorException;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.security.Principal;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.*;

@Controller
public class AdminVipTaskController {

    @Autowired
    LanguageGroupRepository languageGroupRepository;

    @Autowired
    HelperController helper;

    @Autowired
    UserRepository userRepository;

    @Autowired
    VipPriceRepository vipPriceRepository;

    @Autowired
    VipRepository vipRepository;

    @Autowired
    RoleRepository roleRepository;

    @Autowired
    AttributeRepository attributeRepository;

    @Autowired
    VipTaskRepository vipTaskRepository;

    @Autowired
    BillRepository billRepository;

    @Autowired
    EntityManager entityManager;

    @Autowired
    SmsUtils smsUtils;

    @Value("${customer.service.phone}")
    private String servicePhone;


    //新建vip任务
    @GetMapping("/admin/vip/task")
    public String vipTask(HttpSession session) {
        session.setAttribute("menu", "adminvip");
        return "admin/task/vipSelect";
    }

    //提交vip任务的用户名
    @GetMapping("/admin/vip/task/select")
    public String vipTaskUser(HttpServletRequest request, RedirectAttributes redirect, Model model) {
        Map<String, String[]> map = request.getParameterMap();
        User user = null;
        if (map.containsKey("phone")) {
            user = attributeRepository.findByPhone(map.get("phone")[0]).getUser();
        }

        if (map.containsKey("email")) {
            user = attributeRepository.findByEmail(map.get("email")[0]).getUser();
        }

        if (map.containsKey("username")) {
            user = userRepository.findByUsername(map.get("username")[0]);
        }

        if (user == null) {
            redirect.addFlashAttribute("message", new Message(0, "您选择的客户不存在"));
            return "redirect:/admin/vip/task";
        }

        Vip vip = user.getVip();
        if (vip == null) {
            redirect.addFlashAttribute("message", new Message(0, "您选择的VIP客户不存在"));
            return "redirect:/admin/vip/task";
        }

        model.addAttribute("vip", vip);
        model.addAttribute("languageGroups", languageGroupRepository.findAll());

        return "admin/task/vipTask";
    }

    //上传vip任务的翻译内容附件
    @PostMapping("/admin/upload/vipAttachment")
    public @ResponseBody
    String uploadAttachment(
            @RequestParam("vipAttachment") MultipartFile file
    ) {
        return helper.uploadFile(file, "vipAttachment");
    }

    //上传vip任务的翻译稿件
    @PostMapping("/admin/upload/vipTask")
    public @ResponseBody
    String uploadTask(
            @RequestParam("vipTask") MultipartFile file
    ) {
        return helper.uploadFile(file, "vipTask");
    }

    //创建vip任务（创建任务的时候，是不会有账单的，等提交翻译稿件的时候，才会有账单）
    @PostMapping("/admin/viptask/add")
    public String viptaskAdd(
            HttpServletRequest request,
            RedirectAttributes redirect,
            Principal principal
    ) throws WxErrorException {
        Map<String, String[]> map = request.getParameterMap();
        User user = userRepository.findByUsername(map.get("username")[0]);
        VipTask vipTask = vipTaskRepository.save(new VipTask(
                Integer.valueOf(map.get("type")[0]),
                map.get("title")[0],
                languageGroupRepository.findOne(Integer.valueOf(map.get("languageGroup")[0])),
                map.get("endTime")[0].length() > 0 ? helper.parseDate(map.get("endTime")[0]) : null,
                map.get("startDate")[0].length() > 0 ? helper.parseDate(map.get("startDate")[0]) : null,
                map.get("endDate")[0].length() > 0 ? helper.parseDate(map.get("endDate")[0]) : null,
                user,
                userRepository.findByUsername(principal.getName()),
                new BigDecimal(map.get("unitPrice")[0]),
                new BigDecimal(map.get("price")[0]),
                map.get("word")[0].length() > 0 ? Integer.valueOf(map.get("word")[0]) : null,
                map.get("hour")[0].length() > 0 ? Integer.valueOf(map.get("hour")[0]) : null,
                map.get("path")[0]
        ));
        redirect.addFlashAttribute("message", new Message(1, "VIP任务创建成功"));

        //发送短信，提醒用户vip任务已经创建成功
        Date date = vipTask.getCreatedAt();
        DateFormat format = new SimpleDateFormat("yyyyMMdd");
        String time = format.format(date);
        String taskId = time + vipTask.getId().toString();
        smsUtils.sendVip(user.getAttribute().getPhone(), user.getAttribute().getNickname(), taskId);

        //全部完成后，发送微信提醒,vip服务稿件上传
        User user1 = vipTask.getUser();
        String openId = user1.getOpenId();
        if(openId!=null){
            helper.sendWechatMessage(
                    openId,
                    "/wechat/auth/vip",
                    "您的VIP服务有新的进展",
                    vipTask.getType()==1?"翻译服务":"口译服务",
                    vipTask.getTitle(),
                    "翻易平台",
                    "您的VIP服务已经创建成功，订单编号："+taskId,
                    "点击查看VIP服务详情"
            );
        }

        return "redirect:/admin/vip/task";
    }

    //显示所有vip任务
    @GetMapping("/admin/vip/task/list")
    public String taskList(Model model, HttpServletRequest request, HttpSession session) {
        Map<String, String[]> map = request.getParameterMap();
        Integer page = map.containsKey("page") ? Integer.valueOf(map.get("page")[0]) : 0;//从0开始的页数
        Integer off = map.containsKey("off") ? Integer.valueOf(map.get("off")[map.get("off").length - 1]) : null;
        String title = map.containsKey("title") ? map.get("title")[0] : null;
        Integer type = map.containsKey("type") ? Integer.valueOf(map.get("type")[0]) : null;
        User user = null;
        Integer id = null;
        Bill bill = null;
        if (map.containsKey("phone")) {
            user = userRepository.findByAttribute_Phone(map.get("phone")[0]);
        }

        if (map.containsKey("username")) {
            user = userRepository.findByUsername(map.get("username")[0]);
        }

        if (map.containsKey("id")) {
            String str = map.get("id")[0];
            id = Integer.valueOf(str.substring(8));
        }

        //管理员根据bill来显示task
        if (map.containsKey("bill")) {
            bill = billRepository.findOne(Integer.valueOf(map.get("bill")[0]));
        }

        Pageable pageable = new PageRequest(page, 10);
        Page<VipTask> vipTasks = vipTaskRepository.findAll(VipTaskSpec.getSpec(off, user, title, bill, type, id), pageable);
        model.addAttribute("vipTasks", vipTasks);
        session.setAttribute("menu", "adminvip");
        return "admin/task/taskList";
    }

    //显示vip任务
    @GetMapping("/admin/vip/task/detail")
    public String taskDetail(@RequestParam("id") Integer id, Model model) {
        model.addAttribute("task", vipTaskRepository.findOne(id));
        return "admin/task/detail";
    }

    //提交vip任务的翻译稿件
    @PostMapping("/admin/vip/task/translate")
    public String taskTranslate(
            @RequestParam("path") String path,
            @RequestParam("id") Integer id,
            RedirectAttributes redirect
    ) throws WxErrorException {
        VipTask vipTask = vipTaskRepository.findOne(id);
        if (vipTask.getOff() == 1) {
            redirect.addFlashAttribute("message", new Message(0, "该VIP任务已经关闭"));
            return "redirect:/admin/vip/task/detail?id=" + id;
        }

        //如果任务是正在进行中，则设置了已经提交了翻译，但没生成账单。其他状态则维持原状态
        if (vipTask.getOff() == 0) {
            vipTask.setOff(2);
        }

        //上传稿件
        vipTask.setVipTask(path);
        //稿件的版本号+1
        vipTask.setVersion(vipTask.getVersion() + 1);
        vipTaskRepository.save(vipTask);

        //全部完成后，发送微信提醒,vip服务稿件上传
        User user = vipTask.getUser();
        String openId = user.getOpenId();
        if(openId!=null){
            helper.sendWechatMessage(
                    openId,
                    "/wechat/auth/vip",
                    "您的VIP服务有新的进展",
                    vipTask.getType()==1?"翻译服务":"口译服务",
                    vipTask.getTitle(),
                    "翻易平台",
                    "已经完成翻译，请及时审核并确认",
                    "点击查看VIP服务详情"
            );
        }

        //发送短信提醒
        smsUtils.sendVipTranslated(user.getAttribute().getPhone(),user.getAttribute().getNickname(),vipTask.getTitle());

        redirect.addFlashAttribute("message", new Message(1, "第" + vipTask.getVersion() + "版翻译稿件已经上传"));
        return "redirect:/admin/vip/task/detail?id=" + id;
    }

    //立即生成次结账单
    @GetMapping("/admin/bill/make")
    public String billMake(@RequestParam("id") Integer id, RedirectAttributes redirect) {
        VipTask vipTask = vipTaskRepository.findOne(id);

        //任务状态不正确或者用户不是次结的用户，则不能生成次结账单
        if (vipTask.getOff() != 6 || vipTask.getUser().getVip().getType() != 0) {
            redirect.addFlashAttribute("message", new Message(0, "该VIP任务无法生成次结账单"));
            return "redirect:/admin/vip/task/detail?id=" + id;
        }

        List<VipTask> vipTasks = new ArrayList<>();
        vipTasks.add(vipTask);

        //创建次结账单,并发送
        Bill bill = billRepository.save(new Bill(vipTask.getPrice(), vipTask.getUser(), vipTasks, 0, 0, 1));

        vipTask.setBill(bill);//绑定账单到任务
        vipTask.setOff(3);//账单已出
        vipTaskRepository.save(vipTask);

        //如果用户绑定了邮箱
        String email = vipTask.getUser().getAttribute().getEmail();
        if (email != null) {
            helper.sendEmailBill(email, "领骄翻易VIP客户次结账单已出，请查收。", bill, vipTask.getUser());
        }

        //短信通知
        User user = vipTask.getUser();
        smsUtils.sendBill(user.getAttribute().getPhone(), user.getAttribute().getNickname(), "VIP次结", vipTask.getPrice().toString(), servicePhone);

        redirect.addFlashAttribute("message", new Message(1, "次结账单已经生成"));
        return "redirect:/admin/vip/task/detail?id=" + id;
    }

    //生成月结账单，添加任务到该月结账单，待发送月结账单
    @GetMapping("/admin/bill/suspend")
    public String billSuspend(@RequestParam("id") Integer id, RedirectAttributes redirect) {
        VipTask vipTask = vipTaskRepository.findOne(id);

        if (vipTask.getOff() != 6 || vipTask.getUser().getVip().getType() != 1) {
            redirect.addFlashAttribute("message", new Message(0, "该VIP任务无法生成月结账单"));
            return "redirect:/admin/vip/task/detail?id=" + id;
        }

        Date date = new Date();
        DateFormat format = new SimpleDateFormat("yyyyMM");
        String month = format.format(date);
        //如果这个用户月结账单不存在
        Bill bill = billRepository.findByMonthAndUser(month,vipTask.getUser());
        if (bill == null) {
            List<VipTask> vipTasks = new ArrayList<>();
            vipTasks.add(vipTask);
            //账单已经生成，但不发送
            bill = billRepository.save(new Bill(vipTask.getPrice(), vipTask.getUser(), vipTasks, 1, 0, 0, month));
            vipTask.setBill(bill);//vip任务关联账单
        } else {
            //如果月结账单已经存在,在原先的基础上添加任务,增加价格，绑定账单
            bill.getVipTasks().add(vipTask);
            bill.setPrice(bill.getPrice().add(vipTask.getPrice()));
            vipTask.setBill(bill);//vip任务关联账单
        }

        //保存月账单
        billRepository.save(bill);
        vipTask.setOff(5);
        vipTaskRepository.save(vipTask);

        redirect.addFlashAttribute("message", new Message(1, "该任务已经设置为待发送月结账单"));
        return "redirect:/admin/vip/task/detail?id=" + id;
    }


    //关闭任务
    @GetMapping("/admin/vip/task/close")
    public String vipTaskClose(@RequestParam("id") Integer id, RedirectAttributes redirect) {
        VipTask vipTask = vipTaskRepository.findOne(id);

        //只要任务没生成账单，这个任务就能关闭
        if (vipTask.getOff() == 3 || vipTask.getOff() == 4) {
            redirect.addFlashAttribute("message", new Message(0, "该VIP任务已经生成账单，无法关闭"));
            return "redirect:/admin/vip/task/detail?id=" + id;
        }

        vipTask.setOff(1);
        vipTaskRepository.save(vipTask);

        redirect.addFlashAttribute("message", new Message(1, "该任务已经关闭"));
        return "redirect:/admin/vip/task/detail?id=" + id;
    }

    //发送全部的月账单
    @GetMapping("/admin/monthBill/make")
    public String monthBillMake(
            RedirectAttributes redirect
    ) {

        //找出所有没发送的月结账单 send = 0
        List<Bill> bills = billRepository.findAllBySendAndType(0,1);

        for (Bill bill : bills) {
            User user = bill.getUser();
            //发邮件
            String email = user.getAttribute().getEmail();
            if (email != null) {
                helper.sendEmailBill(email, "领骄翻易VIP客户" + bill.getMonth() + "月月结账单已出，请查收。", bill, user);
            }

            //发送账单短信
            smsUtils.sendBill(user.getAttribute().getPhone(), user.getAttribute().getNickname(), bill.getMonth()+"VIP月结", bill.getPrice().toString(), servicePhone);

            //账单设置为发送状态
            bill.setSend(1);
            billRepository.save(bill);
        }


        redirect.addFlashAttribute("message", new Message(1, "月结账单已经全部发送"));
        return "redirect:/admin/vip/task/list";
    }

    //发送选择好的月账单，可以是1个，可以是多个，可以是全部，以id为准



}
