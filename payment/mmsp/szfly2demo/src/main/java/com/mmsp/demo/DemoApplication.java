package com.mmsp.demo;

import java.io.IOException;

import javax.servlet.Filter;
import javax.servlet.http.HttpServletResponse;

import org.apache.catalina.filters.RequestDumperFilter;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.context.properties.EnableConfigurationProperties;
import org.springframework.boot.web.servlet.FilterRegistrationBean;
import org.springframework.context.annotation.Bean;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.mmsp.demo.bean.MmspConfigBean;

@SpringBootApplication
@RestController
@RequestMapping("/")
@EnableConfigurationProperties({MmspConfigBean.class})
public class DemoApplication {

	public static void main(String[] args) {
		SpringApplication.run(DemoApplication.class, args);
	}
	
	  @RequestMapping("/")
	  void handleFoo(HttpServletResponse response) throws IOException {
	    response.sendRedirect("/swagger-ui.html");
	  }
	  
	  /*
	  @Bean
	  public FilterRegistrationBean requestDumperFilter() {
	      FilterRegistrationBean registration = new FilterRegistrationBean();
	      Filter requestDumperFilter = new RequestDumperFilter();
	      registration.setFilter(requestDumperFilter);
	      registration.addUrlPatterns("/*");
	      return registration;
	  }
	  */
	
}
