package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;

import javax.persistence.*;
import java.io.Serializable;
import java.math.BigDecimal;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id","user"})
public class Price implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //资质证书和其他资质证书表
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //笔译价格
    //价格,浮点数，三位小数点，单位：毫/字    元.角.厘.毫
    //计算用毫，整数计算，最终结果和确认金额用厘，浮点计算1
    @Column(columnDefinition = "decimal(5,3)")
    private BigDecimal price;

    //翻译质量
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "quality_id")
    private Quality quality;

    //翻译语言
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "language_group_id")
    private LanguageGroup languageGroup;


}
