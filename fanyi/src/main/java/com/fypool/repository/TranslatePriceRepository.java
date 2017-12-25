package com.fypool.repository;

import com.fypool.model.TranslatePrice;
import com.fypool.model.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import javax.transaction.Transactional;
import java.util.List;

/**
* Generated by Spring Data Generator on 29/09/2017
*/
@Repository
public interface TranslatePriceRepository extends JpaRepository<TranslatePrice, Integer> {
    List<TranslatePrice> findByUser(User user);

    @Transactional
    List<TranslatePrice> deleteAllByUser(User user);
}
