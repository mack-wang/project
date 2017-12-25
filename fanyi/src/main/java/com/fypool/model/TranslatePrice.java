package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;

import javax.persistence.*;
import java.io.Serializable;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id","user"})
public class TranslatePrice implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //资质证书和其他资质证书表
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;


    //翻译类型 translate 笔译 interpret 口译
    private String translateType;

    //价格，整数
    private Integer price;

    //价格单位或类型：word 元/千字 page 元/页 hour 元/小时 day 元/天
    private String priceType;

    //翻译语言
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "language_group_id")
    private LanguageGroup languageGroup;


    //所属用户的id
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    public TranslatePrice(String translateType, Integer price, String priceType, LanguageGroup languageGroup, User user) {
        super();
        this.translateType = translateType;
        this.price = price;
        this.priceType = priceType;
        this.languageGroup = languageGroup;
        this.user = user;
    }
}
