package com.fypool.model;


import org.springframework.data.jpa.domain.Specification;

import javax.persistence.criteria.*;
import java.util.ArrayList;
import java.util.List;

public class VipTaskSpec {
    public static Specification<VipTask> getSpec(
            final Integer off,
            final User user,
            final String title,
            final Bill bill,
            final Integer type,
            final Integer id
    ) {//这里的参数也可以是多个，名字也可以随便取，只要是供下面条件判断使用

        return new Specification<VipTask>() {
            @Override
            public Predicate toPredicate(Root<VipTask> root, CriteriaQuery<?> query, CriteriaBuilder criteriaBuilder) {
                Predicate p1 = null;//条件初始化

                if (off != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("off"), off);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (user != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("user"), user);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (title != null) {
                    Predicate p2 = criteriaBuilder.like(root.get("title"), "%"+title+"%");
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (bill != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("bill"), bill);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (type != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("type"), type);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }
                if (id != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("id"), id);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //排序
                query.orderBy(criteriaBuilder.desc(root.get("createdAt")));
                return p1;
            }
        };
    }

}