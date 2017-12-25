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

@Entity
@Data
@NoArgsConstructor
@EntityListeners(AuditingEntityListener.class)
@EqualsAndHashCode(exclude={"id","user"})
public class ReportIllegal implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "task_id")
    private Task task;

    //举报人
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //违法内容
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name="illegal_id")
    private Illegal illegal;

    //处理结果 0 未处理 1 关闭 2 取消
    @Column(columnDefinition = "tinyint")
    private Integer result;

    //举报时间
    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    //处理的管理员的账号
    @LastModifiedBy
    private String modifiedBy;


    public ReportIllegal(Task task, User user, Illegal illegal,Integer result) {
        super();
        this.task = task;
        this.user = user;
        this.illegal = illegal;
        this.result = result;
    }

    @PrePersist
    void preInsert() {
        if (this.result == null) this.result = 0;
    }
}
