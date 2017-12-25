package com.fypool.controller.admin;

import com.fypool.component.HelperController;
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
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.util.Date;
import java.util.List;
import java.util.Map;

@Controller
public class AdminUserController {

    @Autowired
    UserRepository userRepository;

    @Autowired
    AttributeRepository attributeRepository;

    @Autowired
    ReportIllegalRepository reportIllegalRepository;

    @Autowired
    TaskRepository taskRepository;

    @Autowired
    BalanceRepository balanceRepository;

    @Autowired
    AccountRepository accountRepository;

    @Autowired
    AccountingRepository accountingRepository;

    @Autowired
    HelperController helper;

    @Autowired
    QuestionRepository questionRepository;

    @Autowired
    AdminCheckCertificateRepository checkRepository;

    @Autowired
    AdminCheckCertificateMessageRepository checkMessageRepository;

    @Autowired
    CertificateRepository certificateRepository;

    @Autowired
    RoleRepository roleRepository;

    @Autowired
    EducationRepository educationRepository;

    @Autowired
    CertificatePictureRepository certificatePictureRepository;

    @Autowired
    TranslatePriceRepository translatePriceRepository;

    @Autowired
    CertificatePaperRepository certificatePaperRepository;

    @Autowired
    CertificateInfoRepository certificateInfoRepository;

    @Autowired
    CompanyRepository companyRepository;

    @GetMapping("/admin/user/list")
    public String userList(Model model, HttpServletRequest request,HttpSession session) {
        Map<String, String[]> map = request.getParameterMap();
        Integer page = map.containsKey("page") ? Integer.valueOf(map.get("page")[0]) : 0;//从0开始的页数
        String currentRole = map.containsKey("role") ? map.get("role")[map.get("role").length - 1] : null;
        String username = map.containsKey("username") ? map.get("username")[0] : null;
        String email = map.containsKey("email") ? map.get("email")[0] : null;
        String nickname = map.containsKey("nickname") ? map.get("nickname")[0] : null;
        String phone = map.containsKey("phone") ? map.get("phone")[0] : null;
        String createdAt = map.containsKey("createdAt") ? map.get("createdAt")[map.get("createdAt").length - 1] : null;
        String money = map.containsKey("money") ? map.get("money")[map.get("money").length - 1] : null;
        String score = map.containsKey("score") ? map.get("score")[map.get("score").length - 1] : null;
        String words = map.containsKey("words") ? map.get("words")[map.get("words").length - 1] : null;
        String taskDone = map.containsKey("taskDone") ? map.get("taskDone")[map.get("taskDone").length - 1] : null;
        Boolean vip = map.containsKey("vip");

        //用户筛选条件：邮箱，昵称，手机号，用户名
        //用户排序条件：余额排序，信用排序，翻译字数排序，任务数排序，创建时间排序
        //创建分页
        Pageable pageable = new PageRequest(page, 10);
        Page<User> users = userRepository.findAll(UserSpec.getSpec(currentRole, username, email, nickname, phone, createdAt, money, score, words, taskDone,vip), pageable);
        model.addAttribute("users", users);
        session.setAttribute("menu","user");
        return "admin/userList";
    }


    @GetMapping("/admin/report/illegal")
    public String reportList(Model model, HttpServletRequest request,HttpSession session) {
        Map<String, String[]> map = request.getParameterMap();
        Integer page = map.containsKey("page") ? Integer.valueOf(map.get("page")[0]) : 0;//从0开始的页数
        User reportUser = null;
        User taskUser = null;
        String title = map.containsKey("title") ? map.get("title")[0] : null;
        if (map.containsKey("reportUsername")) {
            reportUser = userRepository.findByUsername(map.get("reportUsername")[0]);
        }
        if (map.containsKey("reportPhone")) {
            reportUser = userRepository.findByAttribute_Phone(map.get("reportPhone")[0]);
        }
        if (map.containsKey("taskUsername")) {
            taskUser = userRepository.findByUsername(map.get("taskUsername")[0]);
        }
        if (map.containsKey("taskPhone")) {
            reportUser = userRepository.findByAttribute_Phone(map.get("taskPhone")[0]);
        }
        Pageable pageable = new PageRequest(page, 10);
        Page<ReportIllegal> reports = reportIllegalRepository.findAll(ReportIllegalSpec.getSpec(reportUser, taskUser, title), pageable);
        model.addAttribute("reports", reports);
        session.setAttribute("menu","user");
        return "admin/report";
    }

