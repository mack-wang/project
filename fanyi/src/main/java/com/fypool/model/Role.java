package com.fypool.model;

import lombok.Data;
import lombok.NoArgsConstructor;
import lombok.NonNull;
import lombok.RequiredArgsConstructor;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.Id;
import java.io.Serializable;

@Data
@NoArgsConstructor
@RequiredArgsConstructor
@Entity
public class Role implements Serializable {
	private static final long serialVersionUID = 1L;

	//ROLE_USER 用户  ROLE_ADMIN 管理员  ROLE_CLIENT 客户 ROLE_AUTHUSER 认证过的用户 ROLE_AUTHCLIENT 认证过的客户

	@Id
	@GeneratedValue
	private Integer id;

	@NonNull
	private String name;
}
