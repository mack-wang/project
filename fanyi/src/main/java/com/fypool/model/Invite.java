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
public class Invite implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //资质证书和其他资质证书表
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //主动发出邀请的人
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //被邀请人
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "invite_id")
    private User invite;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Invite(User user, User invite) {
        super();
        this.user = user;
        this.invite = invite;
    }
}
