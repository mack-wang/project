package com.fypool.manager;

import com.fypool.repository.BalanceRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 12/10/2017
*/
@Component
public class BalanceManager {

	@Autowired
	public BalanceManager(BalanceRepository balanceRepository) {
		this.balanceRepository = balanceRepository;
	}

	private BalanceRepository balanceRepository;

}
