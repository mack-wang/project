package com.fypool.model;


import lombok.Data;
import lombok.NoArgsConstructor;

import javax.persistence.*;
import javax.validation.constraints.Size;
import java.io.Serializable;
import java.util.List;

@Entity
@Data
@NoArgsConstructor
public class CertificateInfo implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //显示用户的昵称，头像，邮箱

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    //从事翻译的年限
    private Integer translateYear;


    //母语
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "language_id")
    private Languages motherTongue;


    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    @ManyToMany(fetch = FetchType.LAZY)
    private List<SkilledField> skilledFields;

    @ManyToMany(fetch = FetchType.LAZY)
    private List<SkilledUsage> skilledUsages;

}
