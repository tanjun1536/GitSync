package com.gang.entity.push;

import com.gang.entity.BaseEntity;
import com.google.gson.annotations.Expose;

import java.util.Date;


public class Push
  extends BaseEntity
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	@Expose
	private String  message;
	@Expose
	private Date    createDate;
	private Integer createUser;
	private String  result;
	private Integer msgId;
	

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public Integer getMsgId() {
		return msgId;
	}

	public void setMsgId(Integer msgId) {
		this.msgId = msgId;
	}

	public String getMessage()
	{
		return message;
	}

	public void setMessage(String message)
	{
		this.message = message;
	}

	public Date getCreateDate()
	{
		return createDate;
	}

	public void setCreateDate(Date createDate)
	{
		this.createDate = createDate;
	}

	public Integer getCreateUser()
	{
		return createUser;
	}

	public void setCreateUser(Integer createUser)
	{
		this.createUser = createUser;
	}

	public String getResult()
	{
		return result;
	}

	public void setResult(String result)
	{
		this.result = result;
	}
}
