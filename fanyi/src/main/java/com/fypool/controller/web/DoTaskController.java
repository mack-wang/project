package com.fypool.controller.web;

import com.fypool.component.HelperController;
import com.fypool.component.SmsUtils;
import com.fypool.model.*;
import com.fypool.repository.TaskRepository;
import com.fypool.repository.TaskUserRepository;
import me.chanjar.weixin.common.exception.WxErrorException;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.math.BigDecimal;

@Controller
public class DoTaskController {
    @Autowired
    TaskRepository taskRepository;

    @Autowired
    TaskUserRepository taskUserRepository;

    @Autowired
    SmsUtils smsUtils;

    @Autowired
    HelperController helper;

    @PostMapping("/task/selected")
    public String taskSelected(
            @RequestParam("id") Integer id,
            @RequestParam("price") String price,
            HttpSession session,
            HttpServletRequest request,
            RedirectAttributes redirect
    ) throws WxErrorException {
        User user = (User) session.getAttribute("user");
        //只有正在进行的任务才能投标
        Task task = taskRepository.findByIdAndOff(id,0);
        if(task == null){
            redirect.addFlashAttribute("message",new Message(0,"只有正在进行报价阶段的任务才能报价"));
            return "redirect:/task/detail?id="+id;
        }

        //任务发布者不能接自己发布的任务，以免刷单
        if(task.getUser().getUsername().equals(user.getUsername())){
            redirect.addFlashAttribute("message",new Message(0,"任务发布者不能对自己的任务报价！"));
            return "redirect:/task/detail?id="+id;
        }

        //不管当前用户是译员还是客户，则要有认证译员的身份，就能接任务
        if(request.isUserInRole("ROLE_AUTH_USER")){
            //参与人数+1
            task.setJoins(task.getJoins()+1);
            //通知用户，已经有人报价，并且只通知一次
            if(task.getNotify()==null){
                Attribute attribute = task.getUser().getAttribute();
                //通知用户，已经有人报价，并把notify变成1
                smsUtils.sendClient(attribute.getPhone(),attribute.getNickname(),task.getTitle());

                //微信通知，用户有人报价了
                String openId = user.getOpenId();
                if(openId!=null){
                    helper.sendWechatMessage(
                            openId,
                            "/wechat/auth/mytask",
                            "您发布的任务有新的进展",
                            task.getType()==1?"翻译任务":"口译任务",
                            task.getTitle(),
                            "翻易译员",
                            "您的任务已经有译员报价",
                            "点击查看任务详情"
                    );
                }

                task.setNotify(1);
            }

            taskRepository.save(task);

            //任务参与用户新增,记得要把用户的属性也保存
            taskUserRepository.save(new TaskUser(task,user,new BigDecimal(price),user.getAttribute()));
        }else{
            if(user.getCurrentRole().equals("ROLE_USER")){
                redirect.addFlashAttribute("message",new Message(0,"只有通过认证译员才能接任务"));
                redirect.addFlashAttribute("nameMessage",new Message(0,"只有通过认证译员才能接任务"));
                return "redirect:/user/certificate";
            }else{
                redirect.addFlashAttribute("message",new Message(0,"请注册译员并认证"));
                return "redirect:/task/detail?id="+id;
            }
        }
        redirect.addFlashAttribute("message",new Message(1,"任务报价成功"));
        return "redirect:/task/detail?id="+id;
    }

    @GetMapping("/task/cancel")
    public String taskCancel(@RequestParam("id") Integer id,HttpSession session,RedirectAttributes redirect){
        User user = (User) session.getAttribute("user");
        Task task = taskRepository.findOne(id);
        //如果用户没有被选中，则可以取消任务
        TaskUser taskUser = taskUserRepository.findByTaskAndUserAndSelected(task,user,0);
        //如果任务用户不存在，或者已经被选中，则不能通过这个来取消
        if(taskUser == null){
            redirect.addFlashAttribute("message",new Message(0,"非法操作"));
            return "redirect:/task/detail?id="+id;
        }

        //参与人数-1
        task.setJoins(task.getJoins()-1);
        taskRepository.save(task);
        //任务参与用户删除
        taskUserRepository.delete(taskUser);
        redirect.addFlashAttribute("message",new Message(1,"任务报价取消成功"));
        return "redirect:/task/detail?id="+id;
    }


}
