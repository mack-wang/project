package com.fypool.repository;

import com.fypool.model.Task;
import com.fypool.model.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.data.rest.core.annotation.RestResource;


public interface UserRepository extends JpaRepository<User, Integer>, JpaSpecificationExecutor<User> {

	Boolean existsByUsername(String username);

	User findByUsername(String username);

	User findByOpenId(String openId);

	User findByAttribute_Phone(String phone);

	@RestResource(exported = false)
	void delete(Integer id);

	User findByUsernameAndCurrentRole(String username,String currentRole);


}
