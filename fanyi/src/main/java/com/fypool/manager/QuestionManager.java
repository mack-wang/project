package com.fypool.manager;

import com.fypool.repository.QuestionRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 28/10/2017
*/
@Component
public class QuestionManager {

	@Autowired
	public QuestionManager(QuestionRepository questionRepository) {
		this.questionRepository = questionRepository;
	}

	private QuestionRepository questionRepository;

}