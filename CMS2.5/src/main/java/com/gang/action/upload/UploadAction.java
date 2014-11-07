package com.gang.action.upload;

import java.io.File;

import com.gang.action.DefaultAction;
import com.gang.service.system.SystemService;

public class UploadAction extends DefaultAction {

	private String foodname;
	private Integer foodstyle;
	private Double price;

	// 接收上传文件
	private File foodimg;

	public String getFoodname() {
		return foodname;
	}

	public void setFoodname(String foodname) {
		this.foodname = foodname;
	}

	public Integer getFoodstyle() {
		return foodstyle;
	}

	public void setFoodstyle(Integer foodstyle) {
		this.foodstyle = foodstyle;
	}

	public Double getPrice() {
		return price;
	}

	public void setPrice(Double price) {
		this.price = price;
	}

	public File getFoodimg() {
		return foodimg;
	}

	public void setFoodimg(File foodimg) {
		this.foodimg = foodimg;
	}

	public String getFoodimgFileName() {
		return foodimgFileName;
	}

	public void setFoodimgFileName(String foodimgFileName) {
		this.foodimgFileName = foodimgFileName;
	}

	public String getFoodimgContentType() {
		return foodimgContentType;
	}

	public void setFoodimgContentType(String foodimgContentType) {
		this.foodimgContentType = foodimgContentType;
	}

	public String getFoodtab() {
		return foodtab;
	}

	public void setFoodtab(String foodtab) {
		this.foodtab = foodtab;
	}

	public Integer getState() {
		return state;
	}

	public void setState(Integer state) {
		this.state = state;
	}

	private String foodimgFileName;
	private String foodimgContentType;

	private String foodtab;
	private Integer state;

	private SystemService service;

	public SystemService getService() {
		return service;
	}

	public void setService(SystemService service) {
		this.service = service;
	}

	@Override
	public String execute() throws Exception {

		return SUCCESS;
	}
}
