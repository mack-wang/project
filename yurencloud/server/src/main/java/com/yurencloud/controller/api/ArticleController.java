package com.yurencloud.controller.api;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.github.pagehelper.PageHelper;
import com.github.pagehelper.PageInfo;
import com.yurencloud.mapper.ArticleMapper;
import com.yurencloud.mapper.CatalogMapper;
import com.yurencloud.model.*;
import com.yurencloud.util.UploadUtil;
import io.swagger.annotations.ApiImplicitParam;
import io.swagger.annotations.ApiImplicitParams;
import io.swagger.annotations.ApiOperation;
import lombok.Data;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import javax.servlet.http.HttpServletRequest;
import java.util.*;

@RestController
public class ArticleController {

    @Autowired
    private UploadUtil uploadUtil;

    @Autowired
    private ArticleMapper articleMapper;

    @Autowired
    private CatalogMapper catalogMapper;

    @Data
    class ArticleImage {
        private Map<String,String> data;
    }

    @ApiOperation(value = "上传文章内容图片和标题图片", notes = "上传图片文件")
    @ApiImplicitParam(name = "image", value = "图片", required = true, dataType = "MultipartFile", paramType = "body")
    @PostMapping("/upload/article/image")
    public ArticleImage uploadImage(@RequestParam("image") MultipartFile image) throws JsonProcessingException {
        ArticleImage articleImage = new ArticleImage();
        Map<String,String> link = new HashMap<>();
        link.put("link",uploadUtil.uploadFile(image, "article/image"));
        articleImage.setData(link);
        return articleImage;
    }

    @ApiOperation(value = "创建新文章", notes = "创建新文章")
    @ApiImplicitParams(value = {
            @ApiImplicitParam(name = "title", value = "标题", required = true, dataType = "String", paramType = "body"),
            @ApiImplicitParam(name = "catalogId", value = "目录id", required = true, dataType = "Integer", paramType = "body"),
            @ApiImplicitParam(name = "content", value = "内容", required = true, dataType = "String", paramType = "body"),
            @ApiImplicitParam(name = "image", value = "标题图url", dataType = "String", paramType = "body")
    })
    @PostMapping("/article")
    public Message createArticle(@RequestBody Article article){
        // 在没找到设置默认值的方法前手动设置默认值
        article.setGood(0);
        article.setRecommend(new Byte("0"));
        article.setTop(new Byte("0"));
        article.setView(0);
        article.setCreatedAt(new Date());
        article.setUpdatedAt(new Date());
        articleMapper.insert(article);
        return new Message(true,"文章创建成功！");
    }

    @ApiOperation(value = "获取文章分页", notes = "获取文章分页")
    @ApiImplicitParams(value = {
            @ApiImplicitParam(name = "page", value = "当前页数",required = true, dataType = "Integer", paramType = "query"),
            @ApiImplicitParam(name = "pageSize", value = "每页条数",required = true, dataType = "Integer", paramType = "query"),
            @ApiImplicitParam(name = "catalogId", value = "目录id", dataType = "Integer", paramType = "query"),
            @ApiImplicitParam(name = "createdAt", value = "创建时间排序", dataType = "String", paramType = "query"),
            @ApiImplicitParam(name = "good", value = "点赞数量排序", dataType = "String", paramType = "query"),
            @ApiImplicitParam(name = "view", value = "点击数量排序", dataType = "String", paramType = "query"),
            @ApiImplicitParam(name = "title", value = "文章标题", dataType = "String", paramType = "query")
    })
    @GetMapping("/articles")
    public Message getAllArticles(HttpServletRequest request){
        Map<String,String[]> params = request.getParameterMap();
        PageHelper.startPage(Integer.valueOf(params.get("page")[0]), Integer.valueOf(params.get("pageSize")[0]));
        ArticleExample example = new ArticleExample();
        ArticleExample.Criteria criteria = example.createCriteria();

        if(params.containsKey("catalogId")){
            criteria.andCatalogIdEqualTo(Integer.valueOf(params.get("catalogId")[0]));
        }

        if(params.containsKey("title")){
            criteria.andTitleLike("%"+params.get("title")[0]+"%");
        }

        if(params.containsKey("createdAt")){
            example.setOrderByClause("created_at "+params.get("createdAt")[0]);
        }else{
            example.setOrderByClause("created_at desc");
        }

        if(params.containsKey("good")){
            example.setOrderByClause("good "+params.get("good")[0]);
        }

        if(params.containsKey("view")){
            example.setOrderByClause("view "+params.get("view")[0]);
        }


        List<Article> list = articleMapper.selectByExample(example);
        PageInfo pageInfo = new PageInfo(list);
        return new Message(true,pageInfo);
    }

