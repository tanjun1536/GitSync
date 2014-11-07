package com.gang.service.template;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.io.Writer;
import java.lang.reflect.Type;
import java.net.URLDecoder;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.UUID;

import javax.script.Bindings;
import javax.script.ScriptEngine;
import javax.script.ScriptEngineManager;

import org.apache.commons.io.FileUtils;
import org.apache.oro.text.regex.MalformedPatternException;
import org.apache.oro.text.regex.MatchResult;
import org.apache.oro.text.regex.Pattern;
import org.apache.oro.text.regex.PatternMatcherInput;
import org.apache.oro.text.regex.Perl5Compiler;
import org.apache.oro.text.regex.Perl5Matcher;
import org.hibernate.criterion.Restrictions;

import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;
import com.gang.entity.article.Article;
import com.gang.entity.article.ArticleMobileNews;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.imagecontent.PadImageContent;
import com.gang.entity.layout.PadPageLayout;
import com.gang.entity.layout.PadPageLayoutArticle;
import com.gang.entity.log.StateLog;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.entity.template.Template;
import com.gang.entity.user.BackUser;
import com.gang.service.BaseService;
import com.gang.service.log.StateLogService;
import com.google.gson.reflect.TypeToken;

import freemarker.ext.script.FreeMarkerScriptConstants;

public class TemplateService extends BaseService {
	public static String IPAD_TEMPLATE = "iPad";
	public static String IPAD_TEMPLATE_LIST = "iPadList";
	public static String IPHONE_TEMPLATE = "iPhone";
	public String[] articleParams = { "articleone", "articletwo",
			"articlethree", "articlefour", "articlefive" };

	private StateLogService logService;

	public StateLogService getLogService() {
		return logService;
	}

	public void setLogService(StateLogService logService) {
		this.logService = logService;
	}

	public List<Template> getMobileTemplates() {
		return getCriteria(Template.class).add(
				Restrictions.eq("type", IPHONE_TEMPLATE)).list();
	}

	public List<Template> getPadListTemplates() {
		return getCriteria(Template.class).add(
				Restrictions.eq("type", IPAD_TEMPLATE_LIST)).list();
	}

	public List<Template> getPadTemplates() {
		return getCriteria(Template.class).add(
				Restrictions.eq("type", IPAD_TEMPLATE)).list();
	}

	/**
	 * 预览文章包含手机文章 手机图片文章 平板文章 平板图片文章
	 */
	public String render(Integer articleId, Class clazz, String basePath)
			throws Exception {

		// 获取文章
		Article article = get(clazz, articleId);
		// 获取模版
		Template template = article.getTemplate();
		// 生成引擎
		ScriptEngineManager manager = new ScriptEngineManager();
		ScriptEngine engine = manager.getEngineByName("FreeMarker");
		// 注入参数
		Bindings bindings = engine.createBindings();
		bindings.put(FreeMarkerScriptConstants.STRING_OUTPUT, Boolean.TRUE);
		bindings.put("article", article);
		bindings.put("basePath", basePath);
		bindings.put("getDate", new GetDateTemplateMethodModel());
		return engine.eval(template.getPreviewHtml(), bindings).toString();

	}

	/**
	 * 预览平板文章列表
	 */
	public String render(String layoutId, String basePath) throws Exception {

		// 获取排版
		PadPageLayout layout = get(PadPageLayout.class,
				Integer.parseInt(layoutId));
		// 查询文章
		List<Article> articles = new ArrayList<Article>();
		List<PadPageLayoutArticle> layoutArticles = new ArrayList<PadPageLayoutArticle>(
				layout.getArticles());

		for (PadPageLayoutArticle layoutArticle : layoutArticles) {
			Article article = null;
			if ("0".equals(layoutArticle.getType())) {
				article = get(ArticlePad.class, layoutArticle.getArticle());
			} else {
				article = get(PadImageContent.class, layoutArticle.getArticle());
			}
			articles.add(article);
		}
		// 设置为发布状态
		// layout.setState(1);
		// 获取模版
		Template template = layout.getTemplate();
		// 生成引擎
		ScriptEngineManager manager = new ScriptEngineManager();
		ScriptEngine engine = manager.getEngineByName("FreeMarker");
		// 注入参数
		Bindings bindings = engine.createBindings();
		bindings.put(FreeMarkerScriptConstants.STRING_OUTPUT, Boolean.TRUE);
		for (int i = 0; i < articles.size(); i++) {
			bindings.put(articleParams[i], articles.get(i));
		}
		bindings.put("basePath", basePath);
		bindings.put("state", getOfflineState());
		bindings.put("basePath", basePath);
		bindings.put("getDate", new GetDateTemplateMethodModel());
		return engine.eval(template.getPreviewHtml(), bindings).toString();

	}

