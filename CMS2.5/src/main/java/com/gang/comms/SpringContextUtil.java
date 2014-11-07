package com.gang.comms;

import org.springframework.beans.BeansException;
import org.springframework.context.ApplicationContext;
import org.springframework.context.ApplicationContextAware;

public class SpringContextUtil implements ApplicationContextAware {
	
	private static ApplicationContext applicationContext;
	public static Object getBean(String beanName){
		return applicationContext.getBean(beanName);
	}

	public void setApplicationContext(ApplicationContext applicationContext)
			throws BeansException {
		SpringContextUtil.applicationContext=applicationContext;
	}

	public static ApplicationContext getApplicationContext() {
		return applicationContext;
	}
}