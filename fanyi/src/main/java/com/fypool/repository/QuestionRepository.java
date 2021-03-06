package com.fypool.repository;

import com.fypool.model.Question;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;



/**
* Generated by Spring Data Generator on 28/10/2017
*/
@Repository
public interface QuestionRepository extends JpaRepository<Question, Integer> {
    Page<Question> findAll(Pageable pageable);

    Page<Question> findAllByResult(Integer result,Pageable pageable);

    Question findByIdAndResult(Integer id,Integer result);
}
