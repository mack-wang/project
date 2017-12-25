package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import javax.validation.constraints.Size;
import java.io.Serializable;
import java.util.Date;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude = {"id", "user"})
@EntityListeners(AuditingEntityListener.class)
public class Invoice implements Serializable { //1

    private static final long serialVersionUID = 1L;

//    增值税专用发票：名称、纳税人识别号、地址、电话、开户行、账号。
//    增值税普通发票：名称、纳税人识别号。
//    个人发票：名称。

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    //发票类型 0 增值税专用发票 ， 1 增值税普通发票，2 个人发票
    @Column(columnDefinition = "tinyint")
    private Integer type;

    //名称
    private String title;

    //纳税人识别号
    private String tax;

    //地址
    private String address;

    //电话
    private String phone;

    //开户行
    private String bank;

    //开户账号
    private String account;

    //软删除 0 未删除 1 已删除（不可修改，因为以前的发票已经发出。不可删除，因为有发票关联此记录。所以只能软删除）
    @Column(columnDefinition = "tinyint")
    private Integer deleted;


    //一个人最多有5条发票记录，只能删除，不能修改
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Invoice(Integer type, String title, User user) {
        super();
        this.type = type;
        this.title = title;
        this.user = user;
    }

    public Invoice(Integer type, String title, String tax, User user) {
        super();
        this.type = type;
        this.title = title;
        this.tax = tax;
        this.user = user;
    }

    public Invoice(Integer type, String title, String tax, String address, String phone, String bank, String account, User user) {
        super();
        this.type = type;
        this.title = title;
        this.tax = tax;
        this.address = address;
        this.phone = phone;
        this.bank = bank;
        this.account = account;
        this.user = user;
    }


    @PrePersist
    void preInsert() {
        if (this.deleted == null) this.deleted = 0;
    }
}
