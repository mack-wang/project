package com.fypool.model;


import org.springframework.data.jpa.domain.Specification;

import javax.persistence.criteria.CriteriaBuilder;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Predicate;
import javax.persistence.criteria.Root;
import java.math.BigDecimal;
import java.util.Date;
import java.util.List;

public class ProcessSpec {
    public static Specification<Process> getSpec(
            final User user,
            final Integer  process
    ) {//这里的参数也可以是多个，名字也可以随便取，只要是供下面条件判断使用


        return new Specification<Process>() {
            @Override
            public Predicate toPredicate(Root<Process> root, CriteriaQuery<?> query, CriteriaBuilder criteriaBuilder) {
                Predicate p1 = null;//条件初始化

                //根据off来筛选
                if (user != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("user"), user);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (process != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("process"), process);
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

//Predicate 条件 Root获取表和字段 Path<String> 获取后的占位  CriteriaBuilder 创建条件 执行条件
//and 执行条件的and结果  or 执行条件的or结果

// query = cb.createQuery(User.class);// query是这么出来的
//                List<Predicate> predicateList = new ArrayList<>();//
//                root = query.from(User.class);
//                Path<String> nameExp = root.get("name");
//                Predicate p1 = cb.like(nameExp, "%icarus%");
//                Path<String> phoneExp = root.get("phone");
//                Predicate p2 = cb.like(phoneExp, "%188%");
//                predicateList.add(p1);
//                predicateList.add(p2);
//                return cb.or(predicateList.toArray(new Predicate[predicates.size()]));