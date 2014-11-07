package com.gang.entity.statistics;

import com.gang.entity.BaseEntity;


public class ChartData
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private String               link;
	private String               unit;
	private java.math.BigInteger value;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public String getLink()
	{
		return link;
	}

	public void setLink(String link)
	{
		this.link = link;
	}

	public String getUnit()
	{
		return unit;
	}

	public void setUnit(String unit)
	{
		this.unit = unit;
	}

	public java.math.BigInteger getValue()
	{
		return value;
	}

	public void setValue(java.math.BigInteger value)
	{
		this.value = value;
	}
}
