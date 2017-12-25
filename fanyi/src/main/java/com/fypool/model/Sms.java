package com.fypool.model;

import lombok.*;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Data
@NoArgsConstructor
@Entity
@EntityListeners(AuditingEntityListener.class)
public class Sms implements Serializable {

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    @Column(length = 32)
    private String phone;

    //短信模板id
    private String templateId;

    //短信验证码
    private Integer sms;

    //短信通知
    private String content;

    //发送成功还是失败 0失败 1成功
    @Column(columnDefinition = "tinyint")
    private Integer success;

    @CreatedDate
    private Date createdAt;

    public Sms(String phone, String templateId, Integer sms,Integer success) {
        super();
        this.templateId = templateId;
        this.phone = phone;
        this.sms = sms;
        this.success = success;
    }

    public Sms(String phone, String templateId, String content,Integer success) {
        super();
        this.phone = phone;
        this.templateId = templateId;
        this.content = content;
        this.success = success;
    }
}
