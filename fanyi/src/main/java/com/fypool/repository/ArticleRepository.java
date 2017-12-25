package com.fypool.repository;

import com.fypool.model.Article;
import com.fypool.model.Catalog;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.stereotype.Repository;

import javax.transaction.Transactional;
import java.util.List;

/**
* Generated by Spring Data Generator on 31/10/2017
*/
@Repository
public interface ArticleRepository extends JpaRepository<Article, Integer> , JpaSpecificationExecutor<Article> {
    List<Article> findAllByCatalog(Catalog catalog);

    List<Article> findTop10ByTitleLike(String title);

    @Transactional
    void deleteAllByCatalog(Catalog catalog);
}