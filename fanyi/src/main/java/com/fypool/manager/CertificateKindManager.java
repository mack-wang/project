package com.fypool.manager;

import com.fypool.repository.CertificateKindRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 29/09/2017
*/
@Component
public class CertificateKindManager {

	@Autowired
	public CertificateKindManager(CertificateKindRepository certificateKindRepository) {
		this.certificateKindRepository = certificateKindRepository;
	}

	private CertificateKindRepository certificateKindRepository;

}