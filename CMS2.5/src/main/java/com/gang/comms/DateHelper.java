package com.gang.comms;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class DateHelper {
	public static String getDate(String pattern)
	{
		return getDate(new Date(),pattern);
	}
	public static String getDate(Date date,String pattern)
	{
		if(date==null) return null;
		SimpleDateFormat sdf=new SimpleDateFormat(pattern);
		return sdf.format(date);
	}
	public static String getDate(Date date)
	{
		return getDate(date,"yyyy-MM-dd HH:mm:ss");
	}
	
	public static Date getDate(String date,String pattern) throws ParseException
	{
		if(pattern==null)pattern="yyyy-MM-dd HH:mm:ss";
		SimpleDateFormat sdf=new SimpleDateFormat(pattern);
		return sdf.parse(date);
	}
}
