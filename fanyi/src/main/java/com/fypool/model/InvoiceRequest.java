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
@EqualsAndHashCode(exclude={"id","user","task","vipTask"})
@EntityListeners(AuditingEntityListener.class)
public class InvoiceRequest implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //显示用户的昵称，头像，邮箱

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    //开票资料
    @OneToOne(fetch = FetchType.LAZY)
    private Invoice invoice;

    //邮寄地址
    @OneToOne(fetch = FetchType.LAZY)
    private Address address;

    //关联任务
    @OneToOne(fetch = FetchType.LAZY)
    private Task task;

    //关联vip任务
    @OneToOne(fetch = FetchType.LAZY)
    private VipTask vipTask;

    //处理结果 0 已经提交，未处理 1 已经处理
    @Column(columnDefinition = "tinyint")
    private Integer result;

    //快递单号 百世快递：478379534892
    private String trackingNumber;

    //处理的管理员的账号
    @LastModifiedBy
    private String modifiedBy;


    @ManyToOne(fetch = FetchType.LAZY)
    private User user;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    @PrePersist
    void preInsert() {
        if (this.result == null) this.result = 0;
    }

    public InvoiceRequest(Invoice invoice, Address address, Task task, User user) {
        super();
        this.invoice = invoice;
        this.address = address;
        this.task = task;
        this.user = user;
    }

    public InvoiceRequest(Invoice invoice, Address address, VipTask vipTask, User user) {
        super();
        this.invoice = invoice;
        this.address = address;
        this.vipTask = vipTask;
        this.user = user;
    }
}
