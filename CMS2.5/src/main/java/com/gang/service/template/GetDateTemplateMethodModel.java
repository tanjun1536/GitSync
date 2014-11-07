package com.gang.service.template;

import java.text.ParseException;
import java.util.Date;
import java.util.List;

import com.gang.comms.DateHelper;

import freemarker.template.TemplateMethodModel;
import freemarker.template.TemplateModelException;

public class GetDateTemplateMethodModel implements TemplateMethodModel {

	@SuppressWarnings("deprecation")
	@Override
	public Object exec(@SuppressWarnings("rawtypes") List list) throws TemplateModelException {
		Date d=null;
		try {
			d = DateHelper.getDate(list.get(0).toString(), null);
			if(d!=null) return DateHelper.getDate(d, "yyyy-MM-dd,HH:mm");
		} catch (ParseException e) {
		}
		
		return "";
	}
}
