package com.gang.action.share;

import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.InputStreamReader;
import java.nio.charset.Charset;

import javax.script.Bindings;
import javax.script.ScriptEngine;
import javax.script.ScriptEngineManager;
import javax.servlet.http.HttpServletResponse;

import org.hibernate.Session;

import com.gang.action.BaseAction;
import com.gang.comms.BaseTypeHelper;
import com.gang.entity.article.ArticleMobile;
import com.gang.service.article.ArticleService;
import com.gang.service.template.GetDateTemplateMethodModel;
import com.gang.service.wssvc.ICMSService.ClickType;

import freemarker.ext.script.FreeMarkerScriptConstants;

public class ShareAction extends BaseAction {
	private ArticleService service;
	public void setService(ArticleService service) {
		this.service = service;
	}
	public void share()
	{
		//获取要分析的文章编号，新闻类
		Integer id=getId();
		//查询文章
		ArticleMobile am = (ArticleMobile) service.get(ArticleMobile.class, id);
		//加载模版
		String        temp = getRealPath("share/iPhone/ShareTemplate.html");
		StringBuilder TemplateHtml = new StringBuilder();
		String        html = "";
		try
		{
			InputStreamReader reader = new InputStreamReader(new FileInputStream(temp), Charset.forName("UTF-8"));
			BufferedReader    br = new BufferedReader(reader);
			String            line = null;

			while ((line = br.readLine()) != null)
			{
				TemplateHtml.append(line);
			}

			br.close();
			reader.close();

			ScriptEngineManager manager = new ScriptEngineManager();
			ScriptEngine        engine = manager.getEngineByName("FreeMarker");

			Bindings bindings = engine.createBindings();
			bindings.put(FreeMarkerScriptConstants.STRING_OUTPUT, Boolean.TRUE);

			//String content = changeImage(am.getContent());
			bindings.put("content", am);
			bindings.put("basepath", getBasePath());
			bindings.put("getDate", new GetDateTemplateMethodModel());

			html = engine.eval(TemplateHtml.toString(), bindings)
				           .toString();
			HttpServletResponse response=getResponse();
			response.setCharacterEncoding("UTF-8");
			getResponse().getWriter().write(html);
		}
		catch (Exception e)
		{
			e.printStackTrace();
		}
	}
}
