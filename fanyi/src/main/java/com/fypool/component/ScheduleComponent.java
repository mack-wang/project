package com.fypool.component;

import com.fypool.controller.web.FileCleanController;
import com.fypool.model.SmsNotify;
import com.fypool.repository.AttributeRepository;
import com.fypool.repository.FileCleanRepository;
import com.fypool.repository.SmsNotifyRepository;
import com.fypool.repository.TaskRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.support.ResourcePatternResolver;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.stereotype.Component;

import java.util.Date;

@Component
public class ScheduleComponent {

    @Autowired
    TaskRepository taskRepository;

    @Autowired
    SmsNotifyRepository smsNotifyRepository;

    @Autowired
    AttributeRepository attributeRepository;


    //这个类，可以用来读取/* /** /*/* 匹配型的目录和文件
    @Autowired
    ResourcePatternResolver resourcePatternResolver;

    @Autowired
    FileCleanController fileCleanController;

    //每半小时执行一次，并且每次重新部署都会执行一次
    //置顶到期后，半小时之间把置顶的1变回0
    @Scheduled(fixedDelay = 30 * 60 * 1000)
    public void fixedDelayJob() {
//        System.out.println("定时任务正在执行");
        taskRepository.updateTop(new Date());
    }

    //每天0点整，将提醒短信的数量重置为0
    @Scheduled(cron = "0 0 0 * * ?")
    public void cronJob() {
        smsNotifyRepository.updateUsed();
    }


    //每周日早上4点整，清理每周文件，若出现问题大家加班解决，以便周一工作日不影响用户使用
    @Scheduled(cron = "0 0 4 ? * 1")
    public void cleanEveryWeek() {
        fileCleanController.cleanAdvice();
        fileCleanController.cleanAttachment();
        fileCleanController.cleanAvatar();
        fileCleanController.cleanCertificate();
        fileCleanController.cleanIdCard();
        fileCleanController.cleanLicense();
        fileCleanController.cleanQrcode();
        fileCleanController.cleanVipAttachment();
        fileCleanController.cleanVipTask();
    }



//    @Scheduled(fixedDelay=ONE_Minute)
//    public void fixedDelayJob(){
//        System.out.println(Dates.format_yyyyMMddHHmmss(new Date())+" >>fixedDelay执行....");
//    }
//
//    @Scheduled(fixedRate=ONE_Minute)
//    public void fixedRateJob(){
//        System.out.println(Dates.format_yyyyMMddHHmmss(new Date())+" >>fixedRate执行....");
//    }
//
//    @Scheduled(cron="0 15 3 * * ?")
//    public void cronJob(){
//        System.out.println(Dates.format_yyyyMMddHHmmss(new Date())+" >>cron执行....");
//    }


    //文件清理



}
