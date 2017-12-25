package com.fypool.controller.web;

import com.fypool.component.HelperController;
import com.fypool.component.ReadFileUtils;
import com.fypool.model.*;
import com.fypool.model.Process;
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
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.security.Principal;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.TimeUnit;


@Controller
public class TaskController {
    @Autowired
    HelperController helper;

    @Autowired
    ReadFileUtils readFileUtils;

    @Autowired
    RedisTemplate redisTemplate;

    @Autowired
    LanguageGroupRepository languageGroupRepository;

    @Autowired
    QualityRepository qualityRepository;

    @Autowired
    PriceRepository priceRepository;

    @Autowired
    UserRepository userRepository;

    @Autowired
    SkilledUsageRepository skilledUsageRepository;

    @Autowired
    SkilledFieldRepository skilledFieldRepository;

    @Autowired
    TaskRepository taskRepository;

    @Autowired
    AttachmentRepository attachmentRepository;

    @Autowired
    TaskContentRepository taskContentRepository;

    @Autowired
    TaskInterpretRepository taskInterpretRepository;

    @Autowired
    MhCityRepository mhCityRepository;

    @Autowired
    ProcessRepository processRepository;

    @Autowired
    TicketRepository ticketRepository;

    @GetMapping("/task")
    public String task(Model model, HttpSession session, Principal principal) {
        session.setAttribute("menu", "task");
        if (session.getAttribute("translateStep") != null) {
            switch ((Integer) session.getAttribute("translateStep")) {
                case 1:
                    model.addAttribute("qualities", qualityRepository.findAll());
                    return "web/client/taskRequest";
                case 2:
                    Map<String, Integer> detail = new HashMap<>();

                    Integer words = 0;
                    Integer attachmentCount = 0;
                    Integer attachmentWords = 0;
                    Integer totalWords = 0;

                    Map<String, String[]> map = (Map<String, String[]>) session.getAttribute("translateOneForm");
                    //是否是口译任务
                    Boolean isInterpret = map.get("taskType")[0].equals("interpret");

                    LanguageGroup languageGroup = languageGroupRepository.findOne(Integer.valueOf(map.get("languageGroup")[0]));

                    //绑定翻译的语言
                    model.addAttribute("languageGroup", languageGroup);

                    if (map.get("translateContent")[0].length() > 0) {
                        //根据翻译的类型来获取字数
                        if (languageType(languageGroup).equals("char")) {
                            words = readFileUtils.countChars(map.get("translateContent")[0]);
                        } else {
                            words = readFileUtils.countWords(map.get("translateContent")[0]);
                        }
                    }

                    if (map.get("attachmentUrl")[0].length() > 0) {
                        //总附件数
                        attachmentCount = map.get("attachmentUrl")[0].split(",").length;
                        for (String item : map.get("clientWords")[0].split(",")) {
                            attachmentWords += Integer.valueOf(item);
                        }
                    }

                    //总字数
                    totalWords = words + attachmentWords;

                    if (isInterpret) {
                        model.addAttribute("interpretStartTime", map.get("interpretStartTime")[0]);
                        model.addAttribute("interpretEndTime", map.get("interpretEndTime")[0]);
                        model.addAttribute("interpretType", map.get("interpretType")[0]);
                        model.addAttribute("workTime", map.get("workTime")[0]);
                    }

                    model.addAttribute("taskType", map.get("taskType")[0]);

                    detail.put("totalWords", totalWords);
                    detail.put("attachmentCount", attachmentCount);
                    detail.put("attachmentWords", attachmentWords);
                    detail.put("words", words);
                    model.addAttribute("detail", detail);
                    User user = userRepository.findByUsername(principal.getName());
                    model.addAttribute("account", user.getAccount());
                    return "web/client/taskPublish";
            }
        }

        model.addAttribute("languageGroups", languageGroupRepository.findAll());
        return "web/client/task";
    }

    @GetMapping("/task/interpret")
    public String taskInterpret(Model model) {
        model.addAttribute("languageGroups", languageGroupRepository.findAll());
        return "web/client/taskInterpret";
    }


    @PostMapping("/task/upload/attachment")
    public @ResponseBody
    Map<String, String> uploadAttachment(
            @RequestParam("attachment") MultipartFile file,
            @RequestParam("languageGroup") Integer id,
            HttpSession session
    ) {
        Boolean opposite = false;
        if (id < 0) {
            id = -id;
            opposite = true;
        }

        String type = languageType(languageGroupRepository.findOne(id));

        //如果languageGroup的id是负数，则统计方式相反
        if (opposite) {
            if (type.equals("char")) {
                type = "word";
            } else {
                type = "char";
            }
        }

        Map<String, String> map = helper.uploadFileAndCountWord(file, "attachment", type);
        session.setAttribute(map.get("uuid"), map);
        return map;
    }

    @PostMapping("/task/translate/one/form")
    public String translateOneForm(
            HttpServletRequest request,
            HttpSession session
    ) {
        Map map = request.getParameterMap();
        //附件详情以uuid为key保存到session中，每提交一步，都保存到session中，并记录用户当前在哪步骤，用户可以重新编辑，重新编辑时，删除相应的session记录和附件。
        //如果有必要，还要对参数做验证
        session.setAttribute("translateOneForm", map);
        session.setAttribute("translateStep", 1);
        return "redirect:/task";
    }

    @PostMapping("/task/translate/two/form")
    public String translateTwoForm(
            HttpServletRequest request,
            HttpSession session
    ) {
        Map map = request.getParameterMap();
        session.setAttribute("translateTwoForm", map);
        session.setAttribute("translateStep", 2);
        return "redirect:/task";
    }

