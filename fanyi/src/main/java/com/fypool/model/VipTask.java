package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.hibernate.annotations.ColumnDefault;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedBy;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.math.BigDecimal;
import java.util.Date;
import java.util.List;

@Entity
@Data
@NoArgsConstructor
@EntityListeners(AuditingEntityListener.class)
@EqualsAndHashCode(exclude = {"id", "user"})
public class VipTask implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    //翻译类型，0 笔译 1口译
    @Column(columnDefinition = "tinyint")
    private Integer type;

    //任务标题
    @Column(length = 64)
    private String title;

    //翻译语言
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "language_group_id")
    private LanguageGroup languageGroup;


    //翻译稿件要完成的日期
    @Column(columnDefinition = "datetime")
    private Date endTime;

    //口译开始时间
    @Column(columnDefinition = "datetime")
    private Date startDate;

    //用户确认完成日期
    @Column(columnDefinition = "datetime")
    private Date doneTime;

    //口译结束时间
    @Column(columnDefinition = "datetime")
    private Date endDate;

    //vip客户
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //创建该任务的管理员，负责提交稿件
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "admin_id")
    private User admin;

    //开关 0 开始 1 关闭 2 已经完成但未出账单 3 已出账单但未付款 4 已付款 5 待发送月结账单
    @Column(columnDefinition = "tinyint")
    private Integer off;

    //任务单价
    @Column(columnDefinition = "decimal(9,2)")
    private BigDecimal unitPrice;

    //任务价格
    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal price;

    //翻译字数
    private Integer word;

    //翻译小时数
    private Integer hour;

    //翻译内容，任务附件下载地址
    private String vipAttachment;

    //完成的稿件，下载地址
    private String vipTask;

    //稿件版本,默认为第0稿，每上传一次则更新1稿
    @Column(columnDefinition = "tinyint")
    private Integer version;

    @ManyToOne(fetch = FetchType.LAZY)
    private Bill bill;

    //关联发票申请
    @OneToOne(fetch = FetchType.LAZY)
    private InvoiceRequest invoiceRequest;

    //关联的签章申请
    @OneToOne(fetch = FetchType.LAZY)
    private SignatureRequest signatureRequest;

    //编辑的管理员的账号
    @LastModifiedBy
    private String modifiedBy;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public VipTask(Integer type, String title, LanguageGroup languageGroup, Date endTime, Date startDate, Date endDate, User user, User admin, BigDecimal unitPrice, BigDecimal price, Integer word, Integer hour, String vipAttachment) {
        super();
        this.type = type;
        this.title = title;
        this.languageGroup = languageGroup;
        this.endTime = endTime;
        this.startDate = startDate;
        this.endDate = endDate;
        this.user = user;
        this.admin = admin;
        this.unitPrice = unitPrice;
        this.price = price;
        this.word = word;
        this.hour = hour;
        this.vipAttachment = vipAttachment;
    }

    @PrePersist
    void preInsert() {
        if (this.version == null) this.version = 0;
        if (this.off == null) this.off = 0;
    }

}
