package com.fypool.manager;

import com.fypool.repository.IllegalRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 23/10/2017
*/
@Component
public class IllegalManager {

	@Autowired
	public IllegalManager(IllegalRepository illegalRepository) {
		this.illegalRepository = illegalRepository;
	}

	private IllegalRepository illegalRepository;

}
