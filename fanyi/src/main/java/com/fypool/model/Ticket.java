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
@EqualsAndHashCode(exclude={"id","user","invite"})
@EntityListeners(AuditingEntityListener.class)
public class Ticket implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //优惠券的名字
    private String title;

    private String etitle;


    //获得优惠券的原因 0 邀请码获得 1 新手注册获得
    @Column(columnDefinition = "tinyint")
    private Integer type;

    //优惠券价格
    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal price;

    //满多少才可以用
    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal limitation;

    //拥有者
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //优惠券有效期
    @Column(columnDefinition = "datetime")
    private Date endTime;

    //是否使用掉了 0没有使用 1使用了
    @Column(columnDefinition = "tinyint")
    private Integer used;

    //记录优惠券用在了哪个任务上，如果这个任务在支付给译员这个阶段的时候，就把优惠的支出账单生成
    //不然优惠就相当于用了，但我们没有支出，自然就不应该有流水
//    @OneToOne(fetch = FetchType.LAZY)
//    private Task task;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    @PrePersist
    void preInsert() {
        if (this.used == null) this.used = 0;
    }

    public Ticket(Integer type,String title, BigDecimal price, BigDecimal limitation, User user, Date endTime) {
        super();
        this.type = type;
        this.title = title;
        this.price = price;
        this.limitation = limitation;
        this.user = user;
        this.endTime = endTime;
    }
}
