package com.fypool.controller.wechat;

import com.fypool.component.HelperController;
import com.fypool.component.SmsUtils;
import com.fypool.model.*;
import com.fypool.model.Process;
import com.fypool.repository.*;
import org.springframework.beans.factory.annotation.Autowired;
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
import java.util.*;
import java.util.concurrent.TimeUnit;

@Controller
public class WechatProcessController {

    @Autowired
    TaskRepository taskRepository;

    @GetMapping("/wechat/auth/process")
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
        return "web/wechat/taskProcess";
    }

}
