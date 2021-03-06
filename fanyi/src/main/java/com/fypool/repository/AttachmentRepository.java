package com.fypool.repository;

import com.fypool.model.Attachment;
import com.fypool.model.Process;
import com.fypool.model.Task;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

/**
* Generated by Spring Data Generator on 11/10/2017
*/
@Repository
public interface AttachmentRepository extends JpaRepository<Attachment, Integer> {
    List<Attachment> findAllByTask(Task task);
    List<Attachment> findAllByProcess(Process process);
    Integer countByTask(Task task);
    Boolean existsByPath(String path);
}
