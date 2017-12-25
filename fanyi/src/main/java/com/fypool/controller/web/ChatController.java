package com.fypool.controller.web;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fypool.model.*;
import com.fypool.repository.BaseMessageRepository;
import com.fypool.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.messaging.handler.annotation.MessageMapping;
import org.springframework.messaging.simp.SimpMessagingTemplate;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

import javax.servlet.http.HttpSession;
import javax.websocket.OnOpen;
import javax.websocket.Session;
import java.io.IOException;
import java.security.Principal;
import java.text.SimpleDateFormat;
import java.util.*;

@Controller
public class ChatController {

    @Autowired
    ObjectMapper objectMapper;

    private static final SimpleDateFormat simpleDateFormat = new SimpleDateFormat("MM-dd HH:mm");

    @Autowired
    private SimpMessagingTemplate template;

    @Autowired
    private UserRepository userRepository;

    @Autowired
    private BaseMessageRepository baseMessageRepository;

    @Autowired
    private RedisTemplate redisTemplate;


    @GetMapping("/chat")
    public String chat(
            @RequestParam("to") String receiver,
            @RequestParam(value = "page", required = false) Integer page,
            Model model,
            Principal principal
    ) {
        String sender = principal.getName();

        if (!userRepository.existsByUsername(receiver)) {
            model.addAttribute("message", new Message(0, "非法操作"));
            return "web/chat";
        }
        //搜索两人的聊天记录,
        User toUser = userRepository.findByUsername(receiver);

        //得到最后一页的页码
        Integer lastPages = baseMessageRepository.findAllBySenderAndReceiverOrReceiverAndSenderOrderByCreatedAtAsc(
                sender,
                receiver,
                sender,
                receiver,
                new PageRequest(0, 10)
        ).getTotalPages() - 1;

        Integer lastPage = page == null ? lastPages : page;

        Page<BaseMessage> baseMessages = baseMessageRepository.findAllBySenderAndReceiverOrReceiverAndSenderOrderByCreatedAtAsc(
                sender,
                receiver,
                sender,
                receiver,
                new PageRequest(lastPage < 0 ? 0 : lastPage, 10)
        );

        //把未读的更新为已经读
        baseMessageRepository.updateRead(sender, receiver);


        //搜索用户与其他人的聊天记录
        Set<String> results = baseMessageRepository.getResults(sender);
        List<BaseMessage> list = new ArrayList<>();
        for (String result : results) {
            list.add(baseMessageRepository.findTopBySenderAndReceiverOrderByCreatedAtDesc(result, sender));
        }

        model.addAttribute("baseMessages", baseMessages);
        model.addAttribute("results", list);
        model.addAttribute("toUser", toUser);
        return "web/chat";
    }


    @MessageMapping("/all")
    public void all(Principal principal, String message) {
        ChatMessage chatMessage = createMessage(principal.getName(), message);
        try {
            template.convertAndSend("/topic/notice", objectMapper.writeValueAsString(chatMessage));
        } catch (JsonProcessingException e) {
            e.printStackTrace();
        }
    }

    //{"type":"text","content":" nihao","toType":"USER","receiver":"bob"}
    @MessageMapping("/chat")
    public void chat(Principal principal, String message) {
        BaseMessage baseMessage = null;
        try {
            baseMessage = objectMapper.readValue(message, BaseMessage.class);
        } catch (IOException e) {
            e.printStackTrace();
        }
        baseMessage.setSender(principal.getName());
        this.send(baseMessage);
    }

    private void send(BaseMessage message) {
        message.setDate(new Date());
        ChatMessage chatMessage = createMessage(message.getSender(), message.getContent());
        User user = userRepository.findByUsername(message.getSender());
        message.setUser(user);
        try {
            template.convertAndSendToUser(message.getReceiver(), "/topic/chat", objectMapper.writeValueAsString(chatMessage));
        } catch (JsonProcessingException e) {
            e.printStackTrace();
        }
        //保存聊天记录
        baseMessageRepository.save(message);
    }

    private ChatMessage createMessage(String username, String message) {
        ChatMessage chatMessage = new ChatMessage();
        chatMessage.setUsername(username);
        User user = userRepository.findByUsername(username);
        chatMessage.setAvatar(user.getAttribute().getAvatar());
        chatMessage.setNickname(user.getAttribute().getNickname());
        chatMessage.setContent(message);
        chatMessage.setSendTime(simpleDateFormat.format(new Date()));
        return chatMessage;
    }

    //通过前端异步更新聊天记录为已读
    @GetMapping("/chat/read")
    public void chatUpdateRead(@RequestParam("sender") String sender, Principal principal) {
        BaseMessage baseMessage = baseMessageRepository.findTopBySenderAndReceiverOrderByCreatedAtDesc(sender, principal.getName());
        baseMessage.setReading(1);
        baseMessageRepository.save(baseMessage);
    }

    @PostMapping("/chat/getUnread")
    public @ResponseBody
    Integer getUnread(Principal principal) {
        return baseMessageRepository.countByReceiverAndReading(principal.getName(), 0);
    }

    @GetMapping("/public/chat")
    public String publicChat(HttpSession session) {
        if (session.getAttribute("user") == null) {
            return "redirect:/public/service";
        } else {
            return "redirect:/chat?to=tom";
        }
    }

    //找出最近一个发起聊天的用户，跟跳转过去
    @GetMapping("/chat/unread")
    public String chatUnread(HttpSession session) {
        User user = (User) session.getAttribute("user");
        BaseMessage baseMessage = baseMessageRepository.findTopByReceiverOrderByCreatedAtDesc(user.getUsername());
        //如果这个用户从来没收到过别人的聊天信息，就去和客服聊
        if(baseMessage == null){
            return "redirect:/chat?to=service1";
        }else{
            return "redirect:/chat?to="+baseMessage.getSender();//如果有的话，就和最近的这个发送者聊天
        }
    }

}