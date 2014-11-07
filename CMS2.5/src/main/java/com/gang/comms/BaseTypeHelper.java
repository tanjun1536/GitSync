package com.gang.comms;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

public class BaseTypeHelper {
	public static Integer getInteger(String s) {
		Integer ret = 0;
		try {
			ret = Integer.parseInt(s);
		} catch (NumberFormatException e) {
		}
		return ret;
	}

	public static Date getDate(String s) {
		try {
			DateFormat df = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
			Date date = df.parse(s);
			return date;
		} catch (Exception e) {
			return null;
		}

	}
}
