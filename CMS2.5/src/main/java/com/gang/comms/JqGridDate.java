package com.gang.comms;

import java.text.SimpleDateFormat;
import java.util.Date;

public class JqGridDate extends Date{

	@Override
	public String toString() {
		// TODO Auto-generated method stub
		SimpleDateFormat sdf=new SimpleDateFormat("yyyy-MM-dd");
		return sdf.format(this);
	}
	
}
