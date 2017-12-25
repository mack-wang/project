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
@EqualsAndHashCode(exclude={"id"})
@EntityListeners(AuditingEntityListener.class)
public class Catalog implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //资质证书和其他资质证书表
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //目录名
    private String catalog;

    //目录英文名
    private String ecatalog;

    //置顶 0 不置顶 1置顶
    @Column(columnDefinition = "tinyint")
    private Integer top;

    //0 开启 1 关闭
    @Column(columnDefinition = "tinyint")
    private Integer off;

    //编辑的管理员的账号
    @LastModifiedBy
    private String modifiedBy;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    @PrePersist
    void preInsert() {
        if (this.off == null) this.off = 0;
        if (this.top == null) this.top = 0;
    }

    public Catalog(String catalog, String ecatalog) {
        super();
        this.catalog = catalog;
        this.ecatalog = ecatalog;
    }
}
