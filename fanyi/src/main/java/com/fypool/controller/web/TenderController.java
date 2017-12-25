package com.fypool.controller.web;

import com.fypool.component.HelperController;
import com.fypool.component.SmsUtils;
import com.fypool.model.*;
import com.fypool.model.Process;
import com.fypool.repository.*;
import me.chanjar.weixin.common.exception.WxErrorException;
import me.chanjar.weixin.mp.api.WxMpService;
import me.chanjar.weixin.mp.bean.template.WxMpTemplateData;
import me.chanjar.weixin.mp.bean.template.WxMpTemplateMessage;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.security.Principal;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import java.util.Map;

@Controller
//译员已接任务展示，译员已经投标的任务展示
public class TenderController {

    @Autowired
    TaskUserRepository taskUserRepository;

    @Autowired
    TaskRepository taskRepository;

    @Autowired
    UserRepository userRepository;

    @Autowired
    TaskContentRepository taskContentRepository;

    @Autowired
    ProcessRepository processRepository;

    @Autowired
    AttachmentRepository attachmentRepository;

    @Autowired
    LanguageGroupRepository languageGroupRepository;

    @Autowired
    SmsUtils smsUtils;

    @Autowired
    WxMpService wxMpService;

    @Value("${domain.url}")
    String domainUrl;

    @Autowired
    HelperController helper;

    @GetMapping("/tender")
    public String tender(
            @RequestParam(value = "page", required = false) Integer page,
            @RequestParam(value = "process", required = false) Integer process,
            @RequestParam(value = "type", required = false) Integer type,
            HttpSession session,
            Model model
    ) {
        Integer getPage = page == null ? 0 : page;
        User user = (User) session.getAttribute("user");
        //找出译员所有的投标任务
        Sort sort = new Sort(Sort.Direction.DESC, "createdAt");
        Pageable pageable = new PageRequest(getPage, 5, sort);
        Page<TaskUser> taskUsers = taskUserRepository.findAll(TaskUserSpec.getSpec(process,type,user),pageable);

        model.addAttribute("taskUsers",taskUsers);
        session.setAttribute("menu","tender");
        return "web/user/taskTender";
    }

    @GetMapping("/tender/process")
    public String tenderProcess(
            @RequestParam("id") Integer id,
            HttpSession session,
            Model model
    ) {
        User user = (User) session.getAttribute("user");
        Task task = taskRepository.findOne(id);
        Process process = task.getProcess();


        //3结束后，任务就结束了，钱就打了，评价任务可做可不做
        //对于客户来说：0 选择译员 1 正在翻译 2 审核稿件 3 评价任务
        //对于译员来说：0 正在投标 1 提交翻译 2 客户审核 3 完成任务，显示任务评价
        switch(process.getProcess()){
            case 1:
                TaskUser taskUser = taskUserRepository.findByTaskAndUserAndSelected(task,user,1);
                Integer attachmentCount = attachmentRepository.countByTask(task);
                model.addAttribute("taskUser",taskUser);
                model.addAttribute("task",task);
                model.addAttribute("attachmentCount",attachmentCount);

                return "web/user/processTranslate";
            case 2:
                model.addAttribute("process",process);
                model.addAttribute("attachments",attachmentRepository.findAllByProcess(process));
                return "web/user/processCheck";
            case 3:
                model.addAttribute("process", process);
                model.addAttribute("attachments", attachmentRepository.findAllByProcess(process));
                return "web/user/processComment";
            case 4:
                model.addAttribute("process", process);
                model.addAttribute("attachments", attachmentRepository.findAllByProcess(process));
                return "web/user/processComment";
            default:
                break;
        }

        //如果非法进入的，跳转回原地
        return "redirect:/tender";
    }


    //修改投标报价,只在任务为0状态时可以修改报价
    @PostMapping("/tender/price")
    public @ResponseBody
    Boolean tenderPriceUpdate(
            @RequestParam("price") String price,
            @RequestParam("id") Integer id,
            HttpSession session
    ){
        User user = (User) session.getAttribute("user");
        //找到这个用户拥有的投标
        TaskUser taskUser = taskUserRepository.findByIdAndUser(id,user);
        if(taskUser == null){
            return false;
        }

        if(taskUser.getTask().getOff()!=0){
            return false;
        }

        BigDecimal getPrice = new BigDecimal(price);
        taskUser.setPrice(getPrice);
        taskUserRepository.save(taskUser);
        return true;
    }

