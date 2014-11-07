package com.gang.action.version;

import java.io.File;

import javax.servlet.http.HttpServletRequest;

import com.gang.action.DefaultAction;
import com.gang.comms.FileHelper;
import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.JSONHelper;
import com.gang.entity.version.Version;
import com.gang.service.version.VersionService;


public class VersionAction
  extends DefaultAction
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	private File           apkFile;
	private VersionService service;
	private String         uploadDir;
	private Version        version;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	@Override
	public void ajaxDelete(Integer id)
		throws Exception
	{
		service.delete (Version.class, id);
	}

	@Override
	public void edit(
	  Integer            id,
	  HttpServletRequest req)
		throws Exception
	{
		addAttribute ("version", service.get (Version.class, id));
	}

	public File getApkFile()
	{
		return apkFile;
	}

	@Override
	public void getList()
		throws Exception
	{
		GridPageRequest gr = new GridPageRequest(getRequest ());
		StringBuffer    csql = new StringBuffer(" SELECT count(v) FROM Version v");
		StringBuffer    dsql = new StringBuffer(" SELECT v FROM Version v");
		gr.setTableAlias ("v");
		gr.setHsql (true);
		gr.setCsql (csql.toString ());
		gr.setDsql (dsql.toString ());

		GridPageResponse gpr = service.getGridPage (gr);
		String           json = JSONHelper.SerializeWithNeedAnnotation (gpr);
		Write (json);
	}

	public VersionService getService()
	{
		return service;
	}

	public String getUploadDir()
	{
		return uploadDir;
	}

	public Version getVersion()
	{
		return version;
	}

	@Override
	public String save()
		throws Exception
	{
		if (apkFile != null)
		{
			String saveDir = getRealPath (uploadDir);

			String apkURL = FileHelper.saveAPK (apkFile, uploadDir, saveDir);

			if (apkURL != null)
			{
				version.setDownUrl (getBasePath () + apkURL);
			}
		}

		service.add (version);

		return LIST;
	}

	public void setApkFile(File apkFile)
	{
		this.apkFile = apkFile;
	}

	public void setService(VersionService service)
	{
		this.service = service;
	}

	public void setUploadDir(String uploadDir)
	{
		this.uploadDir = uploadDir;
	}

	public void setVersion(Version version)
	{
		this.version = version;
	}

	@Override
	public void doUpdate()
		throws Exception
	{
		service.save (version);
		super.doUpdate ();
	}
}
