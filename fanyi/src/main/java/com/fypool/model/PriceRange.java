package com.fypool.model;


import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;

import javax.persistence.*;
import java.io.Serializable;
import java.math.BigDecimal;

@Entity
@Data
@NoArgsConstructor
public class PriceRange implements Serializable { //1

    private static final long serialVersionUID = 1L;

    //价格区间
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;

    //价格区间
    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal start;

    @Column(columnDefinition = "decimal(12,2)")
    private BigDecimal end;

}
