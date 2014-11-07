package com.gang.service.template;

import java.io.File;
import java.util.List;
import freemarker.template.TemplateMethodModel;
import freemarker.template.TemplateModelException;
public class GetFileNameTemplateMethodModel implements TemplateMethodModel {

	@Override
	public Object exec(List list) throws TemplateModelException {
		// TODO Auto-generated method stub
		String fileName=list.get(0).toString();
		File f=new File(fileName);
		return f.getName();
	}

}
