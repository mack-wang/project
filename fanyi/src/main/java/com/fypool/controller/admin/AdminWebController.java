package com.fypool.controller.admin;

import com.fypool.component.HelperController;
import com.fypool.model.Message;
import com.fypool.model.Web;
import com.fypool.repository.WebRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpSession;

@Controller
public class AdminWebController {

    @Autowired
    WebRepository webRepository;

    @Autowired
    HelperController helper;

    @GetMapping("/admin/web")
    public String web(Model model, HttpSession session) {
        model.addAttribute("web", webRepository.findOne(1));
        session.setAttribute("menu","manager");
        return "admin/web";
    }

    //上传轮播图片
    @PostMapping("/admin/web/ad/update")
    public String uploadAd(
            @RequestParam("path") String path,
            @RequestParam("link") String link,
            RedirectAttributes redirect
    ) {
        Web web = webRepository.findOne(1);
        web.setMarketPicture(path);
        if(link.length()>0){
            web.setLink(link);
        }else{
            web.setLink(null);
        }
        webRepository.save(web);
        redirect.addFlashAttribute("message",new Message(1,"广告图上传成功"));
        return "redirect:/admin/web";
    }

    @GetMapping("/admin/web/wechat")
    public String webWechat(Model model, HttpSession session) {
        model.addAttribute("web", webRepository.findOne(1));
        session.setAttribute("menu","manager");
        return "admin/webWechat";
    }

    //上传微信广告图
    @PostMapping("/admin/web/wechat/update")
    public String uploadWechatAd(
            @RequestParam("path") String path,
            RedirectAttributes redirect
    ) {
        Web web = webRepository.findOne(1);
        web.setWechatPicture(path);
        webRepository.save(web);
        redirect.addFlashAttribute("message",new Message(1,"微信广告图上传成功"));
        return "redirect:/admin/web/wechat";
    }

}
