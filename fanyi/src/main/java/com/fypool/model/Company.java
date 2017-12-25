package com.fypool.model;


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
public class Company implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //显示用户的昵称，头像，邮箱

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    private String name;

    private String license;

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

    @Column(length = 64)
    private String contactName;

    @Column(length = 32)
    private String contactPhone;

    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    public Company(String name, String license, MhCity province, MhCity city, MhCity area, String address, String contactName, String contactPhone, User user) {
        this.name = name;
        this.license = license;
        this.province = province;
        this.city = city;
        this.area = area;
        this.address = address;
        this.contactName = contactName;
        this.contactPhone = contactPhone;
        this.user = user;
    }
}
