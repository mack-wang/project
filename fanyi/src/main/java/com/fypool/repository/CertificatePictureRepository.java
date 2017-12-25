package com.fypool.repository;

import com.fypool.model.CertificatePicture;
import com.fypool.model.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import javax.transaction.Transactional;
import java.util.List;

/**
* Generated by Spring Data Generator on 29/09/2017
*/
@Repository
public interface CertificatePictureRepository extends JpaRepository<CertificatePicture, Integer> {
    List<CertificatePicture> findByUser(User user);
    Boolean existsByPath(String path);

    @Transactional
    List<CertificatePicture> deleteAllByUser(User user);
}
