package com.fypool.manager;

import com.fypool.repository.AttachmentRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 11/10/2017
*/
@Component
public class AttachmentManager {

	@Autowired
	public AttachmentManager(AttachmentRepository attachmentRepository) {
		this.attachmentRepository = attachmentRepository;
	}

	private AttachmentRepository attachmentRepository;

}
