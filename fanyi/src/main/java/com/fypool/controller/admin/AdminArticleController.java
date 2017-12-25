package com.fypool.controller.admin;


import com.fypool.component.HelperController;
import com.fypool.model.*;
import com.fypool.repository.ArticleContentRepository;
import com.fypool.repository.ArticleRepository;
import com.fypool.repository.CatalogRepository;
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
import org.springframework.web.multipart.MultipartFile;
import org.springframework.web.multipart.MultipartHttpServletRequest;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpSession;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

@Controller
public class AdminArticleController {

    @Autowired
    HelperController helper;

    @Autowired
    CatalogRepository catalogRepository;

    @Autowired
    ArticleRepository articleRepository;

    @Autowired
    ArticleContentRepository articleContentRepository;

    @GetMapping("/admin/article")
    public String article(Model model, HttpSession session) {
        model.addAttribute("catalogs", catalogRepository.findAll());
        session.setAttribute("menu","manager");
        return "admin/article";
    }

    //上传文章内容中的图片
    @PostMapping("/admin/upload")
    public @ResponseBody
    FileJson upload(HttpServletRequest request) {

        //获取以图片名为key的map
        MultipartHttpServletRequest multipartRequest = (MultipartHttpServletRequest) request;
        Map<String, MultipartFile> fileMap = multipartRequest.getFileMap();

        List<String> data = new ArrayList<>();
        for (MultipartFile file : fileMap.values()) {
            data.add(helper.uploadFile(file, "article"));
        }

        FileJson fileJson = new FileJson(0, data);
        return fileJson;
    }

    //获取文章分页
    @GetMapping("/admin/article/list")
    public String articleList(
            @RequestParam(value = "catalogId", required = false) Integer catalogId,
            @RequestParam(value = "title", required = false) String title,
            @RequestParam(value = "page", required = false) Integer page,
            Model model,
            HttpSession session
    ) {
        Integer getPage = page == null ? 0 : page;
        Pageable pageable = new PageRequest(getPage, 10);
        Catalog catalog = null;
        if (catalogId != null) {
            catalog = catalogRepository.findOne(catalogId);
        }

        Page<Article> articles = articleRepository.findAll(ArticleSpec.getSpec(catalog, title,null,null), pageable);

        //文章可以根据两个参数来搜索，目录和标题
        model.addAttribute("articles", articles);
        model.addAttribute("catalogs", catalogRepository.findAll());
        session.setAttribute("menu","manager");
        return "admin/articleList";
    }

    //添加新文章
    @PostMapping("/admin/article/add")
    public String articleAdd(
            @RequestParam("article") String article,
            @RequestParam("title") String title,
            @RequestParam("catalogId") Integer catalogId,
            RedirectAttributes redirect
    ) {
        Catalog catalog = catalogRepository.findOne(catalogId);
        ArticleContent content = articleContentRepository.save(new ArticleContent(article));
        articleRepository.save(new Article(title, catalog, content));
        redirect.addFlashAttribute("message", new Message(1, "添加新文章成功！"));
        return "redirect:/admin/article";
    }


    //文章置顶修改
    @GetMapping("/admin/article/top")
    public @ResponseBody
    void updateCatalogTop(
            @RequestParam("id") Integer id
    ) {
        Article article = articleRepository.findOne(id);
        if (article.getTop() == 0) {
            article.setTop(1);
        } else {
            article.setTop(0);
        }
        articleRepository.save(article);
    }

    //文章关闭修改
    @GetMapping("/admin/article/off")
    public @ResponseBody
    void updateArticleOff(
            @RequestParam("id") Integer id
    ) {
        Article article = articleRepository.findOne(id);
        if (article.getOff() == 0) {
            article.setOff(1);
        } else {
            article.setOff(0);
        }
        articleRepository.save(article);
    }

    //删除文章
    @GetMapping("/admin/article/delete")
    public String articleDelete(
            @RequestParam("id") Integer id,
            RedirectAttributes redirect
    ) {
        articleRepository.delete(id);
        redirect.addFlashAttribute("message", new Message(1, "删除文章成功"));
        return "redirect:/admin/article/list";
    }


    @GetMapping("/admin/article/update")
    public String articleUpdateView(Model model, @RequestParam("id") Integer id) {
        model.addAttribute("catalogs", catalogRepository.findAll());
        model.addAttribute("article", articleRepository.findOne(id));
        return "admin/updateArticle";
    }

    //修改文章
    @PostMapping("/admin/article/update")
    public String articleUpdate(
            @RequestParam("article") String article,
            @RequestParam("title") String title,
            @RequestParam("catalogId") Integer catalogId,
            @RequestParam("id") Integer id,
            RedirectAttributes redirect
    ) {
        Catalog catalog = catalogRepository.findOne(catalogId);
        Article getArticle = articleRepository.findOne(id);
        getArticle.setTitle(title);
        getArticle.setCatalog(catalog);
        getArticle.getArticleContent().setContent(article);

        articleRepository.save(getArticle);
        redirect.addFlashAttribute("message", new Message(1, "文章修改成功！"));
        return "redirect:/admin/article/update?id=" + id;
    }


}
