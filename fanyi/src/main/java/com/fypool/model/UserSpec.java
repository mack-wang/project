package com.fypool.model;


import org.springframework.data.jpa.domain.Specification;

import javax.persistence.criteria.*;
import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class UserSpec {
    public static Specification<User> getSpec(
            final String currentRole,
            final String username,
            final String email,
            final String nickname,
            final String phone,
            final String createdAt,
            final String money,
            final String score,
            final String words,
            final String taskDone,
            final Boolean vip
    ) {//这里的参数也可以是多个，名字也可以随便取，只要是供下面条件判断使用


        return new Specification<User>() {
            @Override
            public Predicate toPredicate(Root<User> root, CriteriaQuery<?> query, CriteriaBuilder criteriaBuilder) {
                Predicate p1 = null;//条件初始化

                //用户角色
                if (currentRole != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("currentRole"), currentRole);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (vip) {
                    Predicate p2 = criteriaBuilder.isNotNull(root.join("vip").get("id"));
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                //用户名
                if (username != null) {
                    Predicate p2 = criteriaBuilder.equal(root.get("username"), username);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (email != null) {
                    Predicate p2 = criteriaBuilder.equal(root.join("attribute").get("email"), email);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (nickname != null) {
                    Predicate p2 = criteriaBuilder.equal(root.join("attribute").get("nickname"), nickname);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }

                if (phone != null) {
                    Predicate p2 = criteriaBuilder.equal(root.join("attribute").get("phone"), phone);
                    if (p1 != null) {
                        p1 = criteriaBuilder.and(p1, p2);
                    } else {
                        p1 = p2;
                    }
                }



                //排序
                List<Order> orders = new ArrayList<>();
                if(createdAt!=null){
                    if(createdAt.equals("DESC")){
                        orders.add(criteriaBuilder.desc(root.get("createdAt")));
                    }else{
                        orders.add(criteriaBuilder.asc(root.get("createdAt")));
                    }
                }else{
                    orders.add(criteriaBuilder.desc(root.get("createdAt")));
                }

                if(money!=null){
                    if(money.equals("DESC")){
                        orders.add(criteriaBuilder.desc(root.join("account").get("money")));
                    }else{
                        orders.add(criteriaBuilder.asc(root.join("account").get("money")));
                    }
                }

                if(score!=null){
                    if(score.equals("DESC")){
                        orders.add(criteriaBuilder.desc(root.join("attribute").get("score")));
                    }else{
                        orders.add(criteriaBuilder.asc(root.join("attribute").get("score")));
                    }
                }

                if(words!=null){
                    if(words.equals("DESC")){
                        orders.add(criteriaBuilder.desc(root.join("attribute").get("words")));
                    }else{
                        orders.add(criteriaBuilder.asc(root.join("attribute").get("words")));
                    }
                }

                if(taskDone!=null){
                    if(taskDone.equals("DESC")){
                        orders.add(criteriaBuilder.desc(root.join("attribute").get("taskDone")));
                    }else{
                        orders.add(criteriaBuilder.asc(root.join("attribute").get("taskDone")));
                    }
                }

                query.orderBy(orders);
                return p1;//返回条件
            }
        };
    }

}