package com.gang.service.wssvc;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Set;

import javax.jws.WebService;

import org.apache.xml.security.utils.Base64;
import org.hibernate.Query;
import org.hibernate.Session;
import org.hibernate.criterion.Order;
import org.hibernate.criterion.Restrictions;

import com.gang.comms.DateHelper;
import com.gang.comms.ZipHelper;
import com.gang.entity.article.Article;
import com.gang.entity.article.ArticlePad;
import com.gang.entity.article.ArticlePadLayout;
import com.gang.entity.layout.PadPageLayout;
import com.gang.entity.layout.PadPageLayoutArticle;
import com.gang.entity.section.PadSectionFocus;
import com.gang.entity.section.Section;
import com.gang.entity.section.SectionType;
import com.gang.entity.user.Terminal;

@WebService(endpointInterface = "com.gang.service.wssvc.IPadService", targetNamespace = "http://tanjun1536.cn")
public class PadService extends AbstractPadService {

	@Override
	public String getChanels(String activeKey) {
		Session session = getSession();
		Query q = session.createQuery("FROM com.gang.entity.section.Section s WHERE s.parent.id=1");
		List<Section> list = q.list();
		StringBuffer sb = new StringBuffer();
		sb.append(JSONARRAY_START);
		if (list != null && list.size() > 0) {
			int len = list.size();
			for (int i = 0; i < len; i++) {
				Section s = list.get(i);
				// NSString * issueName; // 频道名称
				// NSString * issueID; // 频道标识
				// NSString * issueType; // 频道种类 图片(G)，微报(N)，普通(null)信息三种（）
				// NSString * issueFace; // 频道图片文件名
				// NSString * issueFaceUrl; // 频道图片下载地址
				// NSString * issueGroup; // 频道属性组
				// NSString * issueExternUrl; // 外部链接地址
				sb.append(JSON_START).append(quote("issueName")).append(":").append(quote(s.getText())).append(",").append(quote("issueID")).append(":").append(quote(s.getId())).append(",").append(quote("issueType")).append(":").append(quote(s.getSectionType().getName())).append(",").append(quote("issueFace")).append(":").append(quote(s.getPadTitleImage())).append(",").append(quote("issueFaceUrl")).append(":").append(quote(s.getPadTitleImage())).append(",").append(quote("issueGroup")).append(":").append(quote("")).append(",").append(quote("issueExternUrl")).append(":").append(quote("")).append(JSON_END);
				if (i < len - 1)
					sb.append(",");
			}
		}
		sb.append(JSONARRAY_END);
		return sb.toString();
	}

	@Override
	public void getDoc(String docId) {

//		ArticlePad ap = (ArticlePad) getSession().get(ArticlePad.class, Integer.parseInt(docId));
//		String path = getWebRoot(ap.getContentLink());
//		return getHTML(path);
		Article article = get(ArticlePad.class, Integer.parseInt(docId));
		if (article != null) {
			Integer count=article.getBrowseCount();
			count=count==null?0:count;
			article.setBrowseCount(count+1);
			String html = getWebRoot(article.getContentLink());
			File f = new File(html);
			String folder = f.getParent();
			// String zipName=folder+"/"+pageId+".zip";
			String zipName = docId + ".zip";
			try {
				// ZipHelper.doZipFolder(folder, zipName);
				// down(zipName);
				down(ZipHelper.doZipFolder(folder), zipName);
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}

		}
	}

