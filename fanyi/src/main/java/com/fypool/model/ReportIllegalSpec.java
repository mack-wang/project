package com.fypool.model;


import org.springframework.data.jpa.domain.Specification;

import javax.persistence.criteria.*;
import java.util.ArrayList;
import java.util.List;

public class ReportIllegalSpec {
    public static Specification<ReportIllegal> getSpec(
            final User reportUser,
            final User taskUser,
            final String title
    ) {//这里的参数也可以是多个，名字也可以随便取，只要是供下面条件判断使用

        return new Specification<ReportIllegal>() {
            @Override
            public Predicate toPredicate(Root<ReportIllegal> root, CriteriaQuery<?> query, CriteriaBuilder criteriaBuilder) {
                Predicate p1 = null;//条件初始化
                if (reportUser != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("user"), reportUser);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (taskUser != null) {
                    Predicate p2 = criteriaBuilder.equal(root.join("task").get("user"), taskUser);
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

                //让未处理的永远在最上面
                query.orderBy(criteriaBuilder.asc(root.get("result")));

                return p1;//返回条件
            }
        };
    }

}