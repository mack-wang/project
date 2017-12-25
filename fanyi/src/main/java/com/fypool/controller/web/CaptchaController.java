package com.fypool.controller.web;

import com.google.code.kaptcha.impl.DefaultKaptcha;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.data.redis.core.ValueOperations;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;

import javax.imageio.ImageIO;
import javax.servlet.ServletOutputStream;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.awt.image.BufferedImage;
import java.util.UUID;
import java.util.concurrent.TimeUnit;

@Controller
public class CaptchaController {

    @Autowired
    RedisTemplate redisTemplate;

    @Autowired
    DefaultKaptcha defaultKaptcha;

    //使用ajax就可以获取这个图片
    @GetMapping("/public/captcha")
    public ModelAndView getKaptchaImage(HttpServletResponse response, HttpSession session) throws Exception {
        response.setDateHeader("Expires", 0);
        response.setHeader("Cache-Control",
                "no-store, no-cache, must-revalidate");
        response.addHeader("Cache-Control", "post-check=0, pre-check=0");
        response.setHeader("Pragma", "no-cache");
        response.setContentType("image/jpeg");

        String capText = defaultKaptcha.createText();
        System.out.println("capText: " + capText);//capText是由图形验证码随机生成的4个字符

        try {
            //uuid只是作为键名,以方便查找并验证
            String uuid= UUID.randomUUID().toString();
            //图形验证码有效期为5分钟
            ValueOperations<String, String> ops = this.redisTemplate.opsForValue();
            ops.set("captcha:"+uuid, capText,60*5, TimeUnit.SECONDS);
            //当他注册的时候，用这个键名，去找图形验证码，只有图形验证码正确，才能收到短信
            session.setAttribute("captchaKey","captcha:"+uuid);
        } catch (Exception e) {
            e.printStackTrace();
        }

        BufferedImage bi = defaultKaptcha.createImage(capText);
        ServletOutputStream out = response.getOutputStream();
        ImageIO.write(bi, "jpg", out);
        try {
            out.flush();
        } finally {
            out.close();
        }
        return null;
    }


}
