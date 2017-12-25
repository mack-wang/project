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
import java.math.BigDecimal;
import java.util.Date;
import java.util.List;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id","user"})
@EntityListeners(AuditingEntityListener.class)
public class Bill implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //应该支付的金额
    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal price;

    //vip客户
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //对应的vip任务,次结就绑定1个任务，月结就绑定多个任务
    @OneToMany(fetch = FetchType.LAZY)
    private List<VipTask> vipTasks;

    //账单类型 0 次结  1 月结
    @Column(columnDefinition = "tinyint")
    private Integer type;

    //账单月份 201701
    private String month;

    //账单是否发送 0 未发送 1 已发送
    @Column(columnDefinition = "tinyint")
    private Integer send;

    //是否已经支付 0 未支付 1 已经支付
    @Column(columnDefinition = "tinyint")
    private Integer pay;

    //编辑的管理员的账号
    @LastModifiedBy
    private String modifiedBy;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Bill(BigDecimal price, User user, List<VipTask> vipTasks, Integer type, Integer pay,Integer send) {
        super();
        this.price = price;
        this.user = user;
        this.vipTasks = vipTasks;
        this.type = type;
        this.pay = pay;
        this.send = send;
    }

    public Bill(BigDecimal price, User user, List<VipTask> vipTasks, Integer type, Integer pay,Integer send,String month) {
        super();
        this.price = price;
        this.user = user;
        this.vipTasks = vipTasks;
        this.type = type;
        this.pay = pay;
        this.send = send;
        this.month = month;
    }
}
