package com.fypool.repository;

import com.fypool.model.Process;
import com.fypool.model.Task;
import com.fypool.model.User;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.stereotype.Repository;

/**
* Generated by Spring Data Generator on 23/10/2017
*/
@Repository
public interface ProcessRepository extends JpaRepository<Process, Integer> , JpaSpecificationExecutor<Process> {
    Process findByTask(Task task);
    Process findByTaskAndUser(Task task,User user);
    Page<Process> findAllByUserAndProcess(User user, Integer process, Pageable pageable);
    Integer countAllByUserAndProcess(User user,Integer process);
    Boolean existsByAttachment(String attachment);
}