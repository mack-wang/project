package com.fypool.controller.wechat;

import com.fypool.component.HelperController;
import com.fypool.model.*;
import com.fypool.repository.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ResponseBody;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.security.Principal;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Map;

@Controller
public class WechatMarketController {

    @Autowired
    TaskRepository taskRepository;

    @Autowired
    PriceRangeRepository priceRangeRepository;

    @Autowired
    LanguageGroupRepository languageGroupRepository;

    @Autowired
    private EntityManager entityManager;

    @Autowired
    WebRepository webRepository;

    @Autowired
    SkilledFieldRepository skilledFieldRepository;

    @Autowired
    SkilledUsageRepository skilledUsageRepository;

    @Autowired
    QualityRepository qualityRepository;

    @Autowired
    UserRepository userRepository;



    @GetMapping("/wechat/auth/market")
    public String market(
            Model model,
            HttpServletRequest request,
            HttpSession session,
            Principal principal
    ) {
        User user = userRepository.findByUsername(principal.getName());

        if (user.getOpenId() == null) {
            Object openId = session.getAttribute("openId");
            if(openId==null){
                //如果openId不存在，则跳转前去获取
                return "redirect:/wechat/public/relogin";
            }else{
                //如果用户没有openId，则立即保存用户的openId
                String openIdStr = openId.toString();
                //检查这个openId是否已经被使用
                User user1 = userRepository.findByOpenId(openIdStr);
                if (user1 != null) {
                    //把已经有这个openid的用户的openid重置为null
                    user1.setOpenId(null);
                    userRepository.save(user1);
                } else {
                    user.setOpenId(openIdStr);
                    userRepository.save(user);
                }
            }
        }

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


        if (map.containsKey("group")) {
            group = languageGroupRepository.findOne(Integer.valueOf(map.get("group")[0]));
        }

        if (map.containsKey("quality")) {
            quality = qualityRepository.findOne(Integer.valueOf(map.get("quality")[0]));
        }


        Page<Task> tasks = taskRepository.findAll(TaskSpec.getSpec(0, new Date(), emergency, title, type, null, group, fields, usages, quality, null, translateEndTime, startTime, totalWords, 1), pageable);

        model.addAttribute("tasks", tasks);
        model.addAttribute("languageGroup", languageGroupRepository.findAll());
        model.addAttribute("skilledFields", skilledFieldRepository.findAll());
        model.addAttribute("skilledUsages", skilledUsageRepository.findAll());
        model.addAttribute("web", webRepository.findOne(1));
        session.setAttribute("menu", "market");

        //登入用户到个人中心的翻易大厅
        return "web/wechat/market";
    }


}
