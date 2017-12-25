package com.fypool.model;

import com.fasterxml.jackson.annotation.JsonIgnore;
import com.fasterxml.jackson.annotation.JsonIgnoreProperties;
import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;

import javax.persistence.*;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;
import java.util.List;


@Data
@NoArgsConstructor
@JsonIgnoreProperties({"authorities"})
@Entity
@EntityListeners(AuditingEntityListener.class)
@EqualsAndHashCode(exclude={"id","username","attribute","userInfo"})
public class User implements UserDetails , Serializable{ //1

    private static final long serialVersionUID = 1L;

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    @NotNull(message = "用户名不能为空")
    @Size(min = 3, max = 32, message = "用户名必须大于3个字符，小于32个字符")
    @Column(length = 32, unique = true)
    private String username;

    @JsonIgnore//在查询实体中忽略此项
    @NotNull(message = "密码不能为空")
    @Size(min = 6, max = 255, message = "密码必须大于6个字符，小于32个字符")
    private String password;

    //用户的微信openId,不可重复
    @Column(unique = true)
    private String openId;


    @CreatedDate
    private Date createdAt;

    @LastModifiedDate
    private Date updatedAt;

    public User(String username, String password,Date createdAt, Date updatedAt, String currentRole) {
        super();
        this.username = username;
        this.password = password;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;
        this.currentRole = currentRole;
    }

    //记录下来当前用户的角色，译员还是客户
    @Column(length = 64)
    private String currentRole;

    @ManyToMany(cascade = {CascadeType.REFRESH}, fetch = FetchType.EAGER)
    private List<Role> roles;

    @OneToOne(mappedBy = "user", fetch = FetchType.LAZY) //JPA注释： 一对一 关系
    private Attribute attribute;


    @OneToOne(mappedBy = "user", fetch = FetchType.LAZY) //JPA注释： 一对一 关系
    private Account account;

    @OneToOne(mappedBy = "user", fetch = FetchType.LAZY) //JPA注释： 一对一 关系
    private UserInfo userInfo;

    @OneToOne(mappedBy = "user", fetch = FetchType.LAZY) //JPA注释： 一对一 关系
    private Vip vip;

    @Override
    public Collection<? extends GrantedAuthority> getAuthorities() { //2
        List<GrantedAuthority> auths = new ArrayList<GrantedAuthority>();
        List<Role> roles = this.getRoles();
        for (Role role : roles) {
            auths.add(new SimpleGrantedAuthority(role.getName()));
        }
        return auths;
    }

    @Override
    public boolean isAccountNonExpired() {
        return true;
    }

    @Override
    public boolean isAccountNonLocked() {
        return true;
    }

    @Override
    public boolean isCredentialsNonExpired() {
        return true;
    }

    @Override
    public boolean isEnabled() {
        return true;
    }

    public void setPassword(String password) {
        this.password = new BCryptPasswordEncoder().encode(password);
    }



}
