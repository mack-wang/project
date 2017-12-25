package com.fypool.model;


import lombok.Data;
import lombok.NoArgsConstructor;

import javax.persistence.*;
import java.io.Serializable;

@Entity
@Data
@NoArgsConstructor
public class TaskContent implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    //翻译内容 text 20000字上限
    @Column(columnDefinition = "text")
    private String content;

    public TaskContent(String content) {
        this.content = content;
    }
}
