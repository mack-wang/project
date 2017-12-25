package com.fypool.repository;

import com.fypool.model.User;
import com.fypool.model.UserInfo;
import org.springframework.data.jpa.repository.JpaRepository;


public interface UserInfoRepository extends JpaRepository<UserInfo, Integer>{
    UserInfo findByUser(User user);
}

