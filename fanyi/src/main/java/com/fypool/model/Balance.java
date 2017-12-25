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
@EqualsAndHashCode(exclude={"id","user"})
@EntityListeners(AuditingEntityListener.class)
public class Balance implements Serializable { //1


    //自定义会计科目

    //支出表                        收入表
    //预付款 支出，客户->平台         预付款 收入,平台<-客户  1
    //完成任务 支出，平台->译员        完成任务 收入，译员<-平台   0
    //交易抽成 支出，译员->平台        交易抽成 收入，平台<-译员   1
    //预付款补交 支出，客户->平台      预付款补交 收入，平台<-客户  1
    //预付款退款 支出，平台->客户      预付款退款 收入，客户<-平台  0
    //申请退款 支出，平台->客户        申请退款 收入, 客户<-平台   0
    //支付宝充值 支出，客户->平台      支付宝充值 收入，平台<-客户  1
    //微信充值 支出，客户->平台        微信充值 收入，平台<-客户   1
    //银行卡充值 支出，客户->平台      银行卡充值 收入，平台<-客户  1
    //支付宝提现 支出，平台->客户      支付宝提现 收入，客户<-平台   0
    //微信提现 支出，平台->客户        微信提现 收入，客户<-平台    0
    //银行卡提现 支出，平台->客户      银行卡提现 收入，客户<-平台   0

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //所有的支出和收入都是针对平台而言的  平台是一个人，这个人现在做了这张表来记账

    //会计科目
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "accounting_id")
    private Accounting accounting;

    //用户
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //变动的金额
    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal variation;

    //变动后总金额
    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal balance;

    //关联的任务
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "task_id")
    private Task task;

    //关联的账单，说明已经入账
    @OneToOne(fetch = FetchType.LAZY)
    private Bill bill;

    //关联的充值
    @OneToOne(fetch = FetchType.LAZY)
    private Product product;

    //关联的充值
    @OneToOne(fetch = FetchType.LAZY)
    private Ticket ticket;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Balance(Accounting accounting, User user, BigDecimal variation, BigDecimal balance) {
        super();
        this.accounting = accounting;
        this.user = user;
        this.variation = variation;
        this.balance = balance;
    }

    public Balance(Accounting accounting, BigDecimal variation) {
        this.accounting = accounting;
        this.variation = variation;
    }
}
