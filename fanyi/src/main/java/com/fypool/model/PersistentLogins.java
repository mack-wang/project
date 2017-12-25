package com.fypool.model;


import lombok.Data;
import lombok.NoArgsConstructor;

import javax.persistence.*;
import java.io.Serializable;

@Entity
@Data
@NoArgsConstructor
public class PersistentLogins implements Serializable { //1

    private static final long serialVersionUID = 1L;

    @Column(length = 64)
    private String username;


    @Column(length = 64)
    private String token;

    //@id就是定义为primary key
    @Id
    @Column(length = 64)
    private String series;

    @Column(columnDefinition = "timestamp")
    private String last_used;

}
