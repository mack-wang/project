package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.math.BigDecimal;
import java.util.Date;

@Entity
@Data
@NoArgsConstructor
@EntityListeners(AuditingEntityListener.class)
public class FileClean implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //文件清理记录，不对外显示，管理员可以通过rest查看
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //清理的大小
    private Long size;

    //清理的文件夹
    private String folder;

    //清理的文件数量
    private Integer counts;

    //清理时间
    @CreatedDate
    private Date createdAt;

    public FileClean(Long size, String folder, Integer counts) {
        super();
        this.size = size;
        this.folder = folder;
        this.counts = counts;
    }
}
