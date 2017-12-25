package com.fypool.model;


import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Data;
import lombok.NoArgsConstructor;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;

import javax.persistence.*;
import javax.validation.constraints.NotNull;
import java.io.Serializable;
import java.math.BigDecimal;
import java.util.Date;
import java.util.List;

@Data
@NoArgsConstructor
public class FileJson implements Serializable { //1
    private static final long serialVersionUID = 1L;

    private Integer errno;

    private List<String> data;

    public FileJson(Integer errno, List<String> data) {
        this.errno = errno;
        this.data = data;
    }
}