	@Override
	public String getDocList(String section, String activeKey) {
		Integer sectionId=Integer.parseInt(section);
		//查询栏目类别
		String sql="SELECT * FROM sectiontype WHERE id=(SELECT sectiontype FROM section WHERE id=:sectionId) ";
		SectionType st=(SectionType) getSession().createSQLQuery(sql).addEntity(SectionType.class).setInteger("sectionId", sectionId).uniqueResult();
		StringBuffer sb = new StringBuffer();
		if(st.getId().intValue()==1)
		{
			sb = getDocListLayout(sectionId, sb);
		}
		else
		{
			sb=getDocList(sectionId,sb);
		}
		return sb.toString();
	}
	private StringBuffer getDocListLayout(Integer sectionId, StringBuffer sb) {
		List<PadPageLayout> layouts=getSession().createCriteria(PadPageLayout.class)
		.add(Restrictions.eq("section", sectionId))
		.add(Restrictions.eq("state", new Integer(1)))
		.addOrder(Order.desc("id"))
		.setFirstResult(0)
		.setMaxResults(20).list();
		List<ArticlePadLayout> articles=new ArrayList<ArticlePadLayout>();
		sb.append(JSONARRAY_START);
		for(PadPageLayout layout:layouts)
		{
			Set<PadPageLayoutArticle> layoutArticls=layout.getArticles();
			for(PadPageLayoutArticle layoutArticle:layoutArticls)
			{
				Article article=get(ArticlePad.class, layoutArticle.getArticle());
				ArticlePadLayout apl=new ArticlePadLayout(article);
				apl.setPageId(layoutArticle.getLayout().getId());
				apl.setIndex(layoutArticle.getOrderNumber());
				apl.setPageStyle(layoutArticle.getLayout().getTemplate().getArticleCount());
				articles.add(apl);
			}
		}
		if(articles!=null && articles.size()>0)
		{
			for(ArticlePadLayout a:articles)
			{
				sb.append(JSON_START)
				.append(quote("pageId")).append(":").append(quote(a.getPageId())).append(",")//排版号
				.append(quote("index")).append(":").append(quote(a.getIndex())).append(",")//文章位置
				.append(quote("pageStyle")).append(":").append(quote(a.getPageStyle())).append(",")//板式
				.append(quote("doclistDocID")).append(":").append(quote(a.getId())).append(",")
				.append(quote("doclistTitle")).append(":").append(quote(a.getTitle())).append(",")
				.append(quote("doclistFloor")).append(":").append(quote("")).append(",")
				.append(quote("doclistPubDate")).append(":").append(quote(DateHelper.getDate(a.getDistributeDate()))).append(",")
				.append(quote("doclistAuthor")).append(":").append(quote(a.getSender())).append(",")
				.append(quote("doclistLink")).append(":").append(quote(a.getDomain() == null ? a.getContentLink() : a.getDomain() + a.getContentLink())).append(",")
				.append(quote("doclistCid")).append(":").append(a.getSection().getId()).append(",")
				.append(quote("doclistDescription")).append(":").append(quote(a.getSummary(),1000)).append(",")
			    .append(quote("doclistCategory")).append(":").append(quote(a.getSection().getName())).append(",")
			    .append(quote("doclistComments")).append(":").append(quote("")).append(",")
			    .append(quote("doclistImage")).append(":").append(quote(a.getTitleImage())).append(",")
			    .append(quote("doclistFocusImage")).append(":").append(quote(a.getFocusImage())).append(",")
			    .append(quote("doclistEditor")).append(":").append(quote(a.getEditor())).append(",")
			    .append(quote("doclistArticleSource")).append(":").append(quote(a.getSource()))
			    .append(JSON_END)	
				.append(",");
			}
		}
		if(sb.length()>1)
			sb=sb.deleteCharAt(sb.length()-1);
		sb.append(JSONARRAY_END);
		return sb;
	}

