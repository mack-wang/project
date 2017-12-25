package com.fypool.model;

import lombok.AllArgsConstructor;
import lombok.Data;

import java.io.Serializable;

@Data
@AllArgsConstructor
public class Message implements Serializable {

    private static final long serialVersionUID = 1L;

    private Integer status;

    private String title;

    private String content;

    private String etraInfo;

    public Message(Integer status, String content) {
        super();
        this.status = status;
        this.content = content;
    }

    public Message(String content){
        super();
        this.content = content;
    }

    public Message(Integer status){
        super();
        this.status = status;
    }


}
