package com.fypool.model;


import org.springframework.data.jpa.domain.Specification;

import javax.persistence.criteria.CriteriaBuilder;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Predicate;
import javax.persistence.criteria.Root;

public class BillSpec {
    public static Specification<Bill> getSpec(
            final Integer pay,
            final Integer id,
            final User user,
            final String month,
            final Integer send,
            final Integer type
    ) {//这里的参数也可以是多个，名字也可以随便取，只要是供下面条件判断使用

        return new Specification<Bill>() {
            @Override
            public Predicate toPredicate(Root<Bill> root, CriteriaQuery<?> query, CriteriaBuilder criteriaBuilder) {
                Predicate p1 = null;//条件初始化

                if (id != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("id"), id);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (pay != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("pay"), pay);
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


                if (month != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("month"), month);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (send != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("send"), send);
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


                //排序
                query.orderBy(criteriaBuilder.desc(root.get("createdAt")));
                return p1;
            }
        };
    }

}