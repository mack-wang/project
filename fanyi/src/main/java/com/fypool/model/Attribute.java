package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import lombok.NonNull;
import org.hibernate.validator.constraints.Email;

import javax.persistence.*;
import javax.validation.constraints.Size;
import java.io.Serializable;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id","user"})
public class Attribute implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //显示用户的昵称，头像，邮箱

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    @NonNull
    @Size(min = 2, max = 64, message = "昵称必须大于2个字符，小于32个字符")
    @Column(length = 64)
    private String nickname;

    private String avatar;

    @Email(message = "邮箱格式不正确")
    private String email;

    @NonNull
    @Size(min = 11,max = 11,message = "手机号必须为11位")
    @Column(length = 32, unique = true)
    private String phone;

    @NonNull
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //译员信用积分 信用分数=任务数*5分+评价数星数*1分，20分-星 100分-钻 500分-皇冠  2500分 5皇冠 封顶
    private Integer score;

    //译员翻译总字数
    private Integer words;

    //完成的任务数
    private Integer taskDone;

    public Attribute(String nickname,String phone, User user) {
        super();
        this.nickname = nickname;
        this.phone = phone;
        this.user = user;
    }

    @PrePersist
    void preInsert() {
        if (this.score == null) this.score = 0;
        if (this.words == null) this.words = 0;
        if (this.taskDone == null) this.taskDone = 0;
        if (this.avatar == null) this.avatar = "/img/fanyi/default.png";

    }

}
