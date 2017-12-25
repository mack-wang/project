package com.fypool.model;

import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Data
@NoArgsConstructor
@Entity
@EntityListeners(AuditingEntityListener.class)
@EqualsAndHashCode(exclude={"id","user","receiver"})
public class SmsNotify implements Serializable {

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    //已经使用的短信数量,每天零点重置为0
    private Integer used;

    //该用户拥有的数量
    private Integer account;

    //发生提醒短信者
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    @CreatedDate
    private Date createdAt;

    public SmsNotify(Integer used, Integer account, User user) {
        super();
        this.used = used;
        this.account = account;
        this.user = user;
    }
}
