package com.fypool.repository;

import com.fypool.model.Attribute;
import org.springframework.data.jpa.repository.JpaRepository;


public interface AttributeRepository extends JpaRepository<Attribute, Integer>{
    Attribute findByNickname(String nickname);
    Attribute findByPhone(String phone);
    Attribute findByEmail(String email);
    Attribute findByUser_Id(Integer id);
    Boolean existsByAvatar(String Avatar);
    Boolean existsByEmail(String Email);
    Boolean existsByPhone(String phone);
}