	/**
	 * 发布平板文章
	 */
	public void render(String layoutId, String virtualPath,
			String absolutlyPath, BackUser user) throws Exception {

		// 删除原来的目录及文章
		// FileHelper.deleteFile(new File(absolutlyPath));
		String listName = getUUID();
		// 获取文章
		PadPageLayout layout = get(PadPageLayout.class,
				Integer.parseInt(layoutId));
		// 获取模版
		Template template = layout.getTemplate();
		// 设置连接
		layout.setLink(virtualPath + listName);
		layout.setState(1);
		// 查询文章
		List<Article> articles = new ArrayList<Article>();
		List<PadPageLayoutArticle> layoutArticles = new ArrayList<PadPageLayoutArticle>(
				layout.getArticles());
		// 生成引擎
		ScriptEngineManager manager = new ScriptEngineManager();
		ScriptEngine engine = manager.getEngineByName("FreeMarker");
		Bindings bindings = engine.createBindings();
		bindings.put(FreeMarkerScriptConstants.STRING_OUTPUT, Boolean.TRUE);
		// 注入参数
		bindings.put("state", getOfflineState());
		bindings.put("getFileName", new GetFileNameTemplateMethodModel());
		bindings.put("getDate", new GetDateTemplateMethodModel());
		bindings.put("replaceKeyWord", new ReplaceKeyWordTemplateMethodModel());
		State offState = getOfflineState();
		for (PadPageLayoutArticle layoutArticle : layoutArticles) {
			Article article = null;
			if ("0".equals(layoutArticle.getType())) {
				article = get(ArticlePad.class, layoutArticle.getArticle());
			} else {
				article = get(PadImageContent.class, layoutArticle.getArticle());
			}
			int index = layoutArticle.getOrderNumber() - 1;
			// 如果文章下线了就不再发布了
			if (offState.getId().equals(article.getState().getId()))
				continue;
			// 注入参数
			bindings.put(articleParams[index], article);
			articles.add(article);
		}
		for (Article article : articles) {
			String name = article.getId() + ".html";
			String v = virtualPath + "/" + article.getId() + "/" + name;
			// 把列表页面和图片页面放到一起
			// String v = virtualPath + "/" + name;
			String a = absolutlyPath + article.getId() + "\\" + name;
			render(engine, layout.getId(), article, v, a, user);
		}
		// String html = engine.eval(template.getHtml(), bindings).toString();
		// Writer out = new BufferedWriter(new OutputStreamWriter(new
		// FileOutputStream(new File(absolutlyPath + listName)), "UTF-8"));
		// out.write(html);
		// out.flush();
		// out.close();
	}

	/**
	 * 发布手机文章或者手机图片文章
	 */
	public void render(Integer articleId, Class clazz, String basePath,
			String virtualPath, String outFileName, BackUser user)
			throws Exception {
		// FileHelper.deleteFile(new File(basePath));
		// 查询文章
		
		Article article = get(clazz, articleId);
		// 修改文章状态
		article.setState(article.getState().getNext());
		// 修改发布时间
		article.setDistributeDate(new Date());
		// 修改版本
		article.setVersion(article.getVersion() + 1);
		// 如果是新闻就生成
		if (article instanceof ArticleMobileNews) {
			// 修改文章连接
			article.setContentLink(virtualPath);
			// 获取模版
			// Template template = article.getTemplate();
			// 修改为只去iPhone模版
			Template template = get(Template.class, 1);
			// 生成引擎
			ScriptEngineManager manager = new ScriptEngineManager();
			ScriptEngine engine = manager.getEngineByName("FreeMarker");
			// 注入参数
			Bindings bindings = engine.createBindings();
			bindings.put(FreeMarkerScriptConstants.STRING_OUTPUT, Boolean.TRUE);
			bindings.put("article", article);
			bindings.put("basePath", basePath);
			bindings.put("getFileName", new GetFileNameTemplateMethodModel());
			bindings.put("getDate", new GetDateTemplateMethodModel());
			bindings.put("replaceKeyWord",
					new ReplaceKeyWordTemplateMethodModel());
			// 把文件拷贝到对应的目录
			doCopyImage(article, outFileName);
			String html = engine.eval(template.getHtml(), bindings).toString();
			Writer out = new BufferedWriter(new OutputStreamWriter(
					new FileOutputStream(new File(outFileName)), "UTF-8"));
			out.write(html);
			out.flush();
			out.close();
		}
		// 添加日志
		logService.addLog(StateLog.Mobile_Article, article.getState().getId(),
				article.getState().getName(), user, article.getId());
	}

