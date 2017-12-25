package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import javax.validation.constraints.Size;
import java.io.Serializable;
import java.util.Date;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id","user"})
@EntityListeners(AuditingEntityListener.class)
public class Address implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //显示用户的昵称，头像，邮箱

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    @Size(min = 2, max = 12, message = "请输入2到6个汉字中文名（特殊名字情况请输入简称）")
    @Column(length = 32)
    private String name;

    private String phone;

    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "province_id")
    private MhCity province;

    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "city_id")
    private MhCity city;

    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "area_id")
    private MhCity area;

    private String address;

    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public Address(String name, MhCity province, MhCity city, MhCity area, String address, User user) {
        super();
        this.name = name;
        this.province = province;
        this.city = city;
        this.area = area;
        this.address = address;
        this.user = user;
    }
}
