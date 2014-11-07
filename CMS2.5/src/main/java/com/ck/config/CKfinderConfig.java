package com.ck.config;

import java.util.Map;

import javax.servlet.ServletConfig;
import javax.servlet.http.HttpServletRequest;

import com.ckfinder.connector.configuration.Configuration;
import com.ckfinder.connector.configuration.ConfigurationFactory;
import com.ckfinder.connector.data.ResourceType;

public class CKfinderConfig extends Configuration {

	public CKfinderConfig(ServletConfig servletConfig) {
		super(servletConfig);
	}
	
	private String userURL;
	
	public String getUserURL() {
		return userURL;
	}

	public void setUserURL(String userURL) {
		this.userURL = userURL;
	}

	@Override
	public void prepareConfigurationForRequest(HttpServletRequest request) {
		CKfinderConfig baseConfig;
		try {
			baseConfig = (CKfinderConfig)ConfigurationFactory.getInstace().getConfiguration();
			//youDir:用户所使用的目录
			String youDir = "/";
			baseConfig.setUserURL(baseConfig.baseURL + youDir);
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	@Override
	public boolean checkAuthentication(HttpServletRequest request) {
		return true;
	}

	@Override
	protected Configuration createConfigurationInstance() {
		return new CKfinderConfig(this.servletConf);
	}

	@Override
	public Map<String, ResourceType> getTypes() {
		return super.getTypes();
	}

	@Override
	public String getBaseURL() {
		return getUserURL();
	}
	
}
