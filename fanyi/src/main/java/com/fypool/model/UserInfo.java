package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import lombok.NonNull;

import javax.persistence.*;
import javax.validation.constraints.Size;
import java.io.Serializable;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id","user"})
public class UserInfo implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //显示用户的昵称，头像，邮箱

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    @Size(min = 2, max = 64, message = "姓名必须大于2个字符，小于32个字符")
    @Column(length = 64)
    private String name;


    @Size(max = 255, message = "简介必须小125字")
    private String introduce;

    //所在城市
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "city_id")
    private MhCity city;

    //0为女，1为男
    @Column(columnDefinition = "tinyint")
    private Integer sex;



    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    public UserInfo(Integer sex) {
        super();
        this.sex = sex;
    }

    public UserInfo(User user) {
        super();
        this.user = user;
    }
}
