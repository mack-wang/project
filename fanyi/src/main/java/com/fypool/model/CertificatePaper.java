package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;

import javax.persistence.*;
import java.io.Serializable;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id","user"})
public class CertificatePaper implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //资质证书和其他资质证书表
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //证书类型，0表中资质，1自己写的资质
    @Column(columnDefinition = "tinyint")
    private Integer type;

    //其他资质证书名称
    private String otherCertificate;

    //常规资质证书的id
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "certificate_kind_id")
    private CertificateKind certificateKind;

    //所属用户的id
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    public CertificatePaper(Integer type, CertificateKind certificateKind, User user) {
        this.type = type;
        this.certificateKind = certificateKind;
        this.user = user;
    }

    public CertificatePaper(Integer type, String otherCertificate, User user) {
        this.type = type;
        this.otherCertificate = otherCertificate;
        this.user = user;
    }
}
