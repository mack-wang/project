package com.fypool.repository;

import com.fypool.model.Account;
import com.fypool.model.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

/**
* Generated by Spring Data Generator on 11/10/2017
*/
@Repository
public interface AccountRepository extends JpaRepository<Account, Integer> {
    Account findByUser(User user);
}
