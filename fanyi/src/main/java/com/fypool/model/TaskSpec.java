package com.fypool.model;


import javax.persistence.criteria.*;

import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;

import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class TaskSpec {
    public static Specification<Task> getSpec(
            final Integer off,
            final Date taskEndTime,
            final Integer emergency,
            final String title,
            final Integer type,
            final User user,
            final LanguageGroup languageGroup,
            final List<SkilledField> fields,
            final List<SkilledUsage> usages,
            final Quality quality,
            final Integer process,
            final String translateEndTime,
            final String startTime,
            final String totalWords,
            final Integer top
    ) {//这里的参数也可以是多个，名字也可以随便取，只要是供下面条件判断使用

        return new Specification<Task>() {
            @Override
            public Predicate toPredicate(Root<Task> root, CriteriaQuery<?> query, CriteriaBuilder criteriaBuilder) {
                Predicate p1 = null;//条件初始化

                //根据off来筛选
                if (off != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get(Task_.off), off);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }


                if (taskEndTime != null) {

                    Predicate p2 = criteriaBuilder.greaterThan(root.get(Task_.taskEndTime), taskEndTime);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //紧急程度筛选
                if (emergency != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get(Task_.emergency), emergency);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //标题
                if (title != null) {
                    Predicate p2 = criteriaBuilder.like(root.get(Task_.title), "%" + title + "%");
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //翻译类型
                if (type != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get(Task_.type), type);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //查找本人的任务
                if (user != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get(Task_.user), user);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //相应翻译语言的任务
                if (languageGroup != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get(Task_.languageGroup), languageGroup);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //擅长领域
                if (fields.size()>0) {
                    Predicate p2 = root.get("field").in(fields);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //擅长用途
                if (usages.size()>0) {
                    Predicate p2 = root.get("usage").in(usages);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //擅长用途
                if (quality!=null) {
                    Predicate p2 = criteriaBuilder.equal(root.get(Task_.quality), quality);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //擅长用途
                if (process!=null) {
                    Predicate p2 = criteriaBuilder.equal(root.join("process").get("process"), process);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //排序
                List<Order> orders = new ArrayList<>();
                //置顶排序

                if(top!=null){
                    orders.add(criteriaBuilder.desc(root.get("top")));
                }

                if(translateEndTime!=null){
                    if(translateEndTime.equals("DESC")){
                        orders.add(criteriaBuilder.desc(root.get("translateEndTime")));
                    }else{
                        orders.add(criteriaBuilder.asc(root.get("translateEndTime")));
                    }
                    //同时还要限制在笔译
                    Predicate p2 = criteriaBuilder.equal(root.get("type"), 1);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if(startTime!=null){
                    if(startTime.equals("DESC")){
                        orders.add(criteriaBuilder.desc(root.join("interpret").get("startTime")));
                    }else{
                        orders.add(criteriaBuilder.asc(root.join("interpret").get("startTime")));
                    }
                }

                if(totalWords!=null){
                    if(totalWords.equals("DESC")){
                        orders.add(criteriaBuilder.desc(root.get("totalWords")));
                    }else{
                        orders.add(criteriaBuilder.asc(root.get("totalWords")));
                    }
                    //同时还要限制在笔译
                    Predicate p2 = criteriaBuilder.equal(root.get("type"), 1);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //若没有其他的排序规则，则按置顶和创建时间先后来排序
                orders.add(criteriaBuilder.desc(root.get("createdAt")));

                query.orderBy(orders);
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