    public String languageType(LanguageGroup languageGroup) {
        String language = languageGroup.getOriginLanguages().getEname();
        String type;
        switch (language) {
            case "Chinese":
                type = "char";
                break;
            case "Japanese":
                type = "char";
                break;
            case "Korean":
                type = "char";
                break;
            default:
                type = "word";
                break;
        }
        return type;
    }


    @PostMapping("/task/translate/three/form")
    public String translateThreeForm(
            HttpServletRequest request,
            HttpSession session,
            Principal principal,
            RedirectAttributes redirect
    ) {

        User user = userRepository.findByUsername(principal.getName());
        //languageGroup,translateContent,attachmentUrl,clientWords
        Map<String, String[]> form1 = (Map<String, String[]>) session.getAttribute("translateOneForm");
        //brief,translateRequest,skilledField,skilledUsage,quality
        Map<String, String[]> form2 = (Map<String, String[]>) session.getAttribute("translateTwoForm");
        //taskEndTime,translateEndTime,emergency,price,password

        TaskContent requestContent = new TaskContent(form2.get("translateRequest")[0]);
        taskContentRepository.save(requestContent);

        Task task = new Task(
                languageGroupRepository.findOne(Integer.valueOf(form1.get("languageGroup")[0])),
                requestContent,
                qualityRepository.findOne(Integer.valueOf(form2.get("quality")[0])),
                Integer.valueOf(request.getParameter("emergency")),
                helper.parseDate(request.getParameter("taskEndTime")),
                user,
                form1.get("title")[0],
                Integer.valueOf(request.getParameter("words")),
                Integer.valueOf(request.getParameter("attachmentWords")),
                Integer.valueOf(request.getParameter("words"))+Integer.valueOf(request.getParameter("attachmentWords"))
        );

        //是否是口译任务
        Boolean isInterpret = form1.get("taskType")[0].equals("interpret");
        if (isInterpret) {
            //如果是口译
            TaskInterpret interpret = new TaskInterpret(
                    Integer.valueOf(form1.get("interpretType")[0]),
                    helper.parseDate(form1.get("interpretStartTime")[0]),
                    helper.parseDate(form1.get("interpretEndTime")[0]),
                    Integer.valueOf(form1.get("workTime")[0]),
                    mhCityRepository.findOne(Integer.valueOf(form1.get("province")[0])),
                    mhCityRepository.findOne(Integer.valueOf(form1.get("city")[0])),
                    mhCityRepository.findOne(Integer.valueOf(form1.get("area")[0])),
                    form1.get("address")[0]
            );
            taskInterpretRepository.save(interpret);
            task.setType(0);
            task.setInterpret(interpret);
        } else {
            //如果是笔译
            task.setType(1);
            task.setTranslateEndTime(helper.parseDate(request.getParameter("translateEndTime")));
        }

        //以下均为选填项
        if (form1.get("translateContent")[0].length() > 0) {
            TaskContent translateContent = new TaskContent(form1.get("translateContent")[0]);
            taskContentRepository.save(translateContent);
            task.setTaskContent(translateContent);
        }

        String skilledField = form2.get("skilledField")[0];
        if (skilledField.length() > 0) {
            task.setField(skilledFieldRepository.findOne(Integer.valueOf(skilledField)));
        }
        String skilledUsage = form2.get("skilledUsage")[0];
        if (skilledUsage.length() > 0) {
            task.setUsage(skilledUsageRepository.findOne(Integer.valueOf(skilledUsage)));
        }
        String brief = form2.get("brief")[0];
        if (brief.length() > 0) {
            TaskContent briefContent = new TaskContent(brief);
            taskContentRepository.save(briefContent);
            task.setBrief(briefContent);
        }
        taskRepository.save(task);

        //同时保存任务进程
        processRepository.save(new Process(task));

        if (form1.get("attachmentUrl")[0].length() > 0) {
            String[] attachmentUrl = form1.get("attachmentUrl")[0].split(",");
            String[] clientWords = form1.get("clientWords")[0].split(",");

            if (attachmentUrl.length > 0) {
                for (int i = 0; i < attachmentUrl.length; i++) {
                    Map<String, String> map = (Map<String, String>) session.getAttribute(attachmentUrl[i]);
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
                            task
                    );
                    attachmentRepository.save(attachment);
                    //删除附件的session信息
                    session.removeAttribute(attachmentUrl[i]);
                }
            }
        }

        //删除所有的临时表单session
        session.removeAttribute("translateStep");
        session.removeAttribute("translateOneForm");
        session.removeAttribute("translateTwoForm");

        redirect.addFlashAttribute("message", new Message(1, "任务发布成功"));
        if (isInterpret) {
            return "redirect:/task/interpret";
        } else {
            return "redirect:/task";
        }
    }

    //翻译任务重新编辑
    @GetMapping("/task/translate/reset")
    public String translateThreeForm(
            HttpSession session
    ) {
        //删除附件
        Map<String, String[]> form1 = (Map<String, String[]>) session.getAttribute("translateOneForm");
        String[] attachmentUrl = form1.get("attachmentUrl")[0].split(",");
        for (String attachment : attachmentUrl) {
            session.removeAttribute(attachment);
        }
        Boolean isInterpret = form1.get("taskType")[0].equals("interpret");
        session.removeAttribute("translateStep");
        session.removeAttribute("translateOneForm");
        session.removeAttribute("translateTwoForm");

        if (isInterpret) {
            return "redirect:/task/interpret";
        } else {
            return "redirect:/task";
        }
    }

}
