    //处理举报
    //关闭任务
    @GetMapping("/admin/report/illegal/close")
    public String reportClose(@RequestParam("id") Integer id, Model model, RedirectAttributes redirect) {
        //找到未处理的举报，加result参数，防止管理员作弊
        ReportIllegal reportIllegal = reportIllegalRepository.findByIdAndResult(id, 0);
        if (reportIllegal == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/admin/report/illegal";
        }

        //只有进行中的任务才能关闭，如果已经选择了译员，就算违法也要开着
        Task task = reportIllegal.getTask();
        User taskUser = task.getUser();
        if (task.getOff() != 0) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/admin/report/illegal";
        }

        BigDecimal price = task.getPrice();
        //避免误操作或者非法操作，检查用户是否付过这笔预付款，并且没有退款过
        //这个有用户参数，因为款要退这个用户，所以要检查是不是他拥有的
        Boolean hasPrepay = balanceRepository.existsByAccountingAndTaskAndUser(
                accountingRepository.findByShortName("prepay"),
                task,
                taskUser
        );

        //这个没有用户参数，因为退给谁我们不管，只要有退款了，这笔钱我们就不能再退
        Boolean hasRefund = balanceRepository.existsByAccountingAndTask(
                accountingRepository.findByShortName("refund"),
                task
        );

