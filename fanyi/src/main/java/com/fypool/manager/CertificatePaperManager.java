package com.fypool.manager;

import com.fypool.repository.CertificatePaperRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

/**
* Generated by Spring Data Generator on 29/09/2017
*/
@Component
public class CertificatePaperManager {

	@Autowired
	public CertificatePaperManager(CertificatePaperRepository certificatePaperRepository) {
		this.certificatePaperRepository = certificatePaperRepository;
	}

	private CertificatePaperRepository certificatePaperRepository;

}