	private StringBuffer getDocList(Integer sectionId, StringBuffer sb) {
		List<Article> articles = getSession().createCriteria(ArticlePad.class)
		.createAlias("state", "st")
		.add(Restrictions.eq("st.id", getOnlineState().getId()))
		.add(Restrictions.eq("section.id",sectionId))
		.setMaxResults(120)
		.addOrder(Order.desc("topDate")).list();
		sb.append(JSONARRAY_START);
		if(articles!=null && articles.size()>0)
		{
			for(Article a:articles)
			{
				sb.append(JSON_START)
				.append(quote("doclistDocID")).append(":").append(quote(a.getId())).append(",")
				.append(quote("doclistTitle")).append(":").append(quote(a.getTitle())).append(",")
				.append(quote("doclistFloor")).append(":").append(quote("")).append(",")
				.append(quote("doclistPubDate")).append(":").append(quote(DateHelper.getDate(a.getDistributeDate()))).append(",")
				.append(quote("doclistAuthor")).append(":").append(quote(a.getSender())).append(",")
				.append(quote("doclistLink")).append(":").append(quote(a.getDomain() == null ? a.getContentLink() : a.getDomain() + a.getContentLink())).append(",")
				.append(quote("doclistCid")).append(":").append(a.getSection().getId()).append(",")
				.append(quote("doclistDescription")).append(":").append(quote(a.getSummary(),1000)).append(",")
			    .append(quote("doclistCategory")).append(":").append(quote(a.getSection().getName())).append(",")
			    .append(quote("doclistComments")).append(":").append(quote("")).append(",")
			    .append(quote("doclistImage")).append(":").append(quote(a.getTitleImage())).append(",")
			    .append(quote("doclistFocusImage")).append(":").append(quote(a.getFocusImage())).append(",")
			    .append(quote("doclistEditor")).append(":").append(quote(a.getEditor())).append(",")
			    .append(quote("doclistArticleSource")).append(":").append(quote(a.getSource()))
			    .append(JSON_END)	
				.append(",");
			}
		}
		if(sb.length()>1)
			sb=sb.deleteCharAt(sb.length()-1);
		sb.append(JSONARRAY_END);
		return sb;
	}


//	@Override
//	public String getDocList(String section, String activeKey) {
//		
//		//String sql="SELECT * FROM ArticlePad a WHERE a.id in ( SELECT la.article FROM PadPageLayoutArticle la WHERE la.layout.id in (select l.id FROM PadPageLayout WHERE l.section=:section order by l.id desc limit 10) )";
//		List<Article> list = getSession().createCriteria(ArticlePad.class).add(Restrictions.eq("section.id", Integer.parseInt(section))).setMaxResults(30).list();
//		StringBuffer sb = new StringBuffer();
//		sb.append(JSONARRAY_START);
//		if (list != null && list.size() > 0) {
//			int len = list.size();
//			for (int i = 0; i < len; i++) {
//				// NSString * doclistDocID; // 文档id
//				// NSString * doclistTitle; // 内容标题
//				// NSString * doclistFloor; // 文档层级
//				// NSString * doclistPubDate; // 发布时间
//				// NSString * doclistAuthor; // 作者
//				// NSString * doclistLink; // 详细内容URL link和cid字段为互斥字段，
//				// //
//				// 当link不为空时，表示转向到内容的URL，当cid不为空时，表示当前内容为一个分类，点击时不离开列表，清空后重新刷新。
//				// NSString * doclistCid; // 子栏目标识
//				// NSString * doclistDescription; // 内容描述
//				// NSString * doclistCategory; // 分类名称“新闻评论”
//				// NSString * doclistComments; // 备注内容
//				//
//				// NSString * doclistImage; // 标题图片联接（扩展）
//				// NSString * doclistFocusImage; // 焦点图片联接（扩展）
//				// 如果列表中有此字段，则在焦点图片显示窗口显示该图
//				// NSString * doclistEditor; // 编辑者名称 (扩展)
//				// NSString * doclistArticleSource;// 来源(扩展)
//				Article a = list.get(i);
//				sb.append(JSON_START).append(quote("doclistDocID")).append(":").append(quote(a.getId())).append(",").append(quote("doclistTitle")).append(":").append(quote(a.getTitle())).append(",").append(quote("doclistFloor")).append(":").append(quote("")).append(",").append(quote("doclistPubDate")).append(":").append(quote(DateHelper.getDate(a.getCreateDate()))).append(",").append(quote("doclistAuthor")).append(":").append(quote(a.getSender())).append(",").append(quote("doclistLink")).append(":").append(quote(a.getDomain() == null ? a.getContentLink() : a.getDomain() + a.getContentLink())).append(",").append(quote("doclistCid")).append(":").append(a.getSection().getId()).append(",").append(quote("doclistDescription")).append(":").append(quote("")).append(",")
//				.append(quote("doclistCategory")).append(":").append(quote(a.getSection().getName())).append(",").append(quote("doclistComments")).append(":").append(quote("")).append(",").append(quote("doclistImage")).append(":").append(quote(a.getTitleImage())).append(",").append(quote("doclistFocusImage")).append(":").append(quote(a.getFocusImage())).append(",").append(quote("doclistEditor")).append(":").append(quote(a.getEditor())).append(",").append(quote("doclistArticleSource")).append(":").append(quote(a.getSource())).append(JSON_END);
//				if (i < len - 1)
//					sb.append(",");
//				
//			}
//		}
//		sb.append(JSONARRAY_END);
//		return sb.toString();
//	}


	
	@Override
	public String getIndexFocus(String activeKey) {
		StringBuffer sb = new StringBuffer();
		List<PadSectionFocus> sf=getCriteria(PadSectionFocus.class).createAlias("section", "s").createAlias("state", "st").add(Restrictions.eq("s.id", 1)).add(Restrictions.eq("st.id", getOnlineState().getId())).addOrder(Order.desc("topDate")).list();
		Section s = (Section) getSession().get(Section.class, 1);
		if (s != null && sf.size() > 0) {
			// docID，文章id
			// focusDocTitle ，标题
			// focusImageUrl ，图片地址
			// focusDocAddress 文章地址
			// focusDocDescription 文章描述
			sb.append(JSONARRAY_START);
			for (int j = 0; j < sf.size(); j++) {
				sb.append(JSON_START);
				PadSectionFocus f = sf.get(j);
				sb.append(quote("docID")).append(":").append(quote(f.getArticle() == null ? "" : f.getArticle().getId())).append(",").append(quote("focusDocTitle")).append(":").append(quote(f.getTitle())).append(",").append(quote("focusImageUrl")).append(":").append(quote(f.getImagePath())).append(",")
				.append(quote("focusDocAddress")).append(":").append(quote(f.getArticle()!=null?f.getArticle().getContentLink():"")).append(",")
				.append(quote("focusCiteAddress")).append(":").append(quote(f.getLinkAddress())).append(",")
				.append(quote("focusDocDescription")).append(":").append(quote(f.getContent())).append(JSON_END);
				if (j < sf.size() - 1)
					sb.append(",");
			}
			sb.append(JSONARRAY_END);
		}
		return sb.toString();
	}

