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
@EqualsAndHashCode(exclude={"id"})
public class Attachment implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    //路径
    private String path;

    //后缀
    private String suffixName;

    //语言类型，char,word
    private String type;

    //文件大小b,因为我们不允许上传超过100M的文件
    private Integer size;

    //文件是否可数字数
    private String hasCount;

    //页数
    private Integer pages;

    //字符数
    private Integer chars;

    //单词数
    private Integer words;

    //用户输入的字数
    private Integer clientWords;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;


    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "task_id")
    private Task task;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "process_id")
    private Process process;

    public Attachment(String path, String suffixName, String type, Integer size, String hasCount, Integer pages, Integer chars, Integer words, Integer clientWords, Task task) {
        super();
        this.path = path;
        this.suffixName = suffixName;
        this.type = type;
        this.size = size;
        this.hasCount = hasCount;
        this.pages = pages;
        this.chars = chars;
        this.words = words;
        this.clientWords = clientWords;
        this.task = task;
    }

    public Attachment(String path, String suffixName, String type, Integer size, String hasCount, Integer pages, Integer chars, Integer words, Integer clientWords, Process process) {
        super();
        this.path = path;
        this.suffixName = suffixName;
        this.type = type;
        this.size = size;
        this.hasCount = hasCount;
        this.pages = pages;
        this.chars = chars;
        this.words = words;
        this.clientWords = clientWords;
        this.process = process;
    }
}
