package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedBy;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id","catalog"})
@EntityListeners(AuditingEntityListener.class)
public class Article implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //资质证书和其他资质证书表
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    private String title;

    //所属目录
    @ManyToOne(fetch = FetchType.LAZY)
    private Catalog catalog;

    //文章内容 1对1,级联删除！！！
    @OneToOne(cascade = {CascadeType.REMOVE}, fetch = FetchType.LAZY)
    private ArticleContent articleContent;

    //置顶 0 不置顶 1置顶
    @Column(columnDefinition = "tinyint")
    private Integer top;

    //0 开启 1 关闭
    @Column(columnDefinition = "tinyint")
    private Integer off;

    //浏览量pv
    private Integer view;

    //编辑的管理员的账号
    @LastModifiedBy
    private String modifiedBy;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    @PrePersist
    void preInsert() {
        if (this.off == null) this.off = 0;
        if (this.top == null) this.top = 0;
        if (this.view == null) this.view = 0;
    }

    public Article(String title, Catalog catalog, ArticleContent articleContent) {
        super();
        this.title = title;
        this.catalog = catalog;
        this.articleContent = articleContent;
    }
}
