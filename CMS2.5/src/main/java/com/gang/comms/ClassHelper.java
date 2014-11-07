package com.gang.comms;

public class ClassHelper
{
	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public static Boolean isEqual(
	  Class o,
	  Class t)
	{
		return o.getName ()
		        .equals (t.getName ());
	}
}
