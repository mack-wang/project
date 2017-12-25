package com.fypool.controller.web;

import com.fypool.component.HelperController;
import com.fypool.model.*;
import com.fypool.repository.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.data.redis.core.ValueOperations;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.security.Principal;
import java.util.Date;
import java.util.Map;
import java.util.concurrent.TimeUnit;

@Controller
public class DetailController {
    @Autowired
    TaskRepository taskRepository;

    @Autowired
    LanguageGroupRepository languageGroupRepository;

    @Autowired
    AttachmentRepository attachmentRepository;

    @Autowired
    AdminCheckCertificateRepository check;

    @Autowired
    TaskUserRepository taskUserRepository;

    @Autowired
    CompanyRepository companyRepository;

    @Autowired
    IllegalRepository illegalRepository;

    @Autowired
    ReportIllegalRepository reportIllegalRepository;

    @Autowired
    WebRepository webRepository;


    //查看已发布的任务
    @GetMapping("/task/detail")
    public String detail(@RequestParam("id") Integer id, Model model, HttpSession session){


        Task task = taskRepository.findOne(id);
        //浏览次数+1
        task.setPv(task.getPv()+1);
        taskRepository.save(task);

        User user = (User) session.getAttribute("user");
        //客户已经加入几个月，向上舍入取整
        Double joinMonth = Math.ceil((System.currentTimeMillis() - task.getUser().getCreatedAt().getTime())/2592000000L);

        model.addAttribute("task",task);
        model.addAttribute("attachments",attachmentRepository.findAllByTask(task));
        model.addAttribute("userAttachments",attachmentRepository.findAllByProcess(task.getProcess()));
        model.addAttribute("check",check.findByUser(task.getUser()));
        model.addAttribute("joinMonth",joinMonth.intValue()==0?1:joinMonth.intValue());

        //判断这个用户是否已经投标
        model.addAttribute("isSelected",taskUserRepository.existsByTaskAndUser(task,user));
        model.addAttribute("taskUser",taskUserRepository.findByTaskAndUser(task,user));

        //总投标数
        User user1 = task.getUser();
        model.addAttribute("totalDone",taskRepository.countAllByUserAndOff(user1,3));
        model.addAttribute("totalTasks",taskRepository.countByUser(user1));
        model.addAttribute("company",companyRepository.findByUser(user1));
        model.addAttribute("illegals",illegalRepository.findAll());
        model.addAttribute("web",webRepository.findOne(1));

        if(session.getAttribute("user")==null){
            return "web/detailPublic";
        }else{
            return "web/detail";
        }

    }

    //举报任务
    @GetMapping("/report/illegal")
    public String reportIllegal(
            @RequestParam("task") Integer taskId,
            @RequestParam("illegal") Integer illegalId,
            HttpSession session,
            RedirectAttributes redirect
    ){
        User user =(User) session.getAttribute("user");
        //只有正在进行的任务可以举报，其他任务不能举报
        Task task = taskRepository.findByIdAndOff(taskId,0);

        if(task == null){
            redirect.addFlashAttribute("message",new Message(0,"只有正在进行中的任务才可以举报"));
            return "redirect:/task/detail?id="+taskId;
        }

        if(task.getUser().getId() == user.getId()){
            redirect.addFlashAttribute("message",new Message(0,"发布者不能举报自己的任务"));
            return "redirect:/task/detail?id="+taskId;
        }

        if(reportIllegalRepository.existsByTaskAndUser(task,user)){
            redirect.addFlashAttribute("message",new Message(0,"您的举报已经提交，请不要重复提交举报"));

        }else{
            Illegal illegal = illegalRepository.findOne(illegalId);
            reportIllegalRepository.save(new ReportIllegal(task,user,illegal,0));
            redirect.addFlashAttribute("message",new Message(1,"举报提交成功，我们将会及时处理！"));
        }
        return "redirect:/task/detail?id="+taskId;
    }




}
