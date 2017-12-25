package com.fypool.controller.web;

import com.fypool.component.HelperController;
import com.fypool.component.SmsUtils;
import com.fypool.model.*;
import com.fypool.model.Process;
import com.fypool.repository.*;
import me.chanjar.weixin.common.exception.WxErrorException;
import me.chanjar.weixin.mp.bean.template.WxMpTemplateData;
import me.chanjar.weixin.mp.bean.template.WxMpTemplateMessage;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.data.redis.core.ValueOperations;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
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
import java.util.concurrent.TimeUnit;

@Controller
public class ProcessController {

    @Autowired
    TaskRepository taskRepository;

    @Autowired
    AttachmentRepository attachmentRepository;

    @Autowired
    TaskContentRepository taskContentRepository;

    @Autowired
    RedisTemplate redisTemplate;

    @Autowired
    UserRepository userRepository;

    @Autowired
    HelperController helper;

    @Autowired
    TaskUserRepository taskUserRepository;

    @Autowired
    EntityManager entityManager;

    @Autowired
    UserInfoRepository userInfoRepository;

    @Autowired
    ProcessRepository processRepository;

    @Autowired
    BalanceRepository balanceRepository;

    @Autowired
    AccountingRepository accountingRepository;

    @Autowired
    AttributeRepository attributeRepository;

    @Autowired
    EducationRepository educationRepository;

    @Autowired
    CertificateInfoRepository certificateInfoRepository;

    @Autowired
    CertificatePaperRepository certificatePaperRepository;

    @Autowired
    TranslatePriceRepository translatePriceRepository;

    @Autowired
    AdminCheckCertificateRepository adminCheckCertificateRepository;

    @Autowired
    CompanyRepository companyRepository;

    @Autowired
    AdminCheckCertificateRepository checkRepository;

    @Autowired
    AddressRepository addressRepository;

    @Autowired
    TicketRepository ticketRepository;

    @Autowired
    InvoiceRepository invoiceRepository;

    @Autowired
    InvoiceRequestRepository invoiceRequestRepository;

    @Autowired
    SignatureRequestRepository signatureRequestRepository;

    @Autowired
    SmsUtils smsUtils;

    @Autowired
    SmsNotifyRepository smsNotifyRepository;

    @Value("${domain.url}")
    String domainUrl;

    @GetMapping("/task/process")
    public String taskProcess(
            HttpSession session,
            Model model,
            @RequestParam(value = "page", required = false) Integer page,
            @RequestParam(value = "process", required = false) Integer process,
            @RequestParam(value = "type", required = false) Integer type
    ) {
        List<SkilledField> fields = new ArrayList<>();
        List<SkilledUsage> usages = new ArrayList<>();
        Integer getPage = page == null ? 0 : page;
        User user = (User) session.getAttribute("user");
        //按创建时间来查找
        Pageable pageable = new PageRequest(getPage, 5);
        Page<Task> tasks = taskRepository.findAll(TaskSpec.getSpec(null, null, null, null, type, user, null, fields, usages, null, process, null, null, null, null), pageable);
        model.addAttribute("tasks", tasks);
        session.setAttribute("menu", "process");
        return "web/client/taskProcess";
    }

    @GetMapping("/task/edit")
    public String taskEdit(
            @RequestParam("id") Integer id,
            Model model
    ) {
        Task task = taskRepository.findOne(id);
        model.addAttribute("task", task);
        return "web/client/taskEdit";
    }

