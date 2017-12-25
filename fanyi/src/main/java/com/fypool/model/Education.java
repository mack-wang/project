package com.fypool.model;


import com.fasterxml.jackson.annotation.JsonBackReference;
import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Entity
@Data
@NoArgsConstructor
@EntityListeners(AuditingEntityListener.class)
@EqualsAndHashCode(exclude={"id","user"})
public class Education implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //显示用户的昵称，头像，邮箱

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    private String number;

    private String school;

    private String degree;

    private String major;

    private Integer startYear;

    private Integer graduateYear;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Education(User user) {
        super();
        this.user = user;
    }

    public Education(String number, String school, String degree, String major, Integer startYear,Integer graduateYear, User user) {
        super();
        this.number = number;
        this.school = school;
        this.degree = degree;
        this.major = major;
        this.startYear = startYear;
        this.graduateYear = graduateYear;
        this.user = user;
    }
}
