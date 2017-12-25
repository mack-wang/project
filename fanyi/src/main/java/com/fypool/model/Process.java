package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.math.BigDecimal;
import java.util.Date;

@Entity
@Data
@NoArgsConstructor
@EntityListeners(AuditingEntityListener.class)
@EqualsAndHashCode(exclude={"id","user","task"})
public class Process implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "task_id")
    private Task task;

    //选定的译员
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //3结束后，任务就结束了，钱就打了，评价任务可做可不做
    //对于客户来说：0 选择译员 1 正在翻译 2 审核稿件 3 评价任务 4 已经评论
    //对于译员来说：0 正在投标 1 提交翻译 2 客户审核 3 完成任务，显示任务评价 4 已经评论
    @Column(columnDefinition = "tinyint")
    private Integer process;

    //翻译后的内容
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "translate_id")
    private TaskContent translate;

    //客户审核意见
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "advice_id")
    private TaskContent advice;

    //附件下载地址
    private String attachment;

    //客户审核结果，0 继续修改 1 审核通过
    @Column(columnDefinition = "tinyint")
    private Integer checked;

    //评价 1-5星
    @Column(columnDefinition = "tinyint")
    private Integer star;

    //关联发票申请
    @OneToOne(fetch = FetchType.LAZY)
    private InvoiceRequest invoiceRequest;

    //关联的签章申请
    @OneToOne(fetch = FetchType.LAZY)
    private SignatureRequest signatureRequest;

    //参数评语,用逗号分开
    private String templateComment;

    //自定义评语,因为comment是mysql关键字，所以加s避开
    private String clientComment;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Process(Task task) {
        super();
        this.task = task;
    }

    @PrePersist
    void preInsert() {
        if (this.process == null) this.process = 0;
    }
}
