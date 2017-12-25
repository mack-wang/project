package com.fypool.repository;

import com.fypool.model.MhCity;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.repository.query.Param;
import org.springframework.data.rest.core.annotation.RestResource;

import java.util.List;


public interface MhCityRepository extends JpaRepository<MhCity, Integer>{
    @RestResource(path="pid",rel="pid")
    List<MhCity> findByPid(@Param("pid") Integer pid);

    @RestResource(path="level",rel="level")
    List<MhCity> findByLevel(@Param("level") Integer level);

}
