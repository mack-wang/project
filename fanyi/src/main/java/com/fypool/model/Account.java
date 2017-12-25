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
import javax.validation.constraints.NotNull;
import java.io.Serializable;
import java.math.BigDecimal;
import java.util.Date;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id","user"})
@EntityListeners(AuditingEntityListener.class)
public class Account implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //资质证书和其他资质证书表
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //金钱余额
    @NotNull
    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal money;

    //支付密码
    @JsonIgnore//在查询实体中忽略此项
    private String password;

    public void setPassword(String password) {
        this.password = new BCryptPasswordEncoder().encode(password);
    }

    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Account(BigDecimal money, User user) {
        super();
        this.money = money;
        this.user = user;
    }
}
