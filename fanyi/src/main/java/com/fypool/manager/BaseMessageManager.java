package com.fypool.manager;

import com.fypool.repository.BaseMessageRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 20/10/2017
*/
@Component
public class BaseMessageManager {

	@Autowired
	public BaseMessageManager(BaseMessageRepository baseMessageRepository) {
		this.baseMessageRepository = baseMessageRepository;
	}

	private BaseMessageRepository baseMessageRepository;

}
