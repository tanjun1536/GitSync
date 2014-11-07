package com.gang.action.screen;

import java.util.Date;

import com.gang.action.BaseAction;
import com.gang.action.DefaultAction;
import com.gang.comms.JSONHelper;
import com.gang.entity.screen.Picture;
import com.gang.service.screen.PictureService;

public class PictureAction extends DefaultAction{

	private PictureService service;
	private Picture picture;
	public Picture getPicture() {
		return picture;
	}

	public void setPicture(Picture picture) {
		this.picture = picture;
	}

	public void setService(PictureService service) {
		this.service = service;
	}

	
	public void getMobileNew() throws Exception {
		Write(JSONHelper.SerializeWithNeedAnnotationNone(service.getNew(1)));
	}
	
	public void getPadNew() throws Exception {
		Write(JSONHelper.SerializeWithNeedAnnotationNone(service.getNew(2)));
	}
	
	public void saveMobile() throws Exception{
		picture.setDate(new Date());
		picture.setType(1);
		service.save(picture);
		Write("1");
	}
	public void savePad() throws Exception{
		picture.setDate(new Date());
		picture.setType(2);
		service.save(picture);
		Write("1");
	}


}
