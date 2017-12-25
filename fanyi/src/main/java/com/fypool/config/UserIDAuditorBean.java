package com.fypool.config;

import org.springframework.context.annotation.Configuration;
import org.springframework.data.domain.AuditorAware;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContext;
import org.springframework.security.core.context.SecurityContextHolder;

@Configuration
public class UserIDAuditorBean implements AuditorAware<String> {
    //这个AuditorAware可以是任何类型的，可以是Long,Integer,User,String,这个就是返回给记录编辑者名字用的
    @Override
    public String getCurrentAuditor() {
        SecurityContext ctx = SecurityContextHolder.getContext();
        if (ctx == null) {
            return null;
        }

        //只有登入的用户才能使用记录编辑者
        Authentication auth = ctx.getAuthentication();

        if(auth==null){
            return null;
        }

        String username = auth.getName();
        return username;
    }
}