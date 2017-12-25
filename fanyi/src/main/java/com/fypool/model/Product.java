package com.fypool.model;

import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

/**
 * 产品订单信息
 * 创建者 科帮网
 * 创建时间	2017年7月27日
 */
@Entity
@Data
@NoArgsConstructor
@EntityListeners(AuditingEntityListener.class)
public class Product implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    private String price;// 总金额(单位是元)

    private String outTradeNo;// 订单号(唯一)，准备用时间和用户id来做为订单号　

    private String createIp;// 发起人IP地址

    private String attach;// 附件数据主要用于商户携带订单的自定义数据

    @Column(columnDefinition = "tinyint")
    private Integer payType;// 支付类型(1:支付宝 2:微信 3:银联)

    @Column(columnDefinition = "tinyint")
    private Integer payWay;// 支付方式 (1：PC,平板 2：手机)

    @Column(columnDefinition = "tinyint")
    private Integer status;// 支付结果 (0失败 1成功)

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;//发起的用户

    //提现到账号，可能是支付宝或者微信或者银联
    private String account;

    private String outBizNo;// 提现订单(唯一)，准备用时间和用户id来做为订单号　

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Product(String price, String outTradeNo, String createIp, Integer payType, Integer payWay, User user) {
        super();
        this.price = price;
        this.outTradeNo = outTradeNo;
        this.createIp = createIp;
        this.payType = payType;
        this.payWay = payWay;
        this.user = user;
    }

    public Product(String price, String outBizNo, String createIp, Integer payType, Integer payWay, User user,String account) {
        super();
        this.price = price;
        this.outBizNo = outBizNo;
        this.createIp = createIp;
        this.payType = payType;
        this.payWay = payWay;
        this.user = user;
        this.account = account;
    }

    @PrePersist
    void preInsert() {
        if (this.status == null) this.status = 0;
    }
}
