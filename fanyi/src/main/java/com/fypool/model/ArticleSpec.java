package com.fypool.model;


import org.springframework.data.jpa.domain.Specification;

import javax.persistence.criteria.*;
import java.util.ArrayList;
import java.util.List;

public class ArticleSpec {
    public static Specification<Article> getSpec(
            final Catalog catalog,
            final String title,
            final Integer off,
            final Integer top
    ) {//这里的参数也可以是多个，名字也可以随便取，只要是供下面条件判断使用

        return new Specification<Article>() {
            @Override
            public Predicate toPredicate(Root<Article> root, CriteriaQuery<?> query, CriteriaBuilder criteriaBuilder) {
                Predicate p1 = null;//条件初始化
                if (catalog != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("catalog"), catalog);
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

                if (off != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("off"), off);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //排序
                List<Order> orders = new ArrayList<>();

                //如果有置顶，则置顶最优先，然后才是按创建时间
                if(top!=null){
                    orders.add(criteriaBuilder.desc(root.get("top")));
                }

                //按创建的时间顺序排序
                orders.add(criteriaBuilder.desc(root.get("createdAt")));

                query.orderBy(orders);

                return p1;//返回条件
            }
        };
    }

}