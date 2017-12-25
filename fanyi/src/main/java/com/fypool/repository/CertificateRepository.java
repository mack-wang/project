package com.fypool.repository;

import com.fypool.model.Certificate;
import com.fypool.model.User;
import org.springframework.data.jpa.repository.JpaRepository;


public interface CertificateRepository extends JpaRepository<Certificate, Integer>{
    Certificate findByUser(User user);
    Boolean existsByIdCardBackOrIdCardFront(String idCardBack,String idCardFront);
}

