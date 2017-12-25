package com.fypool.repository;

import com.fypool.model.Languages;
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;


public interface LanguagesRepository extends JpaRepository<Languages, Integer>{
    List<Languages> findAll();
}

