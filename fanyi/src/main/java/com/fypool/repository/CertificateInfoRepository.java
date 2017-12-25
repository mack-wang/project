package com.fypool.repository;

import com.fypool.model.Certificate;
import com.fypool.model.CertificateInfo;
import com.fypool.model.User;
import org.springframework.data.jpa.repository.JpaRepository;

import javax.transaction.Transactional;


public interface CertificateInfoRepository extends JpaRepository<CertificateInfo, Integer>{
    CertificateInfo findByUser(User user);

}

