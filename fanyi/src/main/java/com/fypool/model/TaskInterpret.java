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
@EqualsAndHashCode(exclude={"id"})
public class TaskInterpret implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    //口译类型，0 交传 1 同传
    @Column(columnDefinition = "tinyint")
    private Integer type;

    //口译开始日期
    @Column(columnDefinition = "datetime")
    private Date startTime;

    //口译结束日期
    @Column(columnDefinition = "datetime")
    private Date endTime;

    //每日工作时长
    @Column(columnDefinition = "tinyint")
    private Integer workTime;

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

    public TaskInterpret(Integer type, Date startTime, Date endTime, Integer workTime,MhCity province, MhCity city, MhCity area, String address) {
        super();
        this.type = type;
        this.startTime = startTime;
        this.endTime = endTime;
        this.workTime = workTime;
        this.province = province;
        this.city = city;
        this.area = area;
        this.address = address;
    }
}