    @ApiOperation(value = "获取公开文章分页", notes = "获取公开文章分页")
    @ApiImplicitParams(value = {
            @ApiImplicitParam(name = "page", value = "当前页数",required = true, dataType = "Integer", paramType = "query"),
            @ApiImplicitParam(name = "pageSize", value = "每页条数",required = true, dataType = "Integer", paramType = "query"),
            @ApiImplicitParam(name = "catalogId", value = "目录id", dataType = "Integer", paramType = "query"),
            @ApiImplicitParam(name = "menu", value = "菜单目录id", dataType = "Integer", paramType = "query"),
            @ApiImplicitParam(name = "title", value = "文章标题", dataType = "String", paramType = "query"),
    })
    @GetMapping("/public/articles")
    public Message getPublicArticles(HttpServletRequest request){
        Map<String,String[]> params = request.getParameterMap();
        PageHelper.startPage(Integer.valueOf(params.get("page")[0]), Integer.valueOf(params.get("pageSize")[0]));
        ArticleExample example = new ArticleExample();
        ArticleExample.Criteria criteria = example.createCriteria();

        if(params.containsKey("menu")){
            CatalogExample catalogExample = new CatalogExample();
            catalogExample.or().andGidEqualTo(Integer.valueOf(params.get("menu")[0]));
            List<Catalog> list = catalogMapper.selectByExample(catalogExample);
            List<Integer> ids = new ArrayList<>();
            for(Catalog item : list){
                ids.add(item.getId());
            }
            criteria.andCatalogIdIn(ids);
        }

        if(params.containsKey("catalogId")){
            criteria.andCatalogIdEqualTo(Integer.valueOf(params.get("catalogId")[0]));
        }

        if(params.containsKey("title")){
            criteria.andTitleLike("%"+params.get("title")[0]+"%");
        }

        example.setOrderByClause("top desc");
        example.setOrderByClause("created_at desc");

        List<Article> list = articleMapper.selectByExample(example);
        PageInfo pageInfo = new PageInfo(list);
        return new Message(true,pageInfo);
    }

    @ApiOperation(value = "获取指定文章", notes = "根据文章id获取指定文章")
    @ApiImplicitParam(name = "id", value = "文章id",required = true, dataType = "Integer", paramType = "path")
    @GetMapping("/article/{id}")
    public Message getOneArticle(@PathVariable("id") Integer id){
        return new Message(true,articleMapper.selectByPrimaryKey(id));
    }

    @ApiOperation(value = "修改文章内容", notes = "修改文章内容")
    @ApiImplicitParams(value = {
            @ApiImplicitParam(name = "id", value = "文章id", required = true, dataType = "Integer", paramType = "body"),
            @ApiImplicitParam(name = "title", value = "标题", required = true, dataType = "String", paramType = "body"),
            @ApiImplicitParam(name = "catalogId", value = "目录id", required = true, dataType = "Integer", paramType = "body"),
            @ApiImplicitParam(name = "content", value = "内容", required = true, dataType = "String", paramType = "body"),
            @ApiImplicitParam(name = "image", value = "标题图url", dataType = "String", paramType = "body")
    })
    @PatchMapping("/article")
    public Message modifyArticle(@RequestBody Article article){
        // 在没找到设置默认值的方法前手动设置默认值
        Integer count = articleMapper.updateByPrimaryKeySelective(article);
        Boolean result = (count == 1);
        return new Message(result,result?"文章修改成功！":"文章修改失败！");
    }

    @ApiOperation(value = "删除指定文章", notes = "删除指定文章")
    @ApiImplicitParam(name = "id", value = "文章id",required = true, dataType = "Integer", paramType = "path")
    @DeleteMapping("/article/{id}")
    public Message deleteArticle(@PathVariable("id") Integer id){
        articleMapper.deleteByPrimaryKey(id);
        return new Message(true,"文章删除成功!");
    }

    @ApiOperation(value = "推荐指定文章", notes = "推荐指定文章")
    @ApiImplicitParam(name = "id", value = "文章id",required = true, dataType = "Integer", paramType = "path")
    @PatchMapping("/article/recommend/{id}")
    public Message recommendArticle(@PathVariable("id") Integer id){
        Article article = articleMapper.selectByPrimaryKey(id);
        article.setRecommend(article.getRecommend()==0?new Byte("1"):new Byte("0"));
        articleMapper.updateByPrimaryKey(article);
        return new Message(true,article.getRecommend()==0?"文章取消推荐成功!":"文章推荐成功");
    }

    @ApiOperation(value = "置顶指定文章", notes = "置顶指定文章")
    @ApiImplicitParam(name = "id", value = "文章id",required = true, dataType = "Integer", paramType = "path")
    @PatchMapping("/article/top/{id}")
    public Message topArticle(@PathVariable("id") Integer id){
        Article article = articleMapper.selectByPrimaryKey(id);
        article.setTop(article.getTop()==0?new Byte("1"):new Byte("0"));
        articleMapper.updateByPrimaryKey(article);
        return new Message(true,article.getTop()==0?"文章取消置顶成功!":"文章置顶成功");
    }


}