    //修改任务
    @PostMapping("/task/edit/form")
    public String taskEditForm(
            HttpServletRequest request,
            Principal principal,
            RedirectAttributes redirect
    ) {
        User user = userRepository.findByUsername(principal.getName());

        Map<String, String[]> map = request.getParameterMap();

        Integer id = Integer.valueOf(map.get("taskId")[0]);

        Task task = taskRepository.findOne(id);
        task.setTitle(map.get("title")[0]);

        //简介可填可不填
        if (map.get("brief")[0].length() > 0) {
            //更新brief
            TaskContent brief = task.getBrief();
            brief.setContent(map.get("brief")[0]);
            taskContentRepository.save(brief);
        }

        //更新要求
        TaskContent taskRequest = task.getTaskRequest();
        taskRequest.setContent(map.get("translateRequest")[0]);
        taskContentRepository.save(taskRequest);

        task.setEmergency(Integer.valueOf(map.get("emergency")[0]));

        Integer top = Integer.valueOf(map.get("topValue")[0]);

        if (top > 0) {
            BigDecimal price = new BigDecimal(0);
            switch (top) {
                case 1:
                    price = new BigDecimal(10.00);
                    break;
                case 3:
                    price = new BigDecimal(25.00);
                    break;
                case 7:
                    price = new BigDecimal(50.00);
                    break;
                default:
                    redirect.addFlashAttribute("message", new Message(0, "非法操作"));
                    return "redirect:/task/edit?id=" + id;
            }

            //验证支付密码，如果有错，则直接跳转回去
            Message message = helper.checkPayPassword(price, user, map.get("password")[0]);
            if (message.getStatus() == 0) {
                redirect.addFlashAttribute("message", message);
                return "redirect:/task/edit?id=" + id;
            }

            task.setTop(1);
            //如果已经有置顶，并且还没过期，则在此时间上增加时间
            //如果没有置顶，则直接在当前时间上加
            Date topTime = task.getTopTime();
            Calendar c = Calendar.getInstance();
            if (topTime != null && topTime.getTime() > System.currentTimeMillis()) {
                c.setTime(topTime);
                c.add(Calendar.DATE, top);
                task.setTopTime(c.getTime());
            } else {
                c.setTime(new Date());
                c.add(Calendar.DATE, top);
                task.setTopTime(c.getTime());
            }

            //扣除余额，新建交易记录，返回修改了金额的用户，并缓存到session
            helper.saveBalance(price, user, "topService", task);
        }

        taskRepository.save(task);
        redirect.addFlashAttribute("message", new Message(1, "修改成功"));
        return "redirect:/task/edit?id=" + id;
    }

    //关闭任务
    @GetMapping("/task/close")
    public String taskClose(
            @RequestParam("id") Integer id,
            Principal principal,
            RedirectAttributes redirect
    ) {
        User user = userRepository.findByUsername(principal.getName());
        //加用户参数，以免他人非法关闭，增加任务状态，0正在进行时才能申请退款
        Task task = taskRepository.findByIdAndUserAndOff(id, user, 0);

        if (task == null) {
            //如果客户已经选择了译员，则不能关闭任务
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/task/edit?id=" + id;
        }

        if (task != null && task.getOff() == 0) {
            //关闭任务，没有退款流程
            task.setOff(1);
            taskRepository.save(task);
            redirect.addFlashAttribute("message", new Message(1, "关闭任务成功"));
        } else {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/task/edit?id=" + id;
        }
        return "redirect:/task/process";
    }

    @GetMapping("/task/refresh")
    public String taskRefresh(
            @RequestParam("id") Integer id,
            Principal principal,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");
        //加用户参数，以免他人非法刷新
        Task task = taskRepository.findByIdAndUser(id, user);

        ValueOperations<String, Integer> ops = redisTemplate.opsForValue();
        if (redisTemplate.hasKey("refresh:" + id)) {
            //如果当前刷新过了，则不能再刷新
            redirect.addFlashAttribute("message", new Message(0, "您已经刷新过了，每24小时可刷新一次"));
        } else {
            task.setUpdatedAt(new Date());
            taskRepository.save(task);
            ops.set("refresh:" + id, 0, 24, TimeUnit.HOURS);
            redirect.addFlashAttribute("message", new Message(1, "刷新成功"));
        }

        return "redirect:/task/process";
    }

