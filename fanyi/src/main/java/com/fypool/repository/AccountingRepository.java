package com.fypool.repository;

import com.fypool.model.Accounting;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

/**
* Generated by Spring Data Generator on 12/10/2017
*/
@Repository
public interface AccountingRepository extends JpaRepository<Accounting, Integer> {
    Accounting findByShortName(String shortName);
}
