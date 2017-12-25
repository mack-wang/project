package com.fypool.model;


import org.springframework.data.jpa.domain.Specification;

import javax.persistence.criteria.*;
import java.util.ArrayList;
import java.util.List;

public class BalanceSpec {
    public static Specification<Balance> getSpec(
            final Accounting accounting,
            final String title,
            final Integer type,
            final User user
    ) {//这里的参数也可以是多个，名字也可以随便取，只要是供下面条件判断使用

        return new Specification<Balance>() {
            @Override
            public Predicate toPredicate(Root<Balance> root, CriteriaQuery<?> query, CriteriaBuilder criteriaBuilder) {
                Predicate p1 = null;//条件初始化
                if (accounting != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("accounting"), accounting);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (title != null) {
                    Predicate p2 = criteriaBuilder.like(root.join("task").get("title"), "%"+title+"%");
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

                if (user != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("user"), user);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //排序
                query.orderBy(criteriaBuilder.desc(root.get("createdAt")));

                return p1;//返回条件
            }
        };
    }

}