	public void render(ScriptEngine engine, int pageId, Article article,
			String virtualPath, String absolutlyPath, BackUser user)
			throws Exception {

		if (article.getState().getId().equals(getOfflineState().getId()))
			return;
		// 修改文章状态
		article.setState(article.getState().getNext());
		// 修改文章连接
		article.setContentLink(virtualPath);
		// 修改发布时间
		article.setDistributeDate(new Date());
		// 修改栏目中的文章数
		Section section = article.getSection();
		int ac = section.getArticleCount();
		section.setArticleCount(ac + 1);

		// 获取模版
		Template template = article.getTemplate();
		// 注入参数
		Bindings bindings = engine.createBindings();
		bindings.put(FreeMarkerScriptConstants.STRING_OUTPUT, Boolean.TRUE);
		bindings.put("article", article);
		bindings.put("getFileName", new GetFileNameTemplateMethodModel());
		bindings.put("getDate", new GetDateTemplateMethodModel());
		bindings.put("replaceKeyWord", new ReplaceKeyWordTemplateMethodModel());
		bindings.put("pageId", pageId);
		// 把图片拷贝到图片目录
		doCopyImage(article, absolutlyPath);
		String html = engine.eval(template.getHtml(), bindings).toString();
		Writer out = new BufferedWriter(new OutputStreamWriter(
				new FileOutputStream(new File(absolutlyPath)), "UTF-8"));
		out.write(html);
		out.flush();
		out.close();
		// 添加日志
		logService.addLog(StateLog.Pad_Article, article.getState().getId(),
				article.getState().getName(), user, article.getId());
	}

	private void doCopyImage(Article article, String absolutlyPath)
			throws Exception {
		File f = new File(absolutlyPath);
		String imagePath = null;
		// if (article instanceof ArticlePad)
		// imagePath = f.getParentFile().getParent() + "\\images\\";
		// else
		imagePath = f.getParent() + "\\images\\";
		File imageFoler = new File(imagePath);
		imageFoler.mkdirs();
		copyFile(article.getFocusImage(), imagePath);
		copyFile(article.getTitleImage(), imagePath);
		if (StringHelper.isNotBlank(article.getContent())) {
			List<String> paths = getHTMLFile(article.getContent());
			for (String path : paths) {
				// String gbPath = URLDecoder.decode(path);
				copyFile(path, imagePath);
			}
		}
	}

	private void copyFile(String vPath, String dPath)
			throws UnsupportedEncodingException {
		if (StringHelper.isNotBlank(vPath)) {
			String src = getWebRoot(vPath);
			src = URLDecoder.decode(src, "UTF-8");
			File srcFile = new File(src);
			String des = dPath + "\\" + srcFile.getName();
			File desFile = new File(des);
			try {
				if (!desFile.exists())
					FileUtils.copyFile(srcFile, desFile);
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
	}

	/**
	 * 新建pad列表的时候预览
	 */
	public String render(String S, String templateId, String basePath)
			throws Exception {
		// 反序列化
		Type typeOf = new TypeToken<List<PadPageLayoutArticle>>() {
		}.getType();
		// 排版选择的文章
		List<PadPageLayoutArticle> plas = JSONHelper.Deserialize(S, typeOf);
		// 获取id和类型
		Article article = null;
		// 获取模版
		Template template = get(Template.class, Integer.parseInt(templateId));
		// 生成引擎
		ScriptEngineManager manager = new ScriptEngineManager();
		ScriptEngine engine = manager.getEngineByName("FreeMarker");
		// 注入参数
		Bindings bindings = engine.createBindings();
		bindings.put(FreeMarkerScriptConstants.STRING_OUTPUT, Boolean.TRUE);
		for (PadPageLayoutArticle p : plas) {
			if ("0".equals(p.getType())) {
				article = get(ArticlePad.class, p.getArticle());
			} else {
				article = get(PadImageContent.class, p.getArticle());
			}
			int index = p.getOrderNumber() - 1;
			bindings.put(articleParams[index], article);
		}

		bindings.put("basePath", basePath);
		bindings.put("state", getOfflineState());
		bindings.put("basePath", basePath);
		bindings.put("getDate", new GetDateTemplateMethodModel());
		return engine.eval(template.getPreviewHtml(), bindings).toString();
	}

	private String getUUID() {
		return UUID.randomUUID() + ".html";
	}

	// 编辑器里面的HTML解析得出图片和视频方便拷贝
	public List<String> getHTMLFile(String html)
			throws MalformedPatternException {
		List<String> paths = new ArrayList<String>();
		String regex = "<img [^>]* />";
		String srcRegex = "src\\s*=\\s*\"([^\"]*)\"";
		Perl5Compiler compiler = new Perl5Compiler();
		Pattern pattern = compiler.compile(regex,
				Perl5Compiler.CASE_INSENSITIVE_MASK);
		Pattern srcPattern = compiler.compile(srcRegex,
				Perl5Compiler.CASE_INSENSITIVE_MASK);
		Perl5Matcher matcher = new Perl5Matcher();
		PatternMatcherInput matcherInput = new PatternMatcherInput(html);
		while (matcher.contains(matcherInput, pattern)) {
			MatchResult result = matcher.getMatch();
			PatternMatcherInput input = new PatternMatcherInput(
					result.toString());
			if (matcher.contains(input, srcPattern)) {
				MatchResult src = matcher.getMatch();
				String img = src.group(1);
				if (StringHelper.isNotBlank(img)) {
					paths.add(img);
					// 同时替换路径
					String fileName = img.substring(img.lastIndexOf("/")); // 带
																			// /
					html = html.replaceFirst(img, "images" + fileName);
				}
			}
		}
		return paths;
	}
}
