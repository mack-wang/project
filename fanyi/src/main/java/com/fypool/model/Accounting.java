package com.fypool.model;


import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;

import javax.persistence.*;
import java.io.Serializable;
import java.math.BigDecimal;
import java.util.Date;

@Entity
@Data
@NoArgsConstructor
public class Accounting implements Serializable { //1


    //自定义会计科目

    //支出表                        收入表
    //预付款 支出，客户->平台         预付款 收入,平台<-客户   prepay
    //完成任务 支出，平台->译员        完成任务 收入，译员<-平台  task
    //交易抽成 支出，译员->平台        交易抽成 收入，平台<-译员  commission
    //预付款补交 支出，客户->平台      预付款补交 收入，平台<-客户  repair
    //预付款退款 支出，平台->客户      预付款退款 收入，客户<-平台 drawback
    //申请退款 支出，平台->客户        申请退款 收入, 客户<-平台 refund
    //支付宝充值 支出，客户->平台      支付宝充值 收入，平台<-客户  alipayIn
    //微信充值 支出，客户->平台        微信充值 收入，平台<-客户  wechatIn
    //银行卡充值 支出，客户->平台      银行卡充值 收入，平台<-客户  bankIn
    //支付宝提现 支出，平台->客户      支付宝提现 收入，客户<-平台 alipayOut
    //微信提现 支出，平台->客户        微信提现 收入，客户<-平台  wechatOut
    //银行卡提现 支出，平台->客户      银行卡提现 收入，客户<-平台 backOut

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

    //收入还是支出 0 支出 1 收入 | 支出是指平台付给用户，收入是指平台收到用户的钱
    //在做用户流水的时候，用户看到的收入，应该就是平台的支出，所以是type是0
    //所有的科目已经表明了支出和收入，而type只是标明科目的支出或收入属性，以便判断，所以每笔交易只要记录一条就可以
    @Column(columnDefinition = "tinyint")
    private Integer type;

    //别称，简称
    private String shortName;

    //中文全称
    private String name;

    //英文全称
    private String ename;
}
