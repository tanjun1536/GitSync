package com.gang.action.section;

import java.util.Map;

import org.apache.struts2.util.StrutsTypeConverter;

public class IntegerConvert extends StrutsTypeConverter {

	@Override
	public Object convertFromString(Map arg0, String[] arg1, Class arg2) {
		String value = arg1[0];
		try {
			return Integer.parseInt(value);
		} catch (NumberFormatException e) {
			e.printStackTrace();
			return 0;
		}
	}

	@Override
	public String convertToString(Map arg0, Object arg1) {
		if(arg1 == null)
			return "";
		return arg1.toString();
	}



}
