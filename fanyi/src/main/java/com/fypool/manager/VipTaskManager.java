package com.fypool.manager;

import com.fypool.repository.VipTaskRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 02/11/2017
*/
@Component
public class VipTaskManager {

	@Autowired
	public VipTaskManager(VipTaskRepository vipTaskRepository) {
		this.vipTaskRepository = vipTaskRepository;
	}

	private VipTaskRepository vipTaskRepository;

}