        //如果没付过预付款，或者申请退款已经有过，则都是非法操作
        if (!hasPrepay || hasRefund) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/admin/report/illegal";
        }

        //申请退款,因为是管理员处理的退款，所以不用保存用户session
        helper.saveBalance(price, taskUser, "refund", task);

        //状态码为4，因被举报而关闭
        task.setOff(4);
        taskRepository.save(task);
        redirect.addFlashAttribute("message", new Message(1, "关闭任务成功,预付款已经退还给客户"));

        //保存
        reportIllegal.setResult(1);//关闭举报
        reportIllegalRepository.save(reportIllegal);

        return "redirect:/admin/report/illegal";
    }

    //取消举报
    @GetMapping("/admin/report/illegal/cancel")
    public String reportCancel(@RequestParam("id") Integer id, Model model, RedirectAttributes redirect) {
        ReportIllegal reportIllegal = reportIllegalRepository.findByIdAndResult(id, 0);
        if (reportIllegal == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/admin/report/illegal";
        }

        redirect.addFlashAttribute("message", new Message(1, "取消任务举报成功"));
        //保存
        reportIllegal.setResult(2);//关闭举报
        //记录处理管理员，会自动保存到表中
        reportIllegalRepository.save(reportIllegal);
        return "redirect:/admin/report/illegal";
    }


    //留言回复
    @GetMapping("/admin/question")
    public String question(
            @RequestParam(value = "page", required = false) Integer page,
            @RequestParam(value = "result", required = false) Integer result,
            Model model,
            HttpSession session
    ) {
        Integer getPage = page == null ? 0 : page;//从0开始的页数
        Pageable pageable = new PageRequest(getPage, 5, new Sort(Sort.Direction.DESC, "createdAt"));
        Page<Question> questions = null;
        if (result == null) {
            questions = questionRepository.findAll(pageable);
        } else {
            questions = questionRepository.findAllByResult(result, pageable);
        }

        model.addAttribute("questions", questions);
        session.setAttribute("menu","user");
        return "admin/question";
    }

    //回复留言
    @PostMapping("/admin/question/close")
    public String questionClose(
            @RequestParam("id") Integer id,
            @RequestParam("respond") String respond,
            RedirectAttributes redirect
    ) {
        Question question = questionRepository.findByIdAndResult(id, 0);
        if (question == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/admin/question";
        }

        //发送回复邮件
        helper.sendEmail(question.getEmail(), "翻易平台咨询回复", respond, null);

        question.setRespond(respond);
        question.setResult(1);
        questionRepository.save(question);
        redirect.addFlashAttribute("message", new Message(1, "留言回复成功"));
        return "redirect:/admin/question";
    }

    //取消留言
    @GetMapping("/admin/question/cancel")
    public String questionCancel(
            @RequestParam("id") Integer id,
            RedirectAttributes redirect
    ) {
        Question question = questionRepository.findByIdAndResult(id, 0);
        if (question == null) {
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
            return "redirect:/admin/question";
        }

        question.setResult(2);
        questionRepository.save(question);
        redirect.addFlashAttribute("message", new Message(1, "留言取消成功"));
        return "redirect:/admin/question";
    }

    //认证审核
    @GetMapping("/admin/certificate")
    public String adminCertificate(Model model, HttpServletRequest request,HttpSession session) {
        Map<String, String[]> map = request.getParameterMap();
        Integer page = map.containsKey("page") ? Integer.valueOf(map.get("page")[0]) : 0;//从0开始的页数
        User user = null;
        Integer realName = map.containsKey("realName") ? 0 : null;
        Integer certificate = map.containsKey("certificate") ? 0 : null;
        Integer company = map.containsKey("company") ? 0 : null;

        if (map.containsKey("phone")) {
            user = userRepository.findByAttribute_Phone(map.get("phone")[0]);
        }
        if (map.containsKey("username")) {
            user = userRepository.findByUsername(map.get("username")[0]);
        }

        //用户筛选条件：实名，资质，企业，用户
        //用户排序条件：余额排序，信用排序，翻译字数排序，任务数排序，创建时间排序
        //创建分页
        Pageable pageable = new PageRequest(page, 10);
        Page<AdminCheckCertificate> certificates = checkRepository.findAll(AdminCheckCertificteSpec.getSpec(user, realName, certificate, company), pageable);
        model.addAttribute("certificates", certificates);
        session.setAttribute("menu","user");
        return "admin/certificate";
    }

    //实名认证视图
    @GetMapping("/admin/certificate/realName")
    public String realName(Model model, @RequestParam("id") Integer id) {
        AdminCheckCertificate check = checkRepository.findOne(id);
        model.addAttribute("check", check);
        model.addAttribute("certificate", certificateRepository.findByUser(check.getUser()));
        return "admin/check/realName";
    }


    //实名认证不通过
    @PostMapping("/admin/certificate/realName")
    public String realNameForm(
            @RequestParam("id") Integer id,
            @RequestParam("reasons") String reasons,
            RedirectAttributes redirect
    ) {
        AdminCheckCertificate check = checkRepository.findOne(id);
        if (check.getMessage() == null) {
            AdminCheckCertificateMessage message = new AdminCheckCertificateMessage();
            message.setRealNameMessage(reasons);
            checkMessageRepository.save(message);
            check.setMessage(message);
        } else {
            AdminCheckCertificateMessage message = check.getMessage();
            message.setRealNameMessage(reasons);
            checkMessageRepository.save(message);
        }
        check.setRealNameCheck(2);
        checkRepository.save(check);
        redirect.addFlashAttribute("message", new Message(1, "审核已提交"));
        return "redirect:/admin/certificate/realName?id=" + id;
    }

    //实名认证审核通过
    @GetMapping("/admin/certificate/realName/success")
    public String realNameSuccess(
            @RequestParam("id") Integer id,
            RedirectAttributes redirect
    ) {
        AdminCheckCertificate check = checkRepository.findOne(id);
        check.setRealNameCheck(1);
        checkRepository.save(check);

        //实名认证后，直接给这个无论是译员还是客户的人，添加认证客户权限
        User user = check.getUser();
        user.getRoles().add(roleRepository.findByName("ROLE_AUTH_REALNAME"));
        user.getRoles().add(roleRepository.findByName("ROLE_AUTH_CLIENT"));
        //如果译员已经通过资质认证，给这位译员添加为译员认证
        //避免null报错
        if (check.getCertificateCheck() != null && check.getCertificateCheck() == 1) {
            user.getRoles().add(roleRepository.findByName("ROLE_AUTH_USER"));
        }
        userRepository.save(user);

        redirect.addFlashAttribute("message", new Message(1, "审核已提交"));
        return "redirect:/admin/certificate/realName?id=" + id;
    }


    //资质认证视图
    @GetMapping("/admin/certificate/certificate")
    public String certificate(Model model, @RequestParam("id") Integer id) {
        AdminCheckCertificate check = checkRepository.findOne(id);
        User user = check.getUser();
        model.addAttribute("check", check);
        model.addAttribute("certificate", certificateRepository.findByUser(check.getUser()));
        model.addAttribute("educations", educationRepository.findByUser(user));
        model.addAttribute("pictures", certificatePictureRepository.findByUser(user));
        model.addAttribute("papers", certificatePaperRepository.findByUser(user));
        model.addAttribute("prices", translatePriceRepository.findByUser(user));
        model.addAttribute("info", certificateInfoRepository.findByUser(user));
        return "admin/check/education";
    }

    //资质认证不通过
    @PostMapping("/admin/certificate/certificate")
    public String certificateForm(
            @RequestParam("id") Integer id,
            @RequestParam("reasons") String reasons,
            RedirectAttributes redirect
    ) {
        AdminCheckCertificate check = checkRepository.findOne(id);
        if (check.getMessage() == null) {
            AdminCheckCertificateMessage message = new AdminCheckCertificateMessage();
            message.setCertificateMessage(reasons);
            checkMessageRepository.save(message);
            check.setMessage(message);
        } else {
            AdminCheckCertificateMessage message = check.getMessage();
            message.setCertificateMessage(reasons);
            checkMessageRepository.save(message);
        }
        check.setCertificateCheck(2);
        checkRepository.save(check);
        redirect.addFlashAttribute("message", new Message(1, "审核已提交"));
        return "redirect:/admin/certificate/certificate?id=" + id;
    }

    //资质认证审核通过
    @GetMapping("/admin/certificate/certificate/success")
    public String certificateSuccess(
            @RequestParam("id") Integer id,
            RedirectAttributes redirect
    ) {
        AdminCheckCertificate check = checkRepository.findOne(id);
        check.setCertificateCheck(1);
        checkRepository.save(check);

        //如果译员已经通过实名认证，给这位译员添加为译员认证
        if (check.getRealNameCheck() == 1) {
            User user = check.getUser();
            user.getRoles().add(roleRepository.findByName("ROLE_AUTH_USER"));
            userRepository.save(user);
        }


        redirect.addFlashAttribute("message", new Message(1, "审核已提交"));
        return "redirect:/admin/certificate/certificate?id=" + id;
    }


    //企业认证视图
    @GetMapping("/admin/certificate/company")
    public String company(Model model, @RequestParam("id") Integer id) {
        AdminCheckCertificate check = checkRepository.findOne(id);
        model.addAttribute("check", check);
        model.addAttribute("company", companyRepository.findByUser(check.getUser()));
        return "admin/check/company";
    }

    //企业认证不通过
    @PostMapping("/admin/certificate/company")
    public String companyForm(
            @RequestParam("id") Integer id,
            @RequestParam("reasons") String reasons,
            RedirectAttributes redirect
    ) {
        AdminCheckCertificate check = checkRepository.findOne(id);
        if (check.getMessage() == null) {
            AdminCheckCertificateMessage message = new AdminCheckCertificateMessage();
            message.setCompanyMessage(reasons);
            checkMessageRepository.save(message);
            check.setMessage(message);
        } else {
            AdminCheckCertificateMessage message = check.getMessage();
            message.setCompanyMessage(reasons);
            checkMessageRepository.save(message);
        }
        check.setCompanyCheck(2);
        checkRepository.save(check);
        redirect.addFlashAttribute("message", new Message(1, "审核已提交"));
        return "redirect:/admin/certificate/company?id=" + id;
    }

    //企业认证通过
    @GetMapping("/admin/certificate/company/success")
    public String companySuccess(
            @RequestParam("id") Integer id,
            RedirectAttributes redirect
    ) {
        AdminCheckCertificate check = checkRepository.findOne(id);
        check.setCompanyCheck(1);
        checkRepository.save(check);

        //添加认证企业的角色
        User user = check.getUser();
        user.getRoles().add(roleRepository.findByName("ROLE_AUTH_COMPANY"));
        userRepository.save(user);

        redirect.addFlashAttribute("message", new Message(1, "审核已提交"));
        return "redirect:/admin/certificate/company?id=" + id;
    }


}