package com.fypool.model;


import lombok.Builder;
import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.hibernate.annotations.ColumnDefault;
import org.springframework.data.annotation.CreatedDate;
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
@EqualsAndHashCode(exclude={"id","user","process"})
public class Task implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    //翻译类型，0 笔译 1口译
    @Column(columnDefinition = "tinyint")
    private Integer type;

    //任务标题
    private String title;

    //翻译语言
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "language_group_id")
    private LanguageGroup languageGroup;

    //翻译内容
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "content_id")
    private TaskContent taskContent;

    //翻译的要求，可以是长文本，跟内容一起放到TaskContent中
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "request_id")
    private TaskContent taskRequest;

    //翻译领域，只能选一种
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "field_id")
    private SkilledField field;


    //翻译用途，只能选一种
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "usage_id")
    private SkilledUsage usage;

    //口译详情
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "interpret_id")
    private TaskInterpret interpret;

    //翻译质量，只能选一种,0 标准 1 专业
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "quality_id")
    private Quality quality;

    //是否加急 0不加急 1加急
    private Integer emergency;

    //任务截止日期
    @Column(columnDefinition = "datetime")
    private Date taskEndTime;

    //翻译稿件要完成的日期
    @Column(columnDefinition = "datetime")
    private Date translateEndTime;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //内容简介
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "brief_id")
    private TaskContent brief;

    //开关 0 开始 1关闭 2正在翻译 3翻译完成 4举报关闭
    @Column(columnDefinition = "tinyint")
    private Integer off;

    //置顶 0 不置顶 1 置顶 置顶的先后按更新时间
    @Column(columnDefinition = "tinyint")
    private Integer top;

    //置顶有效期,购买1天则加1天，购买3天则加3天，在当前时间上加，如果已经有置顶的时间，并且还没过期，则在当前置顶时间上加
    @Column(columnDefinition = "datetime")
    private Date topTime;

    //参数人数
    private Integer joins;

    //任务价格
    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal price;

    //直接输入内容的字数
    private Integer words;

    //附件的总字数
    private Integer attachmentWords;

    //全部的总字数
    private Integer totalWords;

    //任务被浏览的次数
    private Integer pv;

    //任务译员报价提醒是否已经发过,null 没有 1 已经发送过提醒
    @Column(columnDefinition = "tinyint")
    private Integer notify;

    //任务进度表
    @OneToOne(mappedBy = "task", fetch = FetchType.LAZY) //JPA注释： 一对一 关系
    private Process process;

    @OneToMany(fetch = FetchType.LAZY,mappedBy ="task")
    private List<TaskUser> taskUsers;

    public Task(LanguageGroup languageGroup, TaskContent taskRequest, Quality quality, Integer emergency, Date taskEndTime, User user, String title,Integer words,Integer attachmentWords,Integer totalWords) {
        super();
        this.languageGroup = languageGroup;
        this.taskRequest = taskRequest;
        this.quality = quality;
        this.emergency = emergency;
        this.taskEndTime = taskEndTime;
        this.user = user;
        this.title = title;
        this.words = words;
        this.attachmentWords = attachmentWords;
        this.totalWords = totalWords;
    }

    @PrePersist
    void preInsert() {
        if (this.joins == null) this.joins = 0;
        if (this.off == null) this.off = 0;
        if (this.top == null) this.top = 0;
        if (this.pv == null) this.pv = 0;
    }

}
