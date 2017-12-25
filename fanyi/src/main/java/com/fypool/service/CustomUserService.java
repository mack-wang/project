package com.fypool.service;

import com.fypool.model.User;
import com.fypool.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.annotation.Bean;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.context.request.ServletRequestAttributes;

import javax.servlet.http.HttpSession;
import java.util.HashMap;
import java.util.Map;

public class CustomUserService implements UserDetailsService { //1
	@Autowired
	UserRepository userRepository;

	@Override
	public UserDetails loadUserByUsername(String username) { //2

		User user = userRepository.findByUsername(username);
		if(user == null){
			throw new UsernameNotFoundException("用户名不存在");
		}else{
			//在用户成功登入时，把用户信息保存到session
			ServletRequestAttributes attrs = (ServletRequestAttributes) RequestContextHolder
					.getRequestAttributes();
			HttpSession session = attrs.getRequest().getSession();
			session.setAttribute("user",user);
		}

		return user; //3
	}

	@Bean
	public void changeUserPassword(User user, String password) {
		user.setPassword(new BCryptPasswordEncoder().encode(password));
		userRepository.save(user);
	}

}
