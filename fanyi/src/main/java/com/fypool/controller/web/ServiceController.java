package com.fypool.controller.web;

import com.fypool.model.Message;
import com.fypool.model.Question;
import com.fypool.repository.QuestionRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

import javax.servlet.http.HttpSession;

@Controller
public class ServiceController {

    @Autowired
    QuestionRepository questionRepository;

    @GetMapping("/public/service")
    public String publicService(){
        return "web/publicService";
    }

    @PostMapping("/public/service/question")
    public String serviceQuestion(
            @RequestParam("question") String question,
            @RequestParam("email") String email,
            Model model
    ){
        questionRepository.save(new Question(question,email));
        model.addAttribute("message",new Message(1,"已经收到您的咨询问题，我们将尽快回复，请注意查收。"));
        return "web/publicService";
    }


}