    //任务进度
    @GetMapping("/process")
    public String process(
            @RequestParam("id") Integer id,
            @RequestParam(value = "page", required = false) Integer page,
            HttpSession session,
            Model model,
            RedirectAttributes redirect
    ) {
        Integer getPage = page == null ? 0 : page;
        User user = (User) session.getAttribute("user");
        Task task = taskRepository.findByIdAndUser(id, user);
        //如果任务不存在，则非法操作
        if (task == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/process?id=" + id;
        }

        Process process = task.getProcess();

        //3结束后，任务就结束了，钱就打了，评价任务可做可不做
        //对于客户来说：0 选择译员 1 正在翻译 2 审核稿件 3 评价任务
        //对于译员来说：0 正在投标 1 提交翻译 2 客户审核 3 完成任务，显示任务评价
        switch (process.getProcess()) {
            case 0:
                //获取信用积分排名前三的译员的taskUserId
                List<TaskUser> taskUserTops = entityManager.createQuery("select t from  TaskUser  t left join t.attribute  where t.task = :task order by score desc").setParameter("task", task).setMaxResults(3).getResultList();

                //先报价先展示
                Sort sort = new Sort(Sort.Direction.ASC, "createdAt");
                Pageable pageable = new PageRequest(getPage, 5, sort);
                //获取所有报价的译员，因为task已经确保这个任务是用户所有
                Page<TaskUser> taskUsers = taskUserRepository.findAllByTask(task, pageable);
                model.addAttribute("taskUserTops", taskUserTops);
                model.addAttribute("taskUsers", taskUsers);
                model.addAttribute("account", user.getAccount());
                model.addAttribute("sms", smsNotifyRepository.findByUser(user));
                return "web/client/processSelect";
            case 1:
                TaskUser select = taskUserRepository.findByTaskAndSelected(task, 1);
                model.addAttribute("select", select);
                return "web/client/processTranslate";
            case 2:
                //如果客户提交了修改要求，则译员要修改，译员修改
                //客户显示译员正在翻译中，译员显示用户的修改意见
                //译员修改完成后，把用户的check设置为2,表示为译员是修改稿件
                TaskUser select1 = taskUserRepository.findByTaskAndSelected(task, 1);
                model.addAttribute("process", process);
                model.addAttribute("attachments", attachmentRepository.findAllByProcess(process));
                //找到用户能用的优惠券
                model.addAttribute("tickets", ticketRepository.findAllByUserAndUsedAndLimitationLessThanEqualAndEndTimeAfter(user, 0, select1.getPrice(), new Date()));
                return "web/client/processCheck";
            case 3:
                //依旧要显示译员翻译内容，以备用户使用
                //不过翻译内容可以折叠，点击查看全文，以免过长
                model.addAttribute("process", process);
                model.addAttribute("attachments", attachmentRepository.findAllByProcess(process));
                return "web/client/processComment";
            case 4:
                //依旧要显示译员翻译内容，以备用户使用
                //不过翻译内容可以折叠，点击查看全文，以免过长
                model.addAttribute("process", process);
                model.addAttribute("attachments", attachmentRepository.findAllByProcess(process));
                return "web/client/processComment";
            default:
                break;
        }

        return "web/index";
    }


    //查看译员详情
    @GetMapping("/profile/user")
    public String process(
            @RequestParam("view") String username,
            Model model
    ) {
        User user = userRepository.findByUsername(username);
        if (user == null) {
            model.addAttribute("message", new Message(0, "非法操作"));
            return "web/userProfile";
        }

        model.addAttribute("educations", educationRepository.findByUser(user));
        model.addAttribute("papers", certificatePaperRepository.findByUser(user));
        model.addAttribute("prices", translatePriceRepository.findByUser(user));
        model.addAttribute("certificateInfo", certificateInfoRepository.findByUser(user));
        model.addAttribute("check", adminCheckCertificateRepository.findByUser(user));
        model.addAttribute("user", user);
        return "web/userProfile";
    }

    //选择译员
    @PostMapping("/task/select")
    public String taskSelect(
            @RequestParam("id") Integer id,
            @RequestParam("username") String username,
            @RequestParam(value = "password", required = false) String password,
            Principal principal,
            RedirectAttributes redirect
    ) throws WxErrorException {
        //只有拥有任务的人才能选择译员
        User user = userRepository.findByUsername(principal.getName());
        //防止用户刷钱，要检查任务状态
        Task task = taskRepository.findByIdAndUserAndOff(id, user, 0);

        if (task == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/process?id=" + id;
        }

        User selectUser = userRepository.findByUsername(username);
        if (selectUser == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/process?id=" + id;
        }

        TaskUser taskUser = taskUserRepository.findByTaskAndUser(task, selectUser);

        //直接支付译员报的价格
        //检查支付密码，余额，错误次数
        Message message = helper.checkPayPassword(taskUser.getPrice(), user, password);
        if (message.getStatus() == 0) {
            redirect.addFlashAttribute("message", message);
            return "redirect:/process?id=" + id;
        }
        //支付的是预付款
        helper.saveBalance(taskUser.getPrice(), user, "prepay", task);

        //任务表中设置为正在翻译 off = 1 为关闭任务 off=2 为正在翻译 off=0 正在选择译员 off=3 任务完成
        task.setOff(2);
        taskRepository.save(task);

        //在投标表中设置选中
        taskUser.setSelected(1);
        taskUserRepository.save(taskUser);

        //在进度表中，设置选中用户
        Process process = processRepository.findByTask(task);
        process.setUser(selectUser);
        process.setProcess(1);//设置为正在翻译
        processRepository.save(process);

        //短信通知译员，他已经被选中了
        smsUtils.sendSelect(selectUser.getAttribute().getPhone(), selectUser.getAttribute().getNickname(), task.getTitle());

        //全部完成后，发送微信提醒,报价被选中
        String openId = selectUser.getOpenId();
        if(openId!=null){
            helper.sendWechatMessage(
                    openId,
                    "/wechat/auth/mytask",
                    "您的任务有新的进展",
                    task.getType()==1?"翻译任务":"口译任务",
                    task.getTitle(),
                    selectUser.getAttribute().getNickname(),
                    "您的报价已经被客户选中，请及时翻译并上传稿件",
                    "点击查看任务详情"
            );
        }

        return "redirect:/process?id=" + id;
    }

    //提交修改意见
    @PostMapping("/task/translate/advice")
    public String taskTranslateAdvice(
            @RequestParam("advice") String advice,
            @RequestParam("id") Integer id,
            @RequestParam("path") String path,
            HttpSession session,
            RedirectAttributes redirect
    ) throws WxErrorException {
        User user = (User) session.getAttribute("user");
        Task task = taskRepository.findByIdAndUser(id, user);
        if (task == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/process?id=" + id;
        }

        Process process = task.getProcess();

        TaskContent adviceContent = new TaskContent(advice);
        taskContentRepository.save(adviceContent);

        //如果有附件，则设置附件地址,如果没有附件，就把附件设置为空
        if (path.length() > 0) {
            process.setAttachment(path);
        } else {
            process.setAttachment(null);
        }



        process.setAdvice(adviceContent);
        process.setChecked(0);
        processRepository.save(process);

        //全部完成后，发送微信提醒,翻译稿件要修改
        User user1 = process.getUser();
        String openId = user1.getOpenId();
        if(openId!=null){
            helper.sendWechatMessage(
                    openId,
                    "/wechat/auth/mytask",
                    "您接单的任务有新的进展",
                    task.getType()==1?"翻译任务":"口译任务",
                    task.getTitle(),
                    user1.getAttribute().getNickname(),
                    "审核不通过，请重新修改稿件并上传",
                    "点击查看任务详情"
            );
        }

        return "redirect:/process?id=" + id;
    }

    //审核通过
    @PostMapping("/task/pass")
    public String taskPass(
            @RequestParam("id") Integer id,
            @RequestParam("ticket") String ticketId,
            @RequestParam("password") String password,
            Principal principal,
            RedirectAttributes redirect
    ) throws WxErrorException {
        User user = userRepository.findByUsername(principal.getName());
        //为了防止用户刷钱，还要添加off的状态属性,3代表任务完成
        Task task = taskRepository.findByIdAndUserAndOff(id, user, 2);
        if (task == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/process?id=" + id;
        }

        Process process = task.getProcess();
        TaskUser taskUser = taskUserRepository.findByTaskAndUserAndSelected(task, process.getUser(), 1);
        //译员报价
        BigDecimal price = taskUser.getPrice();

        //检查支付密码
        Message message = helper.checkPayPassword(price,user,password);
        if(message.getStatus()==0){
            redirect.addFlashAttribute("message",message);
            return "redirect:/process?id=" + id;
        }

        //支付密码检查无误后
        //把任务的off设置为3 任务完成
        task.setOff(3);

        //把进程的process设置为3 任务完成，任务评价
        process.setChecked(1);
        process.setProcess(3);

        //是否已经有用户完成了任务，并领取了金额
        Boolean hasTask = balanceRepository.existsByAccountingAndTask(accountingRepository.findByShortName("task"), task);

        if (hasTask) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/process?id=" + id;
        }

