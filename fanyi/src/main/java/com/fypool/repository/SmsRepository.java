package com.fypool.repository;

import com.fypool.model.Sms;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.rest.core.annotation.RestResource;

import java.util.List;

public interface SmsRepository extends JpaRepository<Sms, Integer>{
//    @RestResource(exported = false)
//    void delete(Integer id);

    @RestResource(exported = false)
    Sms save(Sms sms);

    @RestResource(exported = false)
    List<Sms> save(List<Sms> sms);

    Sms findFirstByPhoneOrderByIdDesc(String phone);
}

