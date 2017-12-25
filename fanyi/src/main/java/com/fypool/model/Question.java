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
@EqualsAndHashCode(exclude={"id"})
@EntityListeners(AuditingEntityListener.class)
public class Question implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @Column(length = 500)
    private String question;

    private String email;

    @Column(length = 500)
    private String respond;

    //0 未处理 1 已回复 2 已经关闭
    @Column(columnDefinition = "tinyint")
    private Integer result;

    @LastModifiedBy
    private String modifiedBy;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Question(String question, String email) {
        super();
        this.question = question;
        this.email = email;
    }

    @PrePersist
    void preInsert() {
        if (this.result == null) this.result = 0;
    }
}
