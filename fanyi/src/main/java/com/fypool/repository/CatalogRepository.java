package com.fypool.repository;

import com.fypool.model.Catalog;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

/**
* Generated by Spring Data Generator on 31/10/2017
*/
@Repository
public interface CatalogRepository extends JpaRepository<Catalog, Integer> {
        List<Catalog> findAllByOffEqualsOrderByTopDesc(Integer off);
}
