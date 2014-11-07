package com.gang.comms;

import org.hibernate.Session;

import java.io.Serializable;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

import java.util.ArrayList;
import java.util.Collection;
import java.util.List;


public class HibernateUpdateCollectionKiller
  implements UpdateCollectionKiller
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private List<String> properties = new ArrayList<String>();

	//~ Constructors ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public HibernateUpdateCollectionKiller(String... collectionProperties)
	{
		for (String property : collectionProperties)
		{
			properties.add (property);
		}
	}

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public HibernateUpdateCollectionKiller addCollectionProperty(String property)
	{
		properties.add (property);

		return this;
	}

	@Override
	public void execute(
	  Session      session,
	  Class        clazz,
	  Serializable serializable)
	{
		Object entity = session.get (clazz, serializable);

		if (entity != null)
		{
			for (String property : properties)
			{
				try
				{
					Method m = clazz.getMethod (property);

					if (m != null)
					{
						Collection list = (Collection) m.invoke (entity);

						if (list != null)
						{
							list.clear ();
						}
					}
				}
				catch (Exception e)
				{
					continue;
				}
			}

			session.flush ();
			session.evict (entity);
		}
	}
}
