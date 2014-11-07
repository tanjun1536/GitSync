package com.gang.comms;

import java.lang.reflect.Field;

public class SetValue {
	
	static public boolean setValue(Object target, String field, Object value){
		try {
			Field f = null;
			if("id".equals(field)){
				f = target.getClass().getSuperclass().getDeclaredField(field);
			}
			else{
				f = target.getClass().getDeclaredField(field);
			}
			
			f.setAccessible(true);
			f.set(target, value);
			return true;
		} catch (Exception e) {
			e.printStackTrace();
			return false;
		} 
	}
}
