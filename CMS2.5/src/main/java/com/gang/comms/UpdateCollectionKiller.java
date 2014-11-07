package com.gang.comms;

import org.hibernate.Session;

import java.io.Serializable;

import java.lang.reflect.InvocationTargetException;


public interface UpdateCollectionKiller
{
	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public void execute(
	  Session      session,
	  Class        clazz,
	  Serializable serializable)
		throws SecurityException,
			NoSuchMethodException,
			IllegalArgumentException,
			IllegalAccessException,
			InvocationTargetException;
}
