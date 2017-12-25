package com.fypool.model;


import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedBy;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;

import javax.persistence.*;
import javax.validation.constraints.NotNull;
import java.io.Serializable;
import java.math.BigDecimal;
import java.util.Date;
import java.util.List;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id","user"})
@EntityListeners(AuditingEntityListener.class)
public class Vip implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //0 按次结 1 按月结
    @Column(columnDefinition = "tinyint")
    private Integer type;

    //合同截止日期
    @Column(columnDefinition = "datetime")
    private Date endTime;

    @OneToMany(fetch = FetchType.LAZY)
    private List<VipPrice> vipPrices;


    //附件地址
    private String path;

    //编辑的管理员的账号
    @LastModifiedBy
    private String modifiedBy;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Vip(User user, Integer type, Date endTime, List<VipPrice> vipPrices, String path) {
        super();
        this.user = user;
        this.type = type;
        this.endTime = endTime;
        this.vipPrices = vipPrices;
        this.path = path;
    }
}
