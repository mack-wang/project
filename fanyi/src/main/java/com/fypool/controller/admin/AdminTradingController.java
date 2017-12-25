package com.fypool.controller.admin;


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
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.persistence.EntityManager;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.math.BigDecimal;
import java.util.List;
import java.util.Map;

@Controller
public class AdminTradingController {

    @Autowired
    BalanceRepository balanceRepository;

    @Autowired
    EntityManager entityManager;

    @Autowired
    UserRepository userRepository;

    @Autowired
    AccountingRepository accountingRepository;

    //显示交易记录
    @GetMapping("/admin/trading/record")
    public String tradingRecord(
            HttpServletRequest request,
            HttpSession session,
            Model model
    ) {
        Map<String,String[]> map = request.getParameterMap();
        Integer getPage = map.containsKey("page")?Integer.valueOf(map.get("page")[0]):0;
        Accounting accounting = null;
        User user = null;
        String title = map.containsKey("title")?map.get("title")[map.get("title").length-1]:null;
        Integer type = map.containsKey("type")?Integer.valueOf(map.get("type")[map.get("type").length-1]):null;

        if(map.containsKey("accounting")){
            accounting = accountingRepository.findOne(Integer.valueOf(map.get("accounting")[map.get("accounting").length-1]));
        }

        if(map.containsKey("username")){
            user = userRepository.findByUsername(map.get("username")[map.get("username").length-1]);
        }

        if(map.containsKey("phone")){
            user = userRepository.findByAttribute_Phone(map.get("phone")[map.get("phone").length-1]);
        }



        Pageable pageable = new PageRequest(getPage, 10);
        Page<Balance> balances = balanceRepository.findAll(BalanceSpec.getSpec(accounting,title,type,user),pageable);

        //计算平台总支出
        Object  expend = entityManager.createQuery("select sum(variation) from Balance where accounting.type = 0").getSingleResult();

        //计算平台总收出
        Object income = entityManager.createQuery("select sum(variation) from Balance where accounting.type = 1").getSingleResult();

        //平台利润
        Object profit = entityManager.createQuery("select sum(variation) from Balance where accounting.id in (1,13,14,15)").getSingleResult();

        //要从平台利润中减去！
        Object ticket = entityManager.createQuery("select sum(variation) from Balance where accounting.id = 16").getSingleResult();

        BigDecimal p = new BigDecimal(profit.toString()).subtract(new BigDecimal(ticket.toString()));

        model.addAttribute("balances",balances);
        model.addAttribute("income",income);
        model.addAttribute("expend",expend);
        model.addAttribute("profit",p);
        model.addAttribute("accountings",accountingRepository.findAll());
        session.setAttribute("menu","record");
        return "admin/tradingRecord";
    }


}
