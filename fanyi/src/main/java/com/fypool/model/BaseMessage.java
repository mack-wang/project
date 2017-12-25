package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.util.Date;

@Entity
@EntityListeners(AuditingEntityListener.class)
@EqualsAndHashCode(exclude={"id","user"})
@Data
//服务器从客户端接收的信息
public class BaseMessage {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    // 消息类型，现在默认text,以后也许会加图片
    private String type;

    // 消息内容
    private String content;

    // 发送者
    @Column(length = 64)
    private String sender;

    // 接受者 类型
    private String toType;

    // 接受者
    @Column(length = 64)
    private String receiver;

    //发送者用户实例
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    // 发送时间，主要是格式化了时间，只显示月日时分
    private Date date;

    //1已读，0未读
    @Column(columnDefinition = "tinyint")
    private Integer reading;

    // 创建时间
    @CreatedDate
    private Date createdAt;

    @PrePersist
    void preInsert() {
        if (this.reading == null) this.reading = 0;
    }

}