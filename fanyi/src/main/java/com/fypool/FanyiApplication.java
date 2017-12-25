package com.fypool;

import com.cmeza.sdgenerator.annotation.SDGenerator;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fypool.config.AuthenticationSuccessEventListener;
import com.fypool.modules.unionpay.util.SDKConfig;
import com.fypool.modules.weixinpay.util.ConfigUtil;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.data.jpa.repository.config.EnableJpaAuditing;
import org.springframework.scheduling.annotation.EnableScheduling;
import org.springframework.web.socket.config.annotation.EnableWebSocket;

@SDGenerator(
		entityPackage = "com.fypool.model",
		repositoryPackage = "com.fypool.repository",
		managerPackage = "com.fypool.manager",
		repositoryPostfix = "Repository",
		managerPostfix = "Manager",
		onlyAnnotations = false,
		debug = false,
		overwrite = false
)

@SpringBootApplication
@EnableJpaAuditing
@EnableWebSocket
@EnableScheduling
public class FanyiApplication {

	@Bean
	public ObjectMapper ObjectMapper(){
		ObjectMapper objectMapper=new ObjectMapper();
		return objectMapper;
	}

	public static void main(String[] args) {
		SpringApplication app = new SpringApplication(FanyiApplication.class);
		app.addListeners(new AuthenticationSuccessEventListener());
		//载入微信支付的设置
		ConfigUtil.init("wxinfo.properties");

		//载入银联的设置
		SDKConfig.getConfig().loadPropertiesFromSrc();

		app.run(args);
	}
}
