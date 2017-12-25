package com.fypool.config;

import com.fypool.service.CustomUserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.core.annotation.Order;
import org.springframework.security.authentication.AuthenticationProvider;
import org.springframework.security.authentication.dao.DaoAuthenticationProvider;
import org.springframework.security.config.annotation.authentication.builders.AuthenticationManagerBuilder;
import org.springframework.security.config.annotation.method.configuration.EnableGlobalMethodSecurity;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.configuration.WebSecurityConfigurerAdapter;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.security.web.authentication.rememberme.JdbcTokenRepositoryImpl;
import org.springframework.security.web.authentication.rememberme.PersistentTokenRepository;

import javax.sql.DataSource;

@Configuration
@Order(1)
@EnableGlobalMethodSecurity(securedEnabled = true,prePostEnabled = true)
public class AdminWebSecurityConfig extends WebSecurityConfigurerAdapter {//1

    @Autowired
    DataSource dataSource;

    @Bean
    UserDetailsService customUserService() { //2
        return new CustomUserService();
    }

    @Override
    protected void configure(AuthenticationManagerBuilder auth) throws Exception {
        auth.userDetailsService(customUserService()); //3
        auth.authenticationProvider(authenticationProvider());
    }

    @Override
    protected void configure(HttpSecurity http) throws Exception {
        http.antMatcher("/admin/**")
                .authorizeRequests()
                .anyRequest().hasRole("ADMIN")
                .antMatchers("/admin/super/**")//超级管理员才能访问的路径
                .hasRole("SUPER_ADMIN")
                .and()
                .formLogin()
                .loginPage("/login")//登入页面地址
                .defaultSuccessUrl("/admin/nav")
                .failureUrl("/login?error")//登入失败返回的地址
                .permitAll() //5
                .and()
                .rememberMe()
                .tokenValiditySeconds(86400)//2419200秒30天
                .tokenRepository(persistentTokenRepository())
                .key("fypool")
                .and()
                .logout()
                .deleteCookies("remember-me")//   注销会删除cookie
                .invalidateHttpSession(true)
                .permitAll();//任何页面都可以退出
    }

    @Bean
    public PersistentTokenRepository persistentTokenRepository() {
        JdbcTokenRepositoryImpl db = new JdbcTokenRepositoryImpl();
        db.setDataSource(dataSource);
        return db;
    }

    @Bean
    public PasswordEncoder passwordEncoder() {
        return new BCryptPasswordEncoder();
    }

    @Bean
    public AuthenticationProvider authenticationProvider() {
        DaoAuthenticationProvider authenticationProvider = new DaoAuthenticationProvider();
        authenticationProvider.setUserDetailsService(userDetailsService());
        authenticationProvider.setPasswordEncoder(passwordEncoder());

        return authenticationProvider;
    }

}
