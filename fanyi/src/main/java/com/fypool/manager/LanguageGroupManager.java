package com.fypool.manager;

import com.fypool.repository.LanguageGroupRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 06/10/2017
*/
@Component
public class LanguageGroupManager {

	@Autowired
	public LanguageGroupManager(LanguageGroupRepository languageGroupRepository) {
		this.languageGroupRepository = languageGroupRepository;
	}

	private LanguageGroupRepository languageGroupRepository;

}
