package com.fypool.controller.web;

import com.fypool.model.*;
import com.fypool.repository.ArticleRepository;
import com.fypool.repository.CatalogRepository;
import com.fypool.repository.CustomerServiceRepository;
import com.fypool.repository.SlideImageRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

import javax.persistence.EntityManager;
import java.util.List;

@Controller
public class IndexController {

    @Autowired
    CatalogRepository catalogRepository;

    @Autowired
    ArticleRepository articleRepository;

    @Autowired
    SlideImageRepository slideImageRepository;

    @Autowired
    CustomerServiceRepository customerServiceRepository;

    @Autowired
    EntityManager entityManager;

    @GetMapping({"/","/index"})
    public String index(Model model){
        model.addAttribute("slides",slideImageRepository.findAll());
        return "web/index";
    }

    @GetMapping("/catalog")
    public String catalog(
            @RequestParam(value = "id",required =  false) Integer id,
            @RequestParam(value = "page", required = false) Integer page,
            Model model
    ){
        List<Catalog> catalogs = catalogRepository.findAllByOffEqualsOrderByTopDesc(0);
        Integer getPage = page == null ? 0 : page;
        Pageable pageable = new PageRequest(getPage, 10);
        Catalog catalog = null;
        if (id != null) {
            //如果用户选择了目录，则按用户的选择
            catalog = catalogRepository.findOne(id);
        }else{
            //如果用户没有选择目录，则取第一条目录
            catalog=catalogs.get(0);
        }

        Page<Article> articles = articleRepository.findAll(ArticleSpec.getSpec(catalog, null,0,1), pageable);

        //文章可以根据两个参数来搜索，目录和标题
        model.addAttribute("articles", articles);
        model.addAttribute("catalogs", catalogs);
        model.addAttribute("nowCatalog", catalog);
        return "web/catalog";
    }

    //显示文章
    @GetMapping("/article")
    public String article(
            @RequestParam("id") Integer id,
            Model model
    ){
        List<Catalog> catalogs = catalogRepository.findAllByOffEqualsOrderByTopDesc(0);
        Article article = articleRepository.findOne(id);
        article.setView(article.getView()+1);
        articleRepository.save(article);
        model.addAttribute("article", article);
        model.addAttribute("catalogs", catalogs);
        return "web/article";
    }

    //搜索文章
    @GetMapping("/article/search")
    public @ResponseBody List<Article> articleSearch(
            @RequestParam("title") String title
    ){
        return articleRepository.findTop10ByTitleLike("%"+title+"%");
    }

    @GetMapping("/customer/service")
    public @ResponseBody Object getCustomerService(
    ){
        //查找所有在线的客服
        Object services = entityManager.createQuery("select c.user.username, c.user.attribute.nickname from CustomerService c  where c.online = 1").getResultList();
        return services;
    }

}
