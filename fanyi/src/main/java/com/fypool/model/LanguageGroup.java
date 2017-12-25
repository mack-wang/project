package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;

import javax.persistence.*;
import java.io.Serializable;

@Entity
@Data
@NoArgsConstructor
@EqualsAndHashCode(exclude={"id"})
public class LanguageGroup implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    //原语言
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "origin_language_id")
    private Languages originLanguages;

    //翻译语言
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "translate_language_id")
    private Languages translateLanguages;
}
