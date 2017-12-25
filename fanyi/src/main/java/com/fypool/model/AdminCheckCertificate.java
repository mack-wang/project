package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedBy;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Entity
@Data
@NoArgsConstructor
@EntityListeners(AuditingEntityListener.class)
@EqualsAndHashCode(exclude={"id","user"})
public class AdminCheckCertificate implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //实名认证
    //提交后即正在审核中，所有东西均不能改
    //审核通过后，实名认证只有地址能改
    //审核失败后，实名认证重新提交

    //资质认证
    //提交后即正在审核，所有东西均不能改   全部带input value的可以修改，一项一项的来，不要一起来
    //审核通过后，学历可以删除和增加//这个需要新增认证
    //资质证书可以增加，可以删除和增加//这个需要新增认证，认证失败后会直接删除，但不会取消他的译员认证资格，维护原样
    //翻译价格可以增加也可以删除//这个和下面均不用新增认证
    //工作年限可以修改
    //擅长领域和用途可重新填

    //审核失败后，全部带input value的可以修改

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //实名认证,null 没提交，0正在审核，1审核通过，2审核失败
    @Column(columnDefinition = "tinyint")
    private Integer realNameCheck;

    //资质认证,null 没提交，0正在审核，1审核通过，2审核失败
    @Column(columnDefinition = "tinyint")
    private Integer certificateCheck;

    //企业认证,null 没提交，0正在审核，1审核通过，2审核失败
    @Column(columnDefinition = "tinyint")
    private Integer companyCheck;

    //所属的用户
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "user_id")
    private User user;

    //所拥有的message
    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "message_id")
    private AdminCheckCertificateMessage message;

    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    //最后处理的管理员的账号
    @LastModifiedBy
    private String modifiedBy;

    public AdminCheckCertificate(User user,AdminCheckCertificateMessage message) {
        super();
        this.user = user;
        this.message = message;
    }
}