        //如果客户使用了返现券，则给进行返现
        if (ticketId.length() > 0) {
            //检查返现券是否合法
            Ticket ticket = ticketRepository.findByIdAndUserAndUsedAndLimitationLessThanEqualAndEndTimeAfter(Integer.valueOf(ticketId), user, 0, taskUser.getPrice(), new Date());
            if (ticket == null) {
                redirect.addFlashAttribute("message", new Message(0, "该返现券不可使用"));
                return "redirect:/process?id=" + id;
            }
            //使用优惠券
            ticket.setUsed(1);
            ticketRepository.save(ticket);
            helper.saveBalanceForTicket(ticket.getPrice(), user, "ticket", task, ticket);
            redirect.addFlashAttribute("message", new Message(1, "审核通过，返现成功。返现金额已经充值到您的余额。"));
        }

        //把钱打给译员，把交易手续费扣掉30%

        //因为小数会从2位变成3位，所以要四舍五入
        //给平台的服务费
        BigDecimal servicePrice = price.multiply(new BigDecimal(0.3)).setScale(2, BigDecimal.ROUND_HALF_UP);
        helper.saveBalanceForFanyi(servicePrice, "commission", task);
        //给译员的稿费,因为是给其他用户稿费，所以不用更新session,让用户在交易记录中刷新时再更新
        //告诉译员，若交易记录中获得了钱，而余额中未显示，请点击刷新
        BigDecimal userPrice = price.subtract(servicePrice);
        User user2 = process.getUser();
        helper.saveBalance(userPrice, process.getUser(), "task", task);


        //更新译员的信用积分，翻译字数，任务数
        Attribute attribute = user2.getAttribute();
        //完成任务加5分，评价分数等客户评价后给
        attribute.setScore(attribute.getScore() + 5);
        //原翻译字数+内容翻译字数+附件翻译字数
        attribute.setWords(attribute.getWords() + task.getWords() + task.getAttachmentWords());
        //完成任务数
        attribute.setTaskDone(attribute.getTaskDone() + 1);

        //全部完成后，发送微信提醒,审核通过
        String openId = user2.getOpenId();
        if(openId!=null){
            helper.sendWechatMessage(
                    openId,
                    "/wechat/auth/mytask",
                    "您接单的任务有新的进展",
                    task.getType()==1?"翻译任务":"口译任务",
                    task.getTitle(),
                    user2.getAttribute().getNickname(),
                    "审核通过",
                    "点击查看任务详情"
            );
        }

        attributeRepository.save(attribute);
        taskRepository.save(task);
        processRepository.save(process);

