package com.gang.service.wssvc;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import javax.jws.WebService;

import org.apache.xml.security.utils.Base64;
import org.hibernate.Query;
import org.hibernate.Session;
import org.hibernate.criterion.Order;
import org.hibernate.criterion.Restrictions;

import com.gang.comms.BaseTypeHelper;
import com.gang.comms.DateHelper;
import com.gang.comms.ZipHelper;
import com.gang.entity.article.Article;
import com.gang.entity.article.ArticleMobile;
import com.gang.entity.article.ArticleMobileNews;
import com.gang.entity.layout.PadPageLayout;
import com.gang.entity.process.State;
import com.gang.entity.section.PadSectionFocus;
import com.gang.entity.section.Section;
import com.gang.entity.section.SectionFocus;
import com.gang.entity.user.Terminal;

@WebService(endpointInterface = "com.gang.service.wssvc.IMobileService", targetNamespace = "http://tanjun1536.cn")
public class MobileService extends AbstractMobileService {

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
				sb.append(JSON_START).append(quote("issueName")).append(":").append(quote(s.getText())).append(",").append(quote("issueID")).append(":").append(quote(s.getId())).append(",").append(quote("issueType")).append(":").append(quote(s.getSectionType().getName())).append(",").append(quote("issueFace")).append(":").append(quote(s.getMobileTitleImage())).append(",").append(quote("issueFaceUrl")).append(":").append(quote(s.getMobileTitleImage())).append(",").append(quote("issueGroup")).append(":").append(quote("")).append(",").append(quote("issueExternUrl")).append(":").append(quote("")).append(JSON_END);
				if (i < len - 1)
					sb.append(",");
			}
		}
		sb.append(JSONARRAY_END);
		return sb.toString();
	}

	@Override
	public void getDoc(String docId) {
		Article article = get(ArticleMobile.class, Integer.parseInt(docId));
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

	// @Override
	public String getDocList(String section, String activeKey) {
		List<Article> list = getSession().createCriteria(ArticleMobile.class).add(Restrictions.eq("section.id", Integer.parseInt(section))).setMaxResults(20).addOrder(Order.desc("id")).list();
		StringBuffer sb = new StringBuffer();
		sb.append(JSONARRAY_START);
		if (list != null && list.size() > 0) {
			int len = list.size();
			for (int i = 0; i < len; i++) {
				// NSString * doclistDocID; // 文档id
				// NSString * doclistTitle; // 内容标题
				// NSString * doclistFloor; // 文档层级
				// NSString * doclistPubDate; // 发布时间
				// NSString * doclistAuthor; // 作者
				// NSString * doclistLink; // 详细内容URL link和cid字段为互斥字段，
				// //
				// 当link不为空时，表示转向到内容的URL，当cid不为空时，表示当前内容为一个分类，点击时不离开列表，清空后重新刷新。
				// NSString * doclistCid; // 子栏目标识
				// NSString * doclistDescription; // 内容描述
				// NSString * doclistCategory; // 分类名称“新闻评论”
				// NSString * doclistComments; // 备注内容
				//
				// NSString * doclistImage; // 标题图片联接（扩展）
				// NSString * doclistFocusImage; // 焦点图片联接（扩展）
				// 如果列表中有此字段，则在焦点图片显示窗口显示该图
				// NSString * doclistEditor; // 编辑者名称 (扩展)
				// NSString * doclistArticleSource;// 来源(扩展)
				Article a = list.get(i);
				sb.append(JSON_START).append(quote("doclistDocID")).append(":").append(quote(a.getId())).append(",").append(quote("doclistTitle")).append(":").append(quote(a.getTitle())).append(",").append(quote("doclistFloor")).append(":").append(quote("")).append(",").append(quote("doclistPubDate")).append(":").append(quote(DateHelper.getDate(a.getCreateDate()))).append(",").append(quote("doclistAuthor")).append(":").append(quote(a.getSender())).append(",").append(quote("doclistLink")).append(":").append(quote(a.getDomain() == null ? a.getContentLink() : a.getDomain() + a.getContentLink())).append(",").append(quote("doclistCid")).append(":").append(a.getSection().getId()).append(",").append(quote("doclistDescription")).append(":").append(quote("")).append(",")
						.append(quote("doclistCategory")).append(":").append(quote(a.getSection().getName())).append(",").append(quote("doclistComments")).append(":").append(quote("")).append(",").append(quote("doclistImage")).append(":").append(quote(a.getTitleImage())).append(",").append(quote("doclistFocusImage")).append(":").append(quote(a.getFocusImage())).append(",").append(quote("doclistEditor")).append(":").append(quote(a.getEditor())).append(",").append(quote("doclistArticleSource")).append(":").append(quote(a.getSource())).append(JSON_END);
				if (i < len - 1)
					sb.append(",");

			}
		}
		sb.append(JSONARRAY_END);
		return sb.toString();
	}

	@SuppressWarnings("unchecked")
	@Override
	public String getDocList(String section, String startIndex, String offset, String activeKey) {
		Integer s = Integer.parseInt(startIndex);
		Integer c = Integer.parseInt(offset);
		List<Article> list =null;
		
		StringBuffer sb = new StringBuffer();
		if (section.equals("97") ||
				section.equals("121") ||
				section.equals("122") ||
				section.equals("123") ||
				section.equals("124") ||
				section.equals("125") ||
				section.equals("126") ||
				section.equals("127") ||
				section.equals("128") ||
				section.equals("228") ||
				section.equals("231") ||
				section.equals("232") ||
				section.equals("233") ||
				section.equals("234") ||
				section.equals("253") ||
				section.equals("257") ||
				section.equals("289"))
		{
			 list = getSession().createCriteria(ArticleMobileNews.class)
					.createAlias("state", "st")
					.add(Restrictions.eq("st.id", getOnlineState().getId()))
					.add(Restrictions.eq("section.id", Integer.parseInt(section)))
//					.add(Restrictions.lt("createDate", BaseTypeHelper.getDate("2013-04-13 12:00:00")))
					.setFirstResult(s).setMaxResults(c)
					.addOrder(Order.desc("topDate")).list();
		}
		else
		{
			 list = getSession().createCriteria(ArticleMobileNews.class)
					.createAlias("state", "st")
					.add(Restrictions.eq("st.id", getOnlineState().getId()))
					.add(Restrictions.eq("section.id", Integer.parseInt(section)))
					.add(Restrictions.lt("createDate", BaseTypeHelper.getDate("2013-04-13 12:00:00")))
					.setFirstResult(s).setMaxResults(c)
					.addOrder(Order.desc("topDate")).list();
		}
		sb.append(JSONARRAY_START);
		if (list != null && list.size() > 0) {
			int len = list.size();
			for (int i = 0; i < len; i++) {
				// NSString * doclistDocID; // 文档id
				// NSString * doclistTitle; // 内容标题
				// NSString * doclistFloor; // 文档层级
				// NSString * doclistPubDate; // 发布时间
				// NSString * doclistAuthor; // 作者
				// NSString * doclistLink; // 详细内容URL link和cid字段为互斥字段，
				// //
				// 当link不为空时，表示转向到内容的URL，当cid不为空时，表示当前内容为一个分类，点击时不离开列表，清空后重新刷新。
				// NSString * doclistCid; // 子栏目标识
				// NSString * doclistDescription; // 内容描述
				// NSString * doclistCategory; // 分类名称“新闻评论”
				// NSString * doclistComments; // 备注内容
				//
				// NSString * doclistImage; // 标题图片联接（扩展）
				// NSString * doclistFocusImage; // 焦点图片联接（扩展）
				// 如果列表中有此字段，则在焦点图片显示窗口显示该图
				// NSString * doclistEditor; // 编辑者名称 (扩展)
				// NSString * doclistArticleSource;// 来源(扩展)
				Article a = list.get(i);
				sb.append(JSON_START).append(quote("doclistDocID")).append(":").append(quote(a.getId())).append(",").append(quote("doclistTitle")).append(":").append(quote(a.getTitle())).append(",").append(quote("doclistFloor")).append(":").append(quote("")).append(",").append(quote("doclistPubDate")).append(":").append(quote(DateHelper.getDate(a.getCreateDate()))).append(",").append(quote("doclistAuthor")).append(":").append(quote(a.getSender())).append(",").append(quote("doclistLink")).append(":").append(quote(a.getDomain() == null ? a.getContentLink() : a.getDomain() + a.getContentLink())).append(",").append(quote("doclistCid")).append(":").append(a.getSection().getId()).append(",").append(quote("doclistDescription")).append(":").append(quote("")).append(",")
						.append(quote("doclistCategory")).append(":").append(quote(a.getSection().getName())).append(",").append(quote("doclistComments")).append(":").append(quote("")).append(",").append(quote("doclistImage")).append(":").append(quote(a.getTitleImage())).append(",").append(quote("doclistFocusImage")).append(":").append(quote(a.getFocusImage())).append(",").append(quote("doclistEditor")).append(":").append(quote(a.getEditor())).append(",").append(quote("doclistArticleSource")).append(":").append(quote(a.getSource())).append(JSON_END);
				if (i < len - 1)
					sb.append(",");

			}
		}
		sb.append(JSONARRAY_END);
		return sb.toString();
	}

	@Override
	public String getIndexFocus(String activeKey) {
		StringBuffer sb = new StringBuffer();
		List<SectionFocus> sf = getCriteria(SectionFocus.class).createAlias("section", "s").createAlias("state", "st").add(Restrictions.eq("s.id", 1)).add(Restrictions.eq("st.id", getOnlineState().getId())).addOrder(Order.desc("topDate")).list();
		Section s = (Section) getSession().get(Section.class, 1);
		if (s != null && sf.size() > 0) {
			// docID，文章ida
			// focusDocTitle ，标题
			// focusImageUrl ，图片地址
			// focusDocAddress 文章地址
			// focusDocDescription 文章描述
			sb.append(JSONARRAY_START);
			for (int j = 0; j < sf.size(); j++) {
				sb.append(JSON_START);
				SectionFocus f = sf.get(j);
				sb.append(quote("docID")).append(":").append(quote(f.getArticle() == null ? "" : f.getArticle().getId())).append(",").append(quote("focusDocTitle")).append(":").append(quote(f.getTitle())).append(",").append(quote("focusImageUrl")).append(":").append(quote(f.getImagePath())).append(",").append(quote("focusDocAddress")).append(":").append(quote(f.getArticle() != null ? f.getArticle().getContentLink() : "")).append(",").append(quote("focusCiteAddress")).append(":").append(quote(f.getLinkAddress())).append(",").append(quote("focusDocDescription")).append(":").append(quote(f.getContent())).append(JSON_END);
				if (j < sf.size() - 1)
					sb.append(",");
			}
			sb.append(JSONARRAY_END);
		}
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
				sb.append(quote("categoryProperty")).append(":").append(quote("")).append(",")
				.append(quote("categoryImageFileName")).append(":").append(quote(s.getMobileTitleImage())).append(",")
				.append(quote("categoryDocCount")).append(":").append(quote(s.getArticleCount())).append(",")
				.append(quote("categoryImageUrl")).append(":").append(quote(s.getMobileTitleImage())).append(",")
				.append(quote("focus")).append(":").append(JSONARRAY_START);
				List<SectionFocus> sectionFocus = session.createCriteria(SectionFocus.class).createAlias("section", "sec").createAlias("state", "st").add(Restrictions.eq("sec.id", s.getId())).add(Restrictions.eq("st.id", getOnlineState().getId())).list();
				// 如果父节点不是【i南充】就加入父节点的焦点
				if (s.getParent() != null && s.getParent().getId().intValue() != 1) {
					List<SectionFocus> ParentSectionFocus = session.createCriteria(SectionFocus.class).createAlias("section", "sec").createAlias("state", "st").add(Restrictions.eq("sec.id", s.getParent().getId())).add(Restrictions.eq("st.id", getOnlineState().getId())).list();
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
						SectionFocus f = sectionFocus.get(j);
						sb.append(quote("docID")).append(":").append(quote(f.getArticle() != null ? f.getArticle().getId() : "")).append(",").append(quote("focusDocTitle")).append(":").append(quote(f.getTitle())).append(",").append(quote("focusImageUrl")).append(":").append(quote(f.getImagePath())).append(",").append(quote("focusDocAddress")).append(":").append(quote(f.getArticle() != null ? f.getArticle().getContentLink() : "")).append(",").append(quote("focusCiteAddress")).append(":").append(quote(f.getLinkAddress())).append(",").append(quote("focusDocDescription")).append(":").append(quote(f.getContent())).append(JSON_END);
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

	@Override
	public void getResource(String type, String activeKey) {
		down(getWebRoot("resource/iPhone.zip"));
	}

	@Override
	public String getSectionFocus(String section, String activeKey) {
		
		StringBuffer sb = new StringBuffer();
		Session session = getSession();
		int id=Integer.parseInt(section);
		Section s=(Section) session.get(Section.class, id);
		sb.append(JSONARRAY_START);
		List<SectionFocus> sectionFocus = session.createCriteria(SectionFocus.class).createAlias("section", "sec").createAlias("state", "st").add(Restrictions.eq("sec.id", s.getId())).add(Restrictions.eq("st.id", getOnlineState().getId())).addOrder(Order.desc("topDate")).list();
		//如果父节点不是【i南充】就加入父节点的焦点
		
		if (s.getParent() != null && s.getParent().getId().intValue() != 1) {
			List<SectionFocus> ParentSectionFocus = session.createCriteria(SectionFocus.class).createAlias("section", "sec").createAlias("state", "st").add(Restrictions.eq("sec.id", s.getParent().getId())).add(Restrictions.eq("st.id", getOnlineState().getId())).addOrder(Order.desc("topDate")).list();
			if (ParentSectionFocus != null && ParentSectionFocus.size() > 0) {
				if (sectionFocus != null && sectionFocus.size() > 0)
					sectionFocus.addAll(0, ParentSectionFocus);
				else
					sectionFocus=ParentSectionFocus;
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
				SectionFocus f = sectionFocus.get(j);
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
		sb.append(JSONARRAY_END);
		return sb.toString();
	}
}
