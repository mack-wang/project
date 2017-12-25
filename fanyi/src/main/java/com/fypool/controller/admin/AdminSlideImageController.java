package com.fypool.controller.admin;


import com.fypool.component.HelperController;
import com.fypool.model.Message;
import com.fypool.model.SlideImage;
import com.fypool.repository.SlideImageRepository;
import org.apache.poi.hslf.record.Slide;
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
public class AdminSlideImageController {

    @Autowired
    SlideImageRepository slideImageRepository;

    @Autowired
    HelperController helper;

    @GetMapping("/admin/slideImage")
    public String slideImage(Model model, HttpSession session) {
        model.addAttribute("slides", slideImageRepository.findAll());
        session.setAttribute("menu","manager");
        return "admin/slideImage";
    }

    //上传轮播图片
    @PostMapping("/admin/upload/slideImage")
    public @ResponseBody
    String uploadTask(
            @RequestParam("uploadSlideImage") MultipartFile file
    ) {
        return helper.uploadFile(file, "slideImage");
    }

    //提交轮播图表单
    @PostMapping("/admin/slideImage/update")
    public String uploadTask(
            @RequestParam("path") String path,
            @RequestParam("link") String link,
            @RequestParam(value = "id", required = false) Integer id,
            RedirectAttributes redirect
    ) {
        SlideImage slideImage = new SlideImage();
        if (id != null) {
            slideImage = slideImageRepository.findOne(id);
        }
        slideImage.setPath(path);
        slideImage.setLink(link);
        slideImageRepository.save(slideImage);
        redirect.addFlashAttribute("message", new Message(1, id == null ? "提交成功" : "修改成功"));
        return "redirect:/admin/slideImage";
    }

    //关闭和开启轮播图
    @GetMapping("/admin/slideImage/toggle")
    public String slideImageToggle(@RequestParam("id") Integer id,RedirectAttributes redirect) {
        SlideImage slideImage = slideImageRepository.findOne(id);
        if(slideImage.getOff()==0){
            slideImage.setOff(1);
        }else{
            slideImage.setOff(0);
        }
        slideImageRepository.save(slideImage);
        redirect.addFlashAttribute("message", new Message(1, slideImage.getOff()==0 ? "开启成功" : "关闭成功"));
        return "redirect:/admin/slideImage";
    }

    @GetMapping("/admin/slideImage/delete")
    public String slideImageDelete(@RequestParam("id") Integer id,RedirectAttributes redirect) {
        slideImageRepository.delete(id);
        redirect.addFlashAttribute("message", new Message(1, "删除成功"));
        return "redirect:/admin/slideImage";
    }


}
