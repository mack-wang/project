package com.fypool.config;

import com.fypool.service.CustomUserService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.core.annotation.Order;
import org.springframework.http.HttpMethod;
import org.springframework.security.authentication.AuthenticationProvider;
import org.springframework.security.authentication.dao.DaoAuthenticationProvider;
import org.springframework.security.config.annotation.authentication.builders.AuthenticationManagerBuilder;
import org.springframework.security.config.annotation.method.configuration.EnableGlobalMethodSecurity;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.builders.WebSecurity;
import org.springframework.security.config.annotation.web.configuration.WebSecurityConfigurerAdapter;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.security.web.authentication.rememberme.JdbcTokenRepositoryImpl;
import org.springframework.security.web.authentication.rememberme.PersistentTokenRepository;

import javax.sql.DataSource;

@Configuration
@Order(3)
@EnableGlobalMethodSecurity(securedEnabled = true, prePostEnabled = true)
public class UserWebSecurityConfig extends WebSecurityConfigurerAdapter {//1

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
        http.csrf()
                .ignoringAntMatchers(
                        "/alipay/notify",
                        "/union/notify",
                        "/union/notify2",
                        "/weixin/notify",
                        "/union/authRedirect",
                        "/weixin/authRedirect",
                        "/wechat/portal",
                        "/wechat/menu/**",
                        "/logout",
                        "/wechat/logout"
                )
                .and()
                .authorizeRequests()
                .antMatchers(
                        "/",
                        "/MP_verify_uXyaYm9NYHAfbvdC.txt",
                        "/index",
                        "/register/**",
                        "/public/**",
                        "/login/phone",
                        "/market",
                        "/article/**",
                        "/catalog/**",
                        "/task/detail",
                        "/alipay/notify",//允许支付宝异步返回充值结果
                        "/union/notify",//允许银联异步返回充值结果
                        "/union/notify2",//允许银联异步返回充值结果
                        "/weixin/notify",//允许微信异步返回充值结果
                        "/wechat",//微信服务器token验证
                        "/weixin/authRedirect",
                        "/alipay/authRedirect",//跳转回去时不用登入
                        "/alipay/authRedirect",//跳转回去时不用登入
                        "/wechat/portal/**",
                        "/wechat/public/**",
                        "/wechat/login"
                ).permitAll()//无需登入
                .antMatchers(
                        HttpMethod.GET,
                        "/rest/mhCities/**", //向所有用户开放城市查询的权限
                        "/rest/certificateKinds/**", //向所有用户开放证书种类查询的权限
                        "/rest/languageses/**", //向所有用户开放语言种类查询的权限
                        "/rest/languageGroups/**", //向所有用户开放翻译语言组查询的权限
                        "/rest/skilledFields/**", //向所有用户开放语言种类查询的权限
                        "/rest/skilledUsages/**" //向所有用户开放语言种类查询的权限
                ).hasAnyRole("USER", "CLIENT", "ADMIN")
                .antMatchers(
                        "/user/updateCity/**" //向所有用户城市查询的权限
                ).hasRole("USER")
                .antMatchers(
                        HttpMethod.PATCH,
                        "/rest/mhCities/**" //向所有用户城市查询的权限
                ).hasAnyRole("USER", "CLIENT", "ADMIN")
                .antMatchers(
                        "/rest/smses/**" //向所有用户开放的路径
                ).hasAnyRole("USER", "CLIENT", "ADMIN")
                .antMatchers(
                        "/rest/**", //仅向管理员开放的路径
                        "/wechat/menu/**" //仅向管理员开放的路径
                ).hasRole("ADMIN")
                .anyRequest().authenticated() //其他所有页面均需要登入授权
                .and()
                .formLogin()
                .loginPage("/login")//登入页面地址
                .defaultSuccessUrl("/info")
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
//                .headers()
//                .frameOptions()
//                .disable();//暂关闭框架引用

    }

    @Bean
    public PersistentTokenRepository persistentTokenRepository() {
        JdbcTokenRepositoryImpl db = new JdbcTokenRepositoryImpl();
        db.setDataSource(dataSource);
        return db;
    }

    @Override
    public void configure(WebSecurity web) throws Exception {
        web.ignoring().antMatchers("/semantic/**");
        web.ignoring().antMatchers("/modules/**");
        web.ignoring().antMatchers("/font/**");
        web.ignoring().antMatchers("/img/**");
        web.ignoring().antMatchers("/upload/**");
        web.ignoring().antMatchers("/wangeditor/**");
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
