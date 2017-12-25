package com.fypool.model;


import org.springframework.data.jpa.domain.Specification;

import javax.persistence.criteria.*;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class TaskUserSpec {
    public static Specification<TaskUser> getSpec(
            final Integer process,
            final Integer type,
            final User user
    ) {//这里的参数也可以是多个，名字也可以随便取，只要是供下面条件判断使用

        return new Specification<TaskUser>() {
            @Override
            public Predicate toPredicate(Root<TaskUser> root, CriteriaQuery<?> query, CriteriaBuilder criteriaBuilder) {
                Predicate p1 = null;//条件初始化

                //根据process来筛选
                if (process != null) {
                    Predicate p2 = criteriaBuilder.equal(root.join("task").join("process").get("process"), process);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (type != null) {
                    Predicate p2 = criteriaBuilder.equal(root.join("task").get("type"), type);
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

                return p1;//返回条件
            }
        };
    }

}