package com.fypool.repository;

import com.fypool.model.Role;
import org.springframework.data.jpa.repository.JpaRepository;


public interface RoleRepository extends JpaRepository<Role, Integer>{
	Role findByName(String roleName);
}
