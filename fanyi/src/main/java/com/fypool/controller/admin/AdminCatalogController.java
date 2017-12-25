package com.fypool.controller.admin;


import com.fypool.model.Article;
import com.fypool.model.Catalog;
import com.fypool.model.Message;
import com.fypool.repository.ArticleContentRepository;
import com.fypool.repository.ArticleRepository;
import com.fypool.repository.CatalogRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpSession;
import java.util.List;

@Controller
public class AdminCatalogController {

    @Autowired
    CatalogRepository catalogRepository;

    @Autowired
    ArticleRepository articleRepository;

    @Autowired
    ArticleContentRepository articleContentRepository;

    @GetMapping("/admin/catalog")
    public String catalog(Model model, HttpSession session) {
        //目录限制在10个之内，目录不分页
        List<Catalog> catalogs = catalogRepository.findAll();
        model.addAttribute("catalogs", catalogs);
        session.setAttribute("menu","manager");
        return "admin/catalog";
    }

    @PostMapping("/admin/catalog/update")
    public String updateCatalog(
            @RequestParam("catalog") String catalog,
            @RequestParam("ecatalog") String ecatalog,
            @RequestParam("id") Integer id,
            RedirectAttributes redirect
    ) {
        if (id == null) {
            //添加新目录
            catalogRepository.save(new Catalog(catalog, ecatalog));
            redirect.addFlashAttribute("message", new Message(1, "添加新目录成功"));
        } else {
            //修改老目录
            Catalog getCatalog = catalogRepository.findOne(id);
            getCatalog.setCatalog(catalog);
            getCatalog.setEcatalog(ecatalog);
            catalogRepository.save(getCatalog);
            redirect.addFlashAttribute("message", new Message(1, "修改目录成功"));
        }
        return "redirect:/admin/catalog";
    }

    @GetMapping("/admin/catalog/top")
    public @ResponseBody void updateCatalogTop(
            @RequestParam("id") Integer id
    ) {
        Catalog catalog = catalogRepository.findOne(id);
        if(catalog.getTop()==0){
            catalog.setTop(1);
        }else{
            catalog.setTop(0);
        }
        catalogRepository.save(catalog);
    }

    @GetMapping("/admin/catalog/off")
    public @ResponseBody void updateCatalogOff(
            @RequestParam("id") Integer id
    ) {
        Catalog catalog = catalogRepository.findOne(id);
        if(catalog.getOff()==0){
            catalog.setOff(1);
        }else{
            catalog.setOff(0);
        }
        catalogRepository.save(catalog);
    }

    //删除目录
    @GetMapping("/admin/catalog/delete")
    public String catalogDelete(
            @RequestParam("id") Integer id,
            RedirectAttributes redirect
    ) {
        Catalog catalog = catalogRepository.findOne(id);
        //删除所有文章，并级联删除所有文章内容
        articleRepository.deleteAllByCatalog(catalog);
        catalogRepository.delete(catalog);
        redirect.addFlashAttribute("message", new Message(1, "删除目录成功"));
        return "redirect:/admin/catalog";
    }


}
