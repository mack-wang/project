package com.fypool.web;

import org.junit.Before;
import org.junit.Test;
import org.junit.runner.RunWith;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.http.MediaType;
import org.springframework.test.context.junit4.SpringRunner;
import org.springframework.test.web.servlet.MockMvc;
import org.springframework.test.web.servlet.setup.MockMvcBuilders;
import org.springframework.web.context.WebApplicationContext;

//将以下包以静态方法的形式导入，更方便使用
import static org.springframework.security.test.web.servlet.request.SecurityMockMvcRequestPostProcessors.csrf;
import static org.springframework.security.test.web.servlet.setup.SecurityMockMvcConfigurers.springSecurity;
import static org.springframework.test.web.servlet.request.MockMvcRequestBuilders.*;
import static org.springframework.test.web.servlet.result.MockMvcResultMatchers.*;


@RunWith(SpringRunner.class)
@SpringBootTest(webEnvironment = SpringBootTest.WebEnvironment.RANDOM_PORT)
public class RegisterTest {

    @Autowired
    private WebApplicationContext webApplicationContext;//注入web环境上下文

    private MockMvc mockMvc;//模拟web访问

    //在模拟之前，先把注入的web环境创建起来
    @Before
    public void setupMockMvc() {
        mockMvc = MockMvcBuilders.webAppContextSetup(webApplicationContext)
                .apply(springSecurity())
                .build();
    }


    //测试注册
    @Test
    public void postUser() throws Exception {
        String uri = "/register";
        mockMvc.perform(
                post(uri)
                        .contentType(MediaType.APPLICATION_FORM_URLENCODED)
                        .param("username", "cindy2")
                        .param("nickname", "mack wang")
                        .param("password", "123456")
                        .param("phone", "15757130093")
                        .param("sms", "1111")
                        .param("role", "ROLE_USER")
                        .with(csrf())
        ).andExpect(status().is3xxRedirection());//
    }

}