    //提交翻译稿件

    @PostMapping("/tender/translate/form")
    public String tenderTranslateForm(
            HttpServletRequest request,
            HttpSession session,
            Principal principal,
            RedirectAttributes redirect
    ) throws WxErrorException {
        User user = userRepository.findByUsername(principal.getName());
        Map<String,String[]> form = request.getParameterMap();
        Integer id = Integer.valueOf(form.get("id")[0]);

        Task task = taskRepository.findOne(id);
        TaskUser taskUser = taskUserRepository.findByTaskAndUserAndSelected(task,user,1);

        //如果非该用户的选中任务，不能提交稿件
        if(taskUser == null){
            redirect.addFlashAttribute("message",new Message(0,"非法操作"));
            return "redirect:/tender/process?id="+id;
        }

        Process process = task.getProcess();

        //保存用户翻译到进程中
        if(form.get("translateContent")[0].length()>0){
            TaskContent translateContent = new TaskContent(form.get("translateContent")[0]);
            taskContentRepository.save(translateContent);
            process.setTranslate(translateContent);
        }

        //保存附件到进程中
        if (form.get("attachmentUrl")[0].length()>0) {
            String[] attachmentUrl = form.get("attachmentUrl")[0].split(",");
            String[] clientWords = form.get("clientWords")[0].split(",");
            if(attachmentUrl.length>0){
                for(int i = 0;i<attachmentUrl.length;i++){
                    Map<String, String> map = (Map<String, String>)session.getAttribute(attachmentUrl[i]);
                    Attachment attachment = new Attachment(
                            map.get("path"),
                            map.get("suffixName"),
                            map.get("type"),
                            Integer.valueOf(map.get("size")),
                            map.get("hasCount"),
                            Integer.valueOf(map.get("pages")),
                            Integer.valueOf(map.get("chars")),
                            Integer.valueOf(map.get("words")),
                            Integer.valueOf(clientWords[i]),
                            process
                    );
                    attachmentRepository.save(attachment);
                    //删除附件的session信息
                    session.removeAttribute(attachmentUrl[i]);
                }
            }
        }

        //设置为客户审核
        process.setProcess(2);
        processRepository.save(process);
        smsUtils.sendTranslated(user.getAttribute().getPhone(),user.getAttribute().getNickname(),task.getUser().getAttribute().getNickname(),task.getTitle());

        //全部完成后，发送微信提醒
        String openId = task.getUser().getOpenId();
        if(openId!=null){
            helper.sendWechatMessage(
                    openId,
                    "/wechat/auth/mytask",
                    "您发布的任务有新的进展",
                    task.getType()==1?"翻译任务":"口译任务",
                    task.getTitle(),
                    taskUser.getUser().getAttribute().getNickname(),
                    "已经完成翻译，请及时审核",
                    "点击查看任务详情"
            );
        }


//        模版IDhaGJ4cS0KLOhenkQmITvQRNe0_rVxpVkxauXbOqgMD4
//                开发者调用模版消息接口时需提供模版ID
//        标题订单进展通知
//        行业商业服务 - 中介服务
//        详细内容
//        {{first.DATA}}
//        订单类型：{{keyword1.DATA}}
//        订单信息：{{keyword2.DATA}}
//        当前服务人：{{keyword3.DATA}}
//        描述：{{keyword4.DATA}}
//        日期：{{keyword5.DATA}}
//        {{remark.DATA}}
//        在发送时，需要将内容中的参数（{{.DATA}}内为参数）赋值替换为需要的信息
//                内容示例

//        尊敬的xxx，下面订单有新的处理进展
//        订单类型：出售订单
//        订单信息：华润橡树湾  别墅
//        当前服务人：【经纪人】 张三  133xxxxxxxx
//        描述：已分配跟单经纪人
//        日期：2017-09-16
//        点击查询订单过程详情。


        return "redirect:/tender/process?id="+id;
    }


