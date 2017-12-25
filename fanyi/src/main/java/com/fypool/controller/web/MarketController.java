package com.fypool.controller.web;

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
import org.springframework.web.bind.annotation.RequestParam;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.security.Principal;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Map;

@Controller
public class MarketController {

    @Autowired
    TaskRepository taskRepository;

    @Autowired
    PriceRangeRepository priceRangeRepository;

    @Autowired
    LanguageGroupRepository languageGroupRepository;

    @Autowired
    private EntityManager entityManager;

    @Autowired
    UserRepository userRepository;

    @Autowired
    WebRepository webRepository;

    @Autowired
    SkilledFieldRepository skilledFieldRepository;

    @Autowired
    SkilledUsageRepository skilledUsageRepository;

    @Autowired
    QualityRepository qualityRepository;

    @GetMapping("/market")
    public String market(
            Model model,
            HttpServletRequest request,
            HttpSession session
    ) {
        User user = null;
        Map<String, String[]> map = request.getParameterMap();

        Integer page = map.containsKey("page") ? Integer.valueOf(map.get("page")[0]) : 0;//从0开始的页数
        Integer size = map.containsKey("size") ? Integer.valueOf(map.get("size")[0]) : 20;//从0开始的页数
        String title = null;
        List<SkilledField> fields = new ArrayList<>();
        List<SkilledUsage> usages = new ArrayList<>();
        Integer emergency = null;
        Integer type = null;
        Quality quality = null;
        LanguageGroup group = null;
        String translateEndTime = map.containsKey("translateEndTime") ? map.get("translateEndTime")[0] : null;
        String startTime = map.containsKey("startTime") ? map.get("startTime")[0] : null;
        String totalWords = map.containsKey("totalWords") ? map.get("totalWords")[0] : null;

        //创建分页
        Pageable pageable = new PageRequest(page, size);

        if (map.containsKey("field")) {
            for (String field : map.get("field")) {
                fields.add(skilledFieldRepository.findOne(Integer.valueOf(field)));
            }
        }

        if (map.containsKey("usage")) {
            for (String usage : map.get("usage")) {
                usages.add(skilledUsageRepository.findOne(Integer.valueOf(usage)));
            }
        }

        if (map.containsKey("emergency")) {
            emergency = Integer.valueOf(map.get("emergency")[0]);
        }

        if (map.containsKey("type")) {
            type = Integer.valueOf(map.get("type")[0]);
        }

        if (map.containsKey("title")) {
            title = map.get("title")[map.get("title").length - 1];
        }


        if (map.containsKey("user")) {
            user = (User) session.getAttribute("user");
        }


        if (map.containsKey("group")) {
            group = languageGroupRepository.findOne(Integer.valueOf(map.get("group")[0]));
        }

        if (map.containsKey("quality")) {
            quality = qualityRepository.findOne(Integer.valueOf(map.get("quality")[0]));
        }


        Page<Task> tasks = null;

        //如果当前用户是管理员，则可以查看所有的任务，包括关闭了的任务
        if (session.getAttribute("user") != null) {
            User currentUser = (User) session.getAttribute("user");
            if (currentUser.getCurrentRole().equals("ROLE_ADMIN")) {
                //如果是管理员，还可以根据用户名，用户手机，任务状态，来搜索
                Integer off = null;

                Date taskEndTime = null;

                if (map.containsKey("phone")) {
                    user = userRepository.findByAttribute_Phone(map.get("phone")[map.get("phone").length - 1]);
                }

                if (map.containsKey("username")) {
                    user = userRepository.findByUsername(map.get("username")[map.get("username").length - 1]);
                }

                if (map.containsKey("off")) {
                    off = Integer.valueOf(map.get("off")[0]);
                }

                if (map.containsKey("taskEndTime")) {
                    taskEndTime = new Date();
                }

                tasks = taskRepository.findAll(TaskSpec.getSpec(off, taskEndTime, emergency, title, type, user, group, fields, usages, quality, null, translateEndTime, startTime, totalWords,1), pageable);
            } else {
                tasks = taskRepository.findAll(TaskSpec.getSpec(0, new Date(), emergency, title, type, user, group, fields, usages, quality, null, translateEndTime, startTime, totalWords,1), pageable);
            }
        } else {
            tasks = taskRepository.findAll(TaskSpec.getSpec(0, new Date(), emergency, title, type, user, group, fields, usages, quality, null, translateEndTime, startTime, totalWords,1), pageable);
        }

        model.addAttribute("tasks", tasks);
        model.addAttribute("languageGroup", languageGroupRepository.findAll());
        model.addAttribute("skilledFields", skilledFieldRepository.findAll());
        model.addAttribute("skilledUsages", skilledUsageRepository.findAll());
        model.addAttribute("web", webRepository.findOne(1));
        session.setAttribute("menu", "market");

        //如果带参数p，public的意思，无论是否登入都到公开大厅
        if (map.containsKey("p")) {
            return "web/marketPublic";
        }

        //如果用户未登入，也到公开大厅
        if (session.getAttribute("user") == null) {
            return "web/marketPublic";
        }


        //登入用户到个人中心的翻易大厅
        return "web/market";
    }


}
