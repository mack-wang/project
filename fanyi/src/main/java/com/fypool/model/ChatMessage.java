package com.fypool.model;


import lombok.Data;


@Data
//服务器返回给客户端的信息
public class ChatMessage {

    private String username;

    private String nickname;

    private String avatar;

    private String content;

    private String sendTime;

}