    //修改稿件
    @GetMapping("/tender/modify")
    public String tenderModify(
            @RequestParam("id") Integer id,
            HttpSession session,
            RedirectAttributes redirect,
            Model model
    ){
        User user = (User) session.getAttribute("user");
        //check为0时才能修改稿件
        Task task = taskRepository.findOne(id);
        Process process = processRepository.findByTaskAndUser(task,user);
        if(process.getChecked()!=0){
            redirect.addFlashAttribute("message",new Message(0,"不可修改"));
            return "redirect:/tender/process?id="+id;
        }

        TaskUser taskUser = taskUserRepository.findByTaskAndUserAndSelected(task,user,1);
        Integer attachmentCount = attachmentRepository.countByTask(task);
        model.addAttribute("taskUser",taskUser);
        model.addAttribute("attachmentCount",attachmentCount);
        model.addAttribute("languageGroups",languageGroupRepository.findAll());
        model.addAttribute("task",task);
        model.addAttribute("process",process);
        return "web/user/processModify";
    }

    //提交修改的翻译稿件
    @PostMapping("/tender/modify/form")
    public String tenderModifyForm(
            HttpServletRequest request,
            HttpSession session,
            Principal principal,
            RedirectAttributes redirect
    ) throws WxErrorException {
        User user = userRepository.findByUsername(principal.getName());
        Map<String,String[]> form = request.getParameterMap();
        Integer id = Integer.valueOf(form.get("id")[0]);

        Task task = taskRepository.findOne(id);
        TaskUser taskUser = taskUserRepository.findByTaskAndUserAndSelected(task,user,1);

        //如果非该用户的选中任务，不能提交稿件
        if(taskUser == null){
            redirect.addFlashAttribute("message",new Message(0,"非法操作"));
            return "redirect:/tender/process?id="+id;
        }

        Process process = task.getProcess();

        //保存用户翻译到进程中
        if(form.get("translateContent")[0].length()>0){
            //如果已经保存过，则覆盖，没有就新建
            if(process.getTranslate()!=null){
                TaskContent translateContent = process.getTranslate();
                translateContent.setContent(form.get("translateContent")[0]);
            }else{
                TaskContent translateContent = new TaskContent(form.get("translateContent")[0]);
                taskContentRepository.save(translateContent);
                process.setTranslate(translateContent);
            }
        }

        //保存附件到进程中
        if (form.get("attachmentUrl")[0].length()>0) {
            //删除原先的附件
            List<Attachment> attachments = attachmentRepository.findAllByProcess(process);
            for(Attachment attachment:attachments){
                attachmentRepository.delete(attachment);
            }

            //保存新附件
            String[] attachmentUrl = form.get("attachmentUrl")[0].split(",");
            String[] clientWords = form.get("clientWords")[0].split(",");
            if(attachmentUrl.length>0){
                for(int i = 0;i<attachmentUrl.length;i++){
                    Map<String, String> map = (Map<String, String>)session.getAttribute(attachmentUrl[i]);
                    Attachment attachment = new Attachment(
                            map.get("path"),
                            map.get("suffixName"),
                            map.get("type"),
                            Integer.valueOf(map.get("size")),
                            map.get("hasCount"),
                            Integer.valueOf(map.get("pages")),
                            Integer.valueOf(map.get("chars")),
                            Integer.valueOf(map.get("words")),
                            Integer.valueOf(clientWords[i]),
                            process
                    );
                    attachmentRepository.save(attachment);
                    //删除附件的session信息
                    session.removeAttribute(attachmentUrl[i]);
                }
            }
        }

        //全部完成后，发送微信提醒
        String openId = task.getUser().getOpenId();
        if(openId!=null){
            helper.sendWechatMessage(
                    openId,
                    "/wechat/auth/mytask",
                    "您发布的任务有新的进展",
                    task.getType()==1?"翻译任务":"口译任务",
                    task.getTitle(),
                    taskUser.getUser().getAttribute().getNickname(),
                    "已经完成翻译修改，请及时审核",
                    "点击查看任务详情"
            );
        }

        //设置客户审核为2，表示译员修改完毕
        process.setChecked(2);
        processRepository.save(process);

        smsUtils.sendTranslated(user.getAttribute().getPhone(),user.getAttribute().getNickname(),task.getUser().getAttribute().getNickname(),task.getTitle());

        return "redirect:/tender/process?id="+id;
    }



}
