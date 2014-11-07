package com.gang.service.wssvc;

import java.io.ByteArrayInputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.List;

import javax.annotation.Resource;
import javax.servlet.http.HttpServletResponse;
import javax.xml.ws.WebServiceContext;

import org.apache.cxf.transport.http.AbstractHTTPDestination;
import org.apache.xml.security.utils.Base64;
import org.hibernate.Session;
import org.hibernate.criterion.Restrictions;

import com.gang.comms.JSONHelper;
import com.gang.entity.user.FrontUser;
import com.gang.entity.user.Terminal;
import com.gang.entity.version.Version;
import com.gang.service.BaseService;

public abstract class AbstractService extends BaseService implements IService {
	@Resource
	private WebServiceContext context;

	public WebServiceContext getContext() {
		return context;
	}

	public void setContext(WebServiceContext context) {
		this.context = context;
	}

	public String quote(Object str) {
		return str == null ? "\"\"" : "\"" + str.toString().replace("\r\n", "").replace("\n", "").replace("\"", "“") + "\"";
	}

	public String getHTML(String absolutlyPath) {
		File f = new File(absolutlyPath);
		String ret = null;
		if (f.exists()) {
			try {
				InputStream is = new FileInputStream(f);
				int len = is.available();
				byte[] b = new byte[is.available()];
				is.read(b, 0, len);
				ret = new String(b, "UTF-8");
			} catch (Exception e) {
				e.printStackTrace();
			}
		}
		return ret;
	}

	public void down(String path) {
		HttpServletResponse response = (HttpServletResponse) context.getMessageContext().get(AbstractHTTPDestination.HTTP_RESPONSE);
		try {
			File f = new File(path);
			String filename = f.getName();
			InputStream is = new FileInputStream(f);

			response.setContentType("application/x-msdownload");
			response.setContentLength(is.available());
			response.setHeader("Content-Disposition", "attachment; filename=" + new String(filename.getBytes("gb2312"), "iso8859-1") + "");
			OutputStream os = response.getOutputStream();
			byte[] b = new byte[1024];
			int bytes = 0;
			while ((bytes = is.read(b)) > 0) {
				os.write(b, 0, bytes);
			}
			is.close();
			os.flush();
			os.close();
		} catch (IOException e) {
			// e.printStackTrace();
		}
	}

	public void down(byte[] byteArray, String zipName) {
		HttpServletResponse response = (HttpServletResponse) context.getMessageContext().get(AbstractHTTPDestination.HTTP_RESPONSE);
		try {
			InputStream is = new ByteArrayInputStream(byteArray);

			response.setContentType("application/x-msdownload");
			response.setContentLength(is.available());
			response.setHeader("Content-Disposition", "attachment; filename=" + new String(zipName.getBytes("gb2312"), "iso8859-1") + "");
			OutputStream os = response.getOutputStream();
			byte[] b = new byte[1024];
			int bytes = 0;
			while ((bytes = is.read(b)) > 0) {
				os.write(b, 0, bytes);
			}
			is.close();
			os.flush();
			os.close();
		} catch (IOException e) {
			// e.printStackTrace();
		}
	}

	@Override
	public String regisiter(String name, String pwd, String email, String activeKey) {
		Session session = getSession();
		Result result = new Result();

		// 检查用户名是否存在
		List<FrontUser> list = getCriteria(FrontUser.class).add(Restrictions.eq("loginName", name)).list();
		if (list.size() > 0) {
			result.setRet(NO);
			result.setMsg("该用户名已经被使用.");
		} else {
			FrontUser user = new FrontUser();
			user.setLoginName(name);
			user.setLoginPassword(pwd);
			user.setUniqueCode(activeKey);
			user.setEmail(email);
			session.save(user);
			result.setRet(OK);
			result.setMsg("注册成功!");
		}
		return JSONHelper.Serialize(result);
	}

	@Override
	public String login(String name, String pwd) {

		FrontUser user = (FrontUser) getCriteria(FrontUser.class).add(Restrictions.eq("loginName", name)).add(Restrictions.eq("loginPassword", pwd)).uniqueResult();
		Result result = new Result();
		if(user==null)
		{
			result.setRet(NO);
			result.setMsg("用户名或者密码不正确");
		}
		else
		{
			result.setId(user.getId().toString());
			result.setNickName(user.getNickName());
			result.setRet(OK);
			result.setMsg("登录成功");
		}
		return JSONHelper.Serialize(result);
	}

	@Override
	public String checkVersion(String type, String activeKey) {
		String sql="SELECT * FROM VERSION WHERE equtype = '"+type+"' ORDER BY ID DESC LIMIT 1";
		Version v =(Version) getSession().createSQLQuery(sql).addEntity(Version.class).uniqueResult();
		if(v!=null && v.getVersion()!=null )
		{
			return JSONHelper.SerializeWithNeedAnnotation(v);
		}
		return null;
	}
	@Override
	public String activeTerminal(String deviceCode, int height, int width, String osCode, String osType, String osVersion, String softVersion) {
		Terminal t = new Terminal();
		t.setDeviceCode(deviceCode);
		t.setHeight(height);
		t.setWidth(width);
		t.setOsCode(osCode);
		t.setOsType(osType);
		t.setOsVersion(osVersion);
		t.setSoftVersion(softVersion);
		String code = deviceCode + height + width + osCode + osType + osVersion + softVersion;
		t.setUniqueCode(Base64.encode(code.getBytes()));
		getSession().save(t);
		return "{\"active\":"+quote(t.getUniqueCode().replaceAll("\r", "").replaceAll("\n", ""))+"}";
	}

	
}
