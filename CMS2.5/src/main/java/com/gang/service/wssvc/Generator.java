package com.gang.service.wssvc;

public class Generator
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String key;
	private Object value;
	private boolean quote = true;

	//~ Constructors ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public Generator(
	  String key,
	  Object value)
	{
		super();
		this.key     = key;
		this.value   = value;
	}

	public Generator(
	  String  key,
	  Object  value,
	  boolean quote)
	{
		super();
		this.key     = key;
		this.value   = value;
		this.quote   = quote;
	}

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getKey()
	{
		return key;
	}

	public Object getValue()
	{
		return value;
	}

	public String quote(Object o)
	{
		if (o == null)
		{
			return "\"\"";
		}

		String r = o.toString ();
		r = r.replace ("\"", "”")
			   .replace ("\r\n", "\\r\\n");
		
		return "\"" + r + "\"";
	}

	public void setKey(String key)
	{
		this.key = key;
	}

	public void setValue(String value)
	{
		this.value = value;
	}

	@Override
	public String toString()
	{
		return quote (this.key) + ":" + prase (this.value);
	}

	private String prase(Object v)
	{
		if (v instanceof JSONGenerator)
		{
			return v.toString ();
		}
		else if (v instanceof JSONArrayGenerator)
		{
			return v.toString ();
		}
		else if(quote)
		{
			return quote (v);
		}
		else return v.toString();
	}
}
