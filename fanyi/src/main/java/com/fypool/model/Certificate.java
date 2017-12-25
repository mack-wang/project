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
public class Certificate implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //显示用户的昵称，头像，邮箱

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    @Size(min = 2, max = 12, message = "请输入2到6个汉字中文名（特殊名字情况请输入简称）")
    @Column(length = 32)
    private String name;

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

    @Size(min = 15, max = 18, message = "请输入正确的身份证号码")
    @Column(length = 32)
    private String idNumber;

    private String idCardFront;

    private String idCardBack;


    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    public Certificate(String name, MhCity province, MhCity city, MhCity area, String address, String idNumber, String idCardFront, String idCardBack, User user) {
        super();
        this.name = name;
        this.province = province;
        this.city = city;
        this.area = area;
        this.address = address;
        this.idNumber = idNumber;
        this.idCardFront = idCardFront;
        this.idCardBack = idCardBack;
        this.user = user;
    }
}
