package com.fypool.controller.web;

import com.fypool.model.*;
import com.fypool.repository.*;
import org.hashids.Hashids;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.SessionAttributes;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.security.Principal;
import java.util.List;
import java.util.Map;

@Controller
@SessionAttributes("user")
public class HomeController {
    @Autowired
    UserRepository userRepository;

    @Autowired
    UserInfoRepository userInfoRepository;


    @Autowired
    AttributeRepository attributeRepository;

    @Autowired
    private RedisTemplate redisTemplate;

    @Autowired
    AddressRepository addressRepository;

    @Autowired
    MhCityRepository mhCityRepository;

    @Autowired
    InvoiceRepository invoiceRepository;

    @Value("${customer.hashid.salt}")
    private String salt;

    @GetMapping("/home")
    public String home(Model model, Principal principal, HttpSession session) {
        User user = userRepository.findByUsername(principal.getName());
        Hashids hashids = new Hashids(salt, 6);

        model.addAttribute("userInfo", userInfoRepository.findByUser(user));
        model.addAttribute("attribute", user.getAttribute());
        model.addAttribute("address", addressRepository.findByUser(user));
        model.addAttribute("invoice", invoiceRepository.countAllByUserAndDeleted(user,0));
        model.addAttribute("hashid", hashids.encode(user.getId()));
        model.addAttribute("user", user);
        session.setAttribute("menu", "home");
        return "web/userHome";
    }


    @GetMapping("/auth/check/{path}")
    public String authCheckView(@PathVariable("path") String path, Model model) {
        model.addAttribute("path", new Message(path));
        return "web/authCheck";
    }


    //用户刷新修改手机号的页面
    @GetMapping("/auth/checked/phone")
    public String refreshPhoneView(
            Principal principal
    ) {
        //查看是否授权过期
        if (!this.redisTemplate.hasKey("ephone:" + principal.getName())) {
            return "redirect:/auth/check/phone";
        }
        return "web/update/phone";
    }

    //用户刷新修改邮箱的页面
    @GetMapping("/auth/checked/email")
    public String refreshEmailView(
            Principal principal
    ) {
        //查看是否授权过期
        if (!this.redisTemplate.hasKey("eemail:" + principal.getName())) {
            return "redirect:/auth/check/email";
        }
        return "web/update/email";
    }

    //用户刷新修改密码的页面
    @GetMapping("/auth/checked/password")
    public String refreshPasswordView(
            Principal principal
    ) {
        //查看是否授权过期
        if (!this.redisTemplate.hasKey("epassword:" + principal.getName())) {
            return "redirect:/auth/check/password";
        }
        return "web/update/password";
    }

    //用户刷新修改支付密码的页面
    @GetMapping("/auth/checked/pay")
    public String refreshPayView(
            Principal principal,
            Model model
    ) {
        //查看是否授权过期
        if (!this.redisTemplate.hasKey("epay:" + principal.getName())) {
            return "redirect:/auth/check/pay";
        }

        User user = userRepository.findByUsername(principal.getName());
        Account account = user.getAccount();
        model.addAttribute("account", account);

        return "web/update/pay";
    }

    //用户修改城市界面
    @GetMapping("/update/city")
    public String updateCityView(
    ) {
        return "web/update/city";
    }


    //用户邮寄地址
    @GetMapping("/update/address")
    public String updateAddress(
    ) {
        return "web/update/address";
    }

    //修改邮寄地址
    @PostMapping("/update/user/address")
    public String updateAddressPost(
            HttpSession session,
            HttpServletRequest request,
            RedirectAttributes redirect
    ) {
        Map<String, String[]> map = request.getParameterMap();
        User user = (User) session.getAttribute("user");
        Address address = addressRepository.findByUser(user);
        String[] areaIds = map.get("provinceCityAreaId")[0].split(",");
        if (address == null) {
            address = new Address();
        }
        address.setName(map.get("name")[0]);
        address.setProvince(mhCityRepository.findOne(Integer.valueOf(areaIds[0])));
        address.setCity(mhCityRepository.findOne(Integer.valueOf(areaIds[1])));
        address.setArea(mhCityRepository.findOne(Integer.valueOf(areaIds[2])));
        address.setAddress(map.get("address")[0]);
        address.setUser(user);
        address.setPhone(map.get("phone")[0]);
        addressRepository.save(address);
        redirect.addFlashAttribute("profileMessage", new Message(1, "邮寄信息修改成功"));
        return "redirect:/home";
    }

    //修改开票资料
    @GetMapping("/update/invoice")
    public String updateInvoiceView(
            Model model,
            HttpSession session
    ) {
        User user = (User) session.getAttribute("user");
        model.addAttribute("invoices",invoiceRepository.findByUserAndDeleted(user,0));
        return "web/update/invoice";
    }

    @PostMapping("/update/invoice")
    public String updateInvoice(
            HttpSession session,
            HttpServletRequest request,
            RedirectAttributes redirect
    ) {
        Map<String, String[]> map = request.getParameterMap();
        User user = (User) session.getAttribute("user");
        //当前正在使用中的开票资料
        List<Invoice> invoices = invoiceRepository.findByUserAndDeleted(user, 0);

        //如果开票资料已经填了5条，则不能再填
        if (invoices.size() > 4) {
            redirect.addFlashAttribute("message", new Message(0, "开票资料最多填写5条，请删除后再填写"));
            return "redirect:/update/invoice";
        } else {
            switch (map.get("type")[0]) {
                case "0":
                    //增值税专用发票
                    invoiceRepository.save(new Invoice(
                            Integer.valueOf(map.get("type")[0]),
                            map.get("title")[0],
                            map.get("tax")[0],
                            map.get("address")[0],
                            map.get("phone")[0],
                            map.get("bank")[0],
                            map.get("account")[0],
                            user
                    ));
                    break;
                case "1":
                    //增值税普通发票
                    invoiceRepository.save(new Invoice(
                            Integer.valueOf(map.get("type")[0]),
                            map.get("title")[0],
                            map.get("tax")[0],
                            user
                    ));
                    break;
                case "2":
                    //个人发票
                    invoiceRepository.save(new Invoice(
                            Integer.valueOf(map.get("type")[0]),
                            map.get("title")[0],
                            user
                    ));
                    break;
                default:
                    break;
            }
        }

        redirect.addFlashAttribute("message", new Message(1, "开票资料添加成功"));
        return "redirect:/update/invoice";
    }

    //软删除开票资料
    @GetMapping("/delete/invoice/{id}")
    public String deleteInvoice(
            RedirectAttributes redirect,
            HttpSession session,
            @PathVariable("id") Integer id
    ) {
        User user = (User) session.getAttribute("user");
        Invoice invoice = invoiceRepository.findByUserAndDeletedAndId(user,0,id);
        if(invoice==null){
            redirect.addFlashAttribute("message", new Message(0, "非法操作"));
        }else{
            invoice.setDeleted(1);
            invoiceRepository.save(invoice);
            redirect.addFlashAttribute("message", new Message(1, "删除成功"));
        }
        return "redirect:/update/invoice";
    }


}