	@Override
	public String getPadDocPageList(String section, String activeKey) {

		List<PadPageLayout> list = getSession().createCriteria(PadPageLayout.class).add(Restrictions.eq("section", Integer.parseInt(section))).add(Restrictions.eq("state", 1)).setMaxResults(20).list();
		StringBuffer sb = new StringBuffer();
		sb.append(JSONARRAY_START);
		if (list != null && list.size() > 0) {
			int len = list.size();
			for (int i = 0; i < len; i++) {
				PadPageLayout layout = list.get(i);
				sb.append(JSON_START)
				.append(quote("pageId")).append(":").append(quote(layout.getId())).append(",")
				.append(quote("link")).append(":").append(quote(layout.getDomain() == null ? layout.getLink() : layout.getDomain() + layout.getLink()))
				.append(JSON_END);
				if (i < len - 1)
					sb.append(",");

			}

		}
		sb.append(JSONARRAY_END);
		return sb.toString();
	}

	@Override
	public String getSections(String section, String activeKey) {
		Session session = getSession();
		Query q = session.createQuery("FROM com.gang.entity.section.Section s WHERE s.shown = true and s.parent.id= " + section+" ORDER BY s.orderNumber");
		List<Section> list = q.list();

		StringBuffer sb = new StringBuffer();
		sb.append(JSONARRAY_START);
		if (list != null && list.size() > 0) {
			int len = list.size();
			for (int i = 0; i < len; i++) {
				// NSString * categoryId; // 分类标识,本分类的ID
				// NSString * categoryTitle; // 分类名称,显示在菜单上的名称
				// NSString * categoryType; // 种类 图片(G)，微报(N)，普通(null)信息三种（）
				//
				// NSString * categoryParent; // 上级分类标识没有该值的为主题栏目
				// NSString * categoryProperty; // 分类属性,如果是博客，则上行的用户要改变
				// NSString * categoryImageFileName;
				// NSString * categoryImageUrl;
				// NSString * categoryDescription;
				// NSString * categoryDisplayTerminalSign;
				// NSString * categoryEditable;
				// NSMutableArray * categorySubArray;
				Section s = list.get(i);
				sb.append(JSON_START).append(quote("categoryId")).append(":").append(quote(s.getId())).append(",").append(quote("categoryTitle")).append(":").append(quote(s.getText())).append(",").append(quote("categoryType")).append(":").append(quote(s.getSectionType().getName())).append(",");
				if (s.getParent().getParent().getId().intValue() > 1)
					sb.append(quote("categoryParent")).append(":").append(quote(s.getParent().getId())).append(",");
				else
					sb.append(quote("categoryParent")).append(":").append(quote("")).append(",");
				sb.append(quote("categoryProperty")).append(":").append(quote("")).append(",").append(quote("categoryImageFileName")).append(":").append(quote(s.getPadTitleImage())).append(",").append(quote("categoryDocCount")).append(":").append(quote(s.getArticleCount())).append(",").append(quote("categoryImageUrl")).append(":").append(quote(s.getPadTitleImage())).append(",").append(quote("focus")).append(":").append(JSONARRAY_START);
				
				List<PadSectionFocus> sectionFocus =session.createCriteria(PadSectionFocus.class).createAlias("section", "sec").createAlias("state", "st").add(Restrictions.eq("sec.id", s.getId())).add(Restrictions.eq("st.id", getOnlineState().getId())).list();
				//如果父节点不是【i南充】就加入父节点的焦点
				if (s.getParent() != null && s.getParent().getId().intValue() != 1) {
					List<PadSectionFocus> ParentSectionFocus = session.createCriteria(PadSectionFocus.class).createAlias("section", "sec").createAlias("state", "st").add(Restrictions.eq("sec.id", s.getParent().getId())).add(Restrictions.eq("st.id", getOnlineState().getId())).list();
					if (ParentSectionFocus != null && ParentSectionFocus.size() > 0) {
						if (sectionFocus != null && sectionFocus.size() > 0)
							sectionFocus.addAll(0, ParentSectionFocus);
					}
				}
				if (sectionFocus != null && sectionFocus.size() > 0) {
					// docID，文章id
					// focusDocTitle ，标题
					// focusImageUrl ，图片地址
					// focusDocAddress 文章地址
					// focusDocDescription 文章描述

					for (int j = 0; j < sectionFocus.size(); j++) {
						sb.append(JSON_START);
						PadSectionFocus f = sectionFocus.get(j);
						sb.append(quote("docID")).append(":").append(quote(f.getArticle()!=null?f.getArticle().getId():"")).append(",")
						.append(quote("focusDocTitle")).append(":").append(quote(f.getTitle())).append(",")
						.append(quote("focusImageUrl")).append(":").append(quote(f.getImagePath())).append(",")
						.append(quote("focusDocAddress")).append(":").append(quote(f.getArticle()!=null?f.getArticle().getContentLink():"")).append(",")
						.append(quote("focusCiteAddress")).append(":").append(quote(f.getLinkAddress())).append(",")
						.append(quote("focusDocDescription")).append(":").append(quote(f.getContent())).append(JSON_END);
						if (j < sectionFocus.size() - 1)
							sb.append(",");
					}

				}
				sb.append(JSONARRAY_END).append(JSON_END);
				if (i < len - 1)
					sb.append(",");
			}
		}
		sb.append(JSONARRAY_END);
		return sb.toString();
	}

	public String quote(Object str) {
		if(str==null) return "\"\"" ;
		String S=str.toString();
		S=S.replace("\"", "”").replace("\r\n", "\\r\\n");
		return "\"" + S + "\"";
	}
	public String quote(Object str,int len) {
		if(str==null) return "\"\"" ;
		String S=str.toString();
		S=S.replace("\"", "“").replace("\r\n", "\\r\\n"); 
		if(S.length()>len)
			S=S.substring(0, len);
		return "\"" + S + "\"";
	}
	@Override
	public void getPadPage(String pageId) {
		PadPageLayout layout=get(PadPageLayout.class, Integer.parseInt(pageId));
		if(layout!=null)
		{
			String html=getWebRoot(layout.getLink());
			File f=new File(html);
			String folder=f.getParent();
			//String zipName=folder+"/"+pageId+".zip";
			String zipName=pageId+".zip";
			try {
//				ZipHelper.doZipFolder(folder, zipName);
//				down(zipName);
				down(ZipHelper.doZipFolder(folder),zipName);
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			
		}
	}

	@Override
	public void getResource(String type, String activeKey) {
		down(getWebRoot("resource/iPad.zip"));
	}
}
