package com.fypool.manager;

import com.fypool.repository.VipPriceRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 01/11/2017
*/
@Component
public class VipPriceManager {

	@Autowired
	public VipPriceManager(VipPriceRepository vipPriceRepository) {
		this.vipPriceRepository = vipPriceRepository;
	}

	private VipPriceRepository vipPriceRepository;

}