package com.fypool.model;


import org.springframework.data.jpa.domain.Specification;

import javax.persistence.criteria.*;
import java.util.ArrayList;
import java.util.List;

public class AdminCheckCertificteSpec {
    public static Specification<AdminCheckCertificate> getSpec(
            final User user,
            final Integer realName,
            final Integer certificate,
            final Integer company
    ) {//这里的参数也可以是多个，名字也可以随便取，只要是供下面条件判断使用


        return new Specification<AdminCheckCertificate>() {
            @Override
            public Predicate toPredicate(Root<AdminCheckCertificate> root, CriteriaQuery<?> query, CriteriaBuilder criteriaBuilder) {
                Predicate p1 = null;//条件初始化
                if (user != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("user"), user);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (realName != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("realNameCheck"), realName);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (certificate != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("certificateCheck"), certificate);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (company != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("companyCheck"), company);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                query.orderBy(criteriaBuilder.desc(root.get("createdAt")));

                return p1;//返回条件
            }
        };
    }

}