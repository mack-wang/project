package com.fypool.manager;

import com.fypool.repository.SmsRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 29/09/2017
*/
@Component
public class SmsManager {

	@Autowired
	public SmsManager(SmsRepository smsRepository) {
		this.smsRepository = smsRepository;
	}

	private SmsRepository smsRepository;

}
