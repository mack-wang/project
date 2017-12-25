package com.fypool.model;


import lombok.Data;
import lombok.NoArgsConstructor;
import org.hibernate.annotations.ColumnDefault;

import javax.persistence.*;
import java.io.Serializable;

@Entity
@Data
@NoArgsConstructor
public class CertificateKind implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //证书名字
    private String name;

    //证书权重，默认0,越重要，权重越高
    @ColumnDefault("0")
    private Integer weight;
}
