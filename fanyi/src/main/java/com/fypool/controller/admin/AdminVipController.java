package com.fypool.controller.admin;


import com.fypool.component.HelperController;
import com.fypool.model.*;
import com.fypool.repository.*;
import org.springframework.beans.factory.annotation.Autowired;
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
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

@Controller
public class AdminVipController {

    @Autowired
    LanguageGroupRepository languageGroupRepository;

    @Autowired
    HelperController helper;

    @Autowired
    UserRepository userRepository;

    @Autowired
    VipPriceRepository vipPriceRepository;

    @Autowired
    VipRepository vipRepository;

    @Autowired
    RoleRepository roleRepository;

    @GetMapping("/admin/vip")
    public String adminVip(Model model,HttpSession session) {
        model.addAttribute("languageGroups", languageGroupRepository.findAll());
        session.setAttribute("menu","adminvip");
        return "admin/newVip";
    }

    @PostMapping("/admin/upload/contract")
    public @ResponseBody
    String uploadAttachment(
            @RequestParam("contractAttachment") MultipartFile file
    ) {
        return helper.uploadFile(file, "contract");
    }

    //新增vip
    @PostMapping("/admin/vip/add")
    public String adminVipAdd(
            HttpServletRequest request,
            RedirectAttributes redirect
    ) {
        Map<String, String[]> map = request.getParameterMap();
        User user = userRepository.findByUsername(map.get("username")[0]);
        if (user == null) {
            redirect.addFlashAttribute("message", new Message(0, "用户名错误，该用户不存在"));
            return "redirect:/admin/vip";
        }

        //如果用户没有客户角色，不给创建vip
        if (!user.getRoles().contains(roleRepository.findByName("ROLE_CLIENT"))) {
            redirect.addFlashAttribute("message", new Message(0, "该用户没有注册成为客户，不能创建vip"));
            return "redirect:/admin/vip";
        }

        //保存翻译价格
        List<VipPrice> vipPriceList = new ArrayList<>();
        String[] prices = request.getParameter("price").split(",");
        for (String item : prices) {
            String[] price = item.split("&");
            vipPriceList.add(vipPriceRepository.save(
                    new VipPrice(
                            price[1],
                            Integer.valueOf(price[2]),
                            price[3],
                            languageGroupRepository.findOne(Integer.valueOf(price[0]))
                    )
            ));
        }

        vipRepository.save(new Vip(
                user,
                Integer.valueOf(map.get("type")[0]),
                helper.parseDate(request.getParameter("endTime")),
                vipPriceList,
                map.get("path")[0].length() > 0 ? map.get("path")[0] : null
        ));

        //添加vip角色，并保存
        user.getRoles().add(roleRepository.findByName("ROLE_AUTH_VIP"));
        userRepository.save(user);

        redirect.addFlashAttribute("message", new Message(1, "Vip客户创建成功"));
        return "redirect:/admin/vip";
    }

    //显示vip信息
    @GetMapping("/admin/profile/vip")
    public String profileVip(@RequestParam("view") String username, Model model) {
        model.addAttribute("vip", userRepository.findByUsername(username).getVip());
        return "admin/showVip";
    }

    //修改vip信息
    @PostMapping("/admin/vip/update")
    public String profileVip(HttpServletRequest request, RedirectAttributes redirect) {
        String username = request.getParameter("username");
        Vip vip = vipRepository.findByUser_Username(username);
        String field = request.getParameter("field");
        switch (field) {
            case "type":
                vip.setType(Integer.valueOf(request.getParameter("type")));
                redirect.addFlashAttribute("message", new Message(1,"VIP类型修改成功"));
                break;
            case "price":
                //保存翻译价格
                List<VipPrice> vipPriceList = new ArrayList<>();
                String[] prices = request.getParameter("price").split(",");
                for (String item : prices) {
                    String[] price = item.split("&");
                    vipPriceList.add(vipPriceRepository.save(
                            new VipPrice(
                                    price[1],
                                    Integer.valueOf(price[2]),
                                    price[3],
                                    languageGroupRepository.findOne(Integer.valueOf(price[0]))
                            )
                    ));
                }
                vip.setVipPrices(vipPriceList);
                redirect.addFlashAttribute("message", new Message(1, "翻译价格修改成功"));
                break;
            case "endTime":
                if (request.getParameter("endTime").length() == 0) {
                    redirect.addFlashAttribute("message", new Message(0, "未填写合同到期时间"));
                } else {
                    vip.setEndTime(helper.parseDate(request.getParameter("endTime")));
                    redirect.addFlashAttribute("message", new Message(1,"合同到期时间修改成功"));
                }
                break;
            case "path":
                vip.setPath(request.getParameter("path").length()>0?request.getParameter("path"):null);
                redirect.addFlashAttribute("message", new Message(1,"附件修改成功"));
                break;
            default:
                break;
        }
        vipRepository.save(vip);
        return "redirect:/admin/profile/vip?view=" + username;
    }

    //修改vip翻译价格
    @GetMapping("/admin/vip/update/vipPrice")
    public String updateVipPrice(@RequestParam("username") String username, Model model) {
        model.addAttribute("username", username);
        model.addAttribute("languageGroups", languageGroupRepository.findAll());
        return "admin/updateTranslatePrice";
    }



}