        return "redirect:/process?id=" + id;
    }

    @PostMapping("/task/comment")
    public String taskPass(
            @RequestParam("id") Integer id,
            @RequestParam("star") Integer star,
            @RequestParam(value = "clientComment", required = false) String clientComment,
            @RequestParam(value = "templateComment", required = false) String templateComment,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");
        Task task = taskRepository.findByIdAndUser(id, user);
        if (task == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/process?id=" + id;
        }

        Process process = task.getProcess();
        process.setStar(star);
        process.setProcess(4);//已经评论
        Attribute attribute = process.getUser().getAttribute();
        attribute.setScore(attribute.getScore() + star);//获得多少星就加多少信用积分
        attributeRepository.save(attribute);

        if (clientComment.length() > 0) {
            process.setClientComment(clientComment);
        }
        if (templateComment.length() > 0) {
            process.setTemplateComment(templateComment);
        }
        processRepository.save(process);
        return "redirect:/process?id=" + id;
    }

    //申请发票
    @GetMapping("/task/invoice")
    public String taskInvoice(
            @RequestParam("id") Integer id,
            HttpSession session,
            Model model
    ) {
        User user = (User) session.getAttribute("user");
        model.addAttribute("invoices", invoiceRepository.findByUserAndDeleted(user, 0));
        model.addAttribute("taskId", id);
        return "web/client/invoice";
    }

    //选择发票
    @GetMapping("/select/invoice")
    public String selectInvoice(
            @RequestParam("taskId") Integer taskId,
            @RequestParam("invoiceId") Integer invoiceId,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");

        //判断这个任务进程是不是这个用户的,并且任务已经完成
        Task task = taskRepository.findByIdAndUserAndOff(taskId, user, 3);
        if (task == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/task/process";
        }

        if (invoiceRequestRepository.existsByTask(task)) {
            redirect.addFlashAttribute("message", new Message(0, "发票已经申请，请不要重复申请"));
            return "redirect:/task/process";
        }

        Address address = addressRepository.findByUser(user);
        if (address == null) {
            redirect.addFlashAttribute("message", new Message(0, "请先在个人中心中填写邮寄地址后再申请发票"));
            return "redirect:/task/process";
        }

        //获取是当前用户，且未被软删除的发发票
        Invoice invoice = invoiceRepository.findByUserAndDeletedAndId(user, 0, invoiceId);
        if (invoice == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/task/process";
        }

        //创建发票请求，并保存
        InvoiceRequest invoiceRequest = invoiceRequestRepository.save(new InvoiceRequest(invoice, address, task, user));
        Process process = task.getProcess();
        process.setInvoiceRequest(invoiceRequest);
        processRepository.save(process);

        redirect.addFlashAttribute("message", new Message(1, "发票申请成功"));
        return "redirect:/task/process";
    }


    //申请签章
    @GetMapping("/task/signature")
    public String taskSignature(
            @RequestParam("id") Integer id,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");
        //判断这个任务进程是不是这个用户的,并且任务已经完成
        Task task = taskRepository.findByIdAndUserAndOff(id, user, 3);
        if (task == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/task/process";
        }

        Address address = addressRepository.findByUser(user);
        if (address == null) {
            redirect.addFlashAttribute("message", new Message(0, "请先在个人中心中填写邮寄地址后再申请签章"));
            return "redirect:/task/process";
        }

        if (signatureRequestRepository.existsByTask(task)) {
            redirect.addFlashAttribute("message", new Message(0, "签章已经申请，请不要重复申请！"));
            return "redirect:/task/process";
        }

        SignatureRequest signatureRequest = signatureRequestRepository.save(new SignatureRequest(address, task, user));

        Process process = task.getProcess();
        process.setSignatureRequest(signatureRequest);
        processRepository.save(process);
        redirect.addFlashAttribute("message", new Message(1, "签章申请成功"));
        return "redirect:/task/process";
    }

    @GetMapping("/sms/notify")
    public String smsNotify(
            @RequestParam("username") String username,
            @RequestParam("id") Integer id,
            HttpSession session,
            RedirectAttributes redirect
    ) {
        User user = (User) session.getAttribute("user");

        //查找用户是否有短信提示账号
        //判断这个任务进程是不是这个用户的
        Task task = taskRepository.findByIdAndUser(id, user);
        if (task == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/process?id=" + id;
        }

        //如果用户当前不是客户，则不能发送提醒短信
        if (!user.getCurrentRole().equals("ROLE_CLIENT")) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/process?id=" + id;
        }

        //要发送的短信对象不存在， 则不发送
        User user1 = userRepository.findByUsername(username);
        if (user1 == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/process?id=" + id;
        }

        SmsNotify smsNotify = smsNotifyRepository.findByUser(user);
        //如果不存在，就创建
        if (smsNotify == null) {
            //新建短信提醒的账号,每日5条
            smsNotify = smsNotifyRepository.save(new SmsNotify(0, 5, user));
        }

        //增加一条短信提醒
        if (smsNotify.getAccount() == smsNotify.getUsed()) {
            redirect.addFlashAttribute("message", new Message(0, "您今日的短信提醒额度已经用完"));
        } else {
            Boolean success = smsUtils.sendUser(user1.getAttribute().getPhone(), user1.getAttribute().getNickname(), task.getTitle(), user.getAttribute().getNickname());
            if (success) {
                redirect.addFlashAttribute("message", new Message(1, "短信提醒已经发送成功"));
                smsNotify.setUsed(smsNotify.getUsed() + 1);
                smsNotifyRepository.save(smsNotify);
            } else {
                redirect.addFlashAttribute("message", new Message(0, "短信提醒发送失败"));
            }
        }

        return "redirect:/process?id=" + id;
    }

    //上传审核附件
    @PostMapping("/upload/advice")
    public @ResponseBody
    String uploadAttachment(
            @RequestParam("file") MultipartFile file
    ) {
        return helper.uploadFile(file, "advice");
    }

}
