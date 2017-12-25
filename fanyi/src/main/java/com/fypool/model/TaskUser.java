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
import java.util.List;

@Entity
@Data
@NoArgsConstructor
@EntityListeners(AuditingEntityListener.class)
@EqualsAndHashCode(exclude={"id","user","attribute"})
public class TaskUser implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "task_id")
    private Task task;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "attribute_id")
    private Attribute attribute;

    @OneToMany(fetch = FetchType.LAZY) //JPA注释： 一对一 关系
    private List<Education> educations;

    //0未选中，1选中
    @Column(columnDefinition = "tinyint")
    private Integer selected;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    //任务报价
    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal price;

    @PrePersist
    void preInsert() {
        if (this.selected == null) this.selected = 0;
    }

    public TaskUser(Task task, User user,BigDecimal price,Attribute attribute) {
        super();
        this.task = task;
        this.user = user;
        this.price = price;
        this.attribute = attribute;
    }
}
