package com.gang.service.wssvc;

import com.gang.comms.Base64;
import com.gang.comms.BaseTypeHelper;
import com.gang.comms.CollectionHelper;
import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;

import com.gang.entity.article.ArticleMobile;
import com.gang.entity.article.ArticleMobileGoods;
import com.gang.entity.article.ArticleMobileGoodsImage;
import com.gang.entity.article.ArticleMobileGoodsImageGroup;
import com.gang.entity.article.ArticleMobileGoodsVideo;
import com.gang.entity.article.ArticleMobileGoodsVideoGroup;
import com.gang.entity.article.ArticleMobileNews;
import com.gang.entity.article.ArticleMobileShopImage;
import com.gang.entity.article.ArticleMobileShopImageGroup;
import com.gang.entity.article.ArticleMobileShopVideo;
import com.gang.entity.article.ArticleMobileShopVideoGroup;
import com.gang.entity.statistics.ArticleMobileClickRate;
import com.gang.entity.statistics.ArticleMobileFocusClickRate;
import com.gang.entity.statistics.BaseClickRate;
import com.gang.entity.statistics.SectionClickRate;
import com.gang.entity.user.FrontUser;
import com.gang.entity.user.Terminal;
import com.gang.entity.user.User;
import com.gang.entity.user.UserImage;
import com.gang.entity.user.UserImageGroup;
import com.gang.entity.version.Version;

import com.gang.service.BaseService;

import org.acegisecurity.providers.encoding.Md5PasswordEncoder;
import org.acegisecurity.providers.encoding.PasswordEncoder;
import org.apache.cxf.transport.http.AbstractHTTPDestination;
import org.apache.struts2.ServletActionContext;

import org.hibernate.Criteria;
import org.hibernate.Query;
import org.hibernate.Session;

import org.hibernate.criterion.Restrictions;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import javax.annotation.Resource;
import javax.jws.WebParam;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.xml.ws.WebServiceContext;


public abstract class BaseCMSService
  extends BaseService
  implements ICMSService
{
	//~ Instance fields ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public static Map<String, String> Cache=new HashMap<String, String>(1);
	
	@Resource
	private WebServiceContext context;

	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public WebServiceContext getContext()
	{
		return context;
	}

	public void setContext(WebServiceContext context)
	{
		this.context = context;
	}
	public String getRealPath(String path)
	{
		HttpServletRequest request = (HttpServletRequest) context.getMessageContext().get(AbstractHTTPDestination.HTTP_REQUEST);
		return request
                .getRealPath (path) + "\\";
	}
	public String register(
	  String user_login_id,
	  String password,
	  String sex,
	  String nick,
	  String active_key)
	{
		Session  session = getSession();
		Criteria c = session.createCriteria(User.class);
		c.add(Restrictions.eq("loginName", user_login_id));

		User          user = (User) c.uniqueResult();
		JSONGenerator mainGenerator = new JSONGenerator();
		JSONGenerator dataGenerator = new JSONGenerator();

		if (user == null)
		{
			String sql = "SELECT max(u.loginNumber) FROM User u";
			Object number = session.createQuery(sql)
				                     .uniqueResult();

			if (number == null)
			{
				number = "10000";
			}
			else
			{
				number = Integer.parseInt(number.toString()) + 1 + "";
			}

			user = new User();

			PasswordEncoder encoder = new Md5PasswordEncoder();
			user.setLoginName(user_login_id);
			user.setLoginPassword(encoder.encodePassword(password, null));
			user.setSex(sex);
			user.setNick(nick);
			user.setActiveKey(active_key);
			user.setLoginNumber(number.toString());
			session.save(user);
			mainGenerator.addGenerator(new Generator("retcode", "0"))
			             .addGenerator(new Generator("msg", "注册成功"));
			dataGenerator.addGenerator(new Generator("id", user.getLoginNumber()))
			             .addGenerator(new Generator("nick", user.getNick()))
			             .addGenerator(new Generator("image_head", user.getHeader()))
			             .addGenerator(new Generator("sex ", user.getSex()))
			             .addGenerator(new Generator("signature", user.getSignature()));
			mainGenerator.addGenerator(new Generator("data", dataGenerator));
		}
		else
		{
			mainGenerator.addGenerator(new Generator("retcode", "1"));
			mainGenerator.addGenerator(new Generator("msg", "用户名已存在"));
			dataGenerator.addGenerator(new Generator("id", null));
			dataGenerator.addGenerator(new Generator("nick", null));
			dataGenerator.addGenerator(new Generator("image_head", null));
			dataGenerator.addGenerator(new Generator("sex ", null));
			dataGenerator.addGenerator(new Generator("signature", null));
			mainGenerator.addGenerator(new Generator("data", dataGenerator));
		}

		return mainGenerator.toString();
	}

	public String get_userdetail(
	  String user_id,
	  String user_login_id)
	{
		Session  session = getSession();
		Criteria c = session.createCriteria(User.class);

		if (StringHelper.isNotBlank(user_id))
		{
			c.add(Restrictions.eq("id", Integer.parseInt(user_id)));
		}

		if (StringHelper.isNotBlank(user_login_id))
		{
			c.add(Restrictions.eq("loginName", user_login_id));
		}

		User          user = (User) c.uniqueResult();
		JSONGenerator generator = new JSONGenerator();
		generator.addGenerator(new Generator("id", user.getId()));
		generator.addGenerator(new Generator("login_id", user.getLoginName()));
		generator.addGenerator(new Generator("nick", user.getNick()));
		generator.addGenerator(new Generator("sex", user.getSex()));
		generator.addGenerator(new Generator("image_head", user.getHeader()));

		if ((user.getImageGroups() != null) && (user.getImageGroups()
			                                            .size() > 0))
		{
			JSONArrayGenerator images = new JSONArrayGenerator();

			for (UserImageGroup group : user.getImageGroups())
			{
				JSONGenerator image = new JSONGenerator();
				image.addGenerator(new Generator("group_name", group.getGroupName()));

				if ((group.getImages() != null) && (group.getImages()
					                                         .size() > 0))
				{
					JSONArrayGenerator details = new JSONArrayGenerator();

					for (UserImage img : group.getImages())
					{
						JSONGenerator detail = new JSONGenerator();
						detail.addGenerator(new Generator("image_url", img.getUrl()));
						detail.addGenerator(new Generator("image_desc", img.getUrl()));
						details.addGenerator(detail);
					}

					image.addGenerator(new Generator("group_items", details));
				}

				images.addGenerator(image);
			}

			generator.addGenerator(new Generator("image_album", images));
		}

		generator.addGenerator(new Generator("birth_day", user.getBirthday()));
		generator.addGenerator(new Generator("birth_month", user.getBirthmonth()));
		generator.addGenerator(new Generator("birth_year", user.getBirthyear()));
		generator.addGenerator(new Generator("age", user.getAge()));
		generator.addGenerator(new Generator("country", user.getCountry()));
		generator.addGenerator(new Generator("province", user.getProvince()));
		generator.addGenerator(new Generator("city", user.getCity()));
		generator.addGenerator(new Generator("profession", user.getPrefession()));
		generator.addGenerator(new Generator("favorite ", user.getFavorite()));
		generator.addGenerator(new Generator("company ", user.getCompany()));
		generator.addGenerator(new Generator("school  ", user.getSchool()));
		generator.addGenerator(new Generator("introduction ", user.getIntroduction()));
		generator.addGenerator(new Generator("signature", user.getSignature()));

		JSONGenerator positionGenerator = new JSONGenerator();
		positionGenerator.addGenerator(new Generator("longitude ", user.getLatestLongitude()))
		                 .addGenerator(new Generator("latitude", user.getLatestLatitude()));
		generator.addGenerator(new Generator("latest_position", positionGenerator));

		return generator.toString();
	}

	public String get_userbrief(
	  String user_id,
	  String user_login_id)
	{
		Session  session = getSession();
		Criteria c = session.createCriteria(User.class);

		if (StringHelper.isNotBlank(user_id))
		{
			c.add(Restrictions.eq("id", Integer.parseInt(user_id)));
		}

		if (StringHelper.isNotBlank(user_login_id))
		{
			c.add(Restrictions.eq("loginName", user_login_id));
		}

		User          user = (User) c.uniqueResult();
		JSONGenerator generator = new JSONGenerator();
		generator.addGenerator(new Generator("id", user.getId()));
		generator.addGenerator(new Generator("login_id", user.getLoginName()));
		generator.addGenerator(new Generator("nick", user.getNick()));
		generator.addGenerator(new Generator("sex", user.getSex()));
		generator.addGenerator(new Generator("image_head", user.getHeader()));
		generator.addGenerator(new Generator("signature", user.getSignature()));

		JSONGenerator positionGenerator = new JSONGenerator();
		positionGenerator.addGenerator(new Generator("longitude ", user.getLatestLongitude()))
		                 .addGenerator(new Generator("latitude", user.getLatestLatitude()));
		generator.addGenerator(new Generator("latest_position", positionGenerator));

		return generator.toString();
	}

	public String search_users(
	  String user_id,
	  String user_login_id,
	  String nick,
	  String sex,
	  String min_age,
	  String max_age,
	  String login_time,
	  String is_nearby)
	{
		Session  session = getSession();
		Criteria c = session.createCriteria(User.class);

		if (StringHelper.isNotBlank(user_id))
		{
			c.add(Restrictions.eq("id", Integer.parseInt(user_id)));
		}

		if (StringHelper.isNotBlank(user_login_id))
		{
			c.add(Restrictions.eq("loginName", user_login_id));
		}

		User user = (User) c.uniqueResult();

		String lat = StringHelper.getString(user.getLatestLatitude(), true);
		String lon = StringHelper.getString(user.getLatestLongitude(), true);
		StringBuffer sql = new StringBuffer("SELECT * FROM `USER` u WHERE u.id IS NOT NULL ");

		if (StringHelper.isNotBlank(nick))
		{
			sql.append(" AND u.nick like '%")
			   .append(nick)
			   .append("%' ");
		}

		if (StringHelper.isNotBlank(sex))
		{
			sql.append(" AND u.sex = '")
			   .append(nick)
			   .append("' ");
		}

		if (StringHelper.isNotBlank(min_age))
		{
			sql.append(" AND u.age >= '")
			   .append(min_age)
			   .append("' ");
		}

		if (StringHelper.isNotBlank(max_age))
		{
			sql.append(" AND u.age <= '")
			   .append(max_age)
			   .append("' ");
		}

		if (StringHelper.isNotBlank(is_nearby) && is_nearby.equals("1"))
		{
			sql.append("ORDER BY SQRT((u.`latestLatitude`- ")
			   .append(lat)
			   .append(")*(u.`latestLatitude`-")
			   .append(lat)
			   .append(" )+(u.`latestLongitude`-")
			   .append(lon)
			   .append(")*(u.`latestLongitude`-")
			   .append(lon)
			   .append(")) ASC");
		}

		Query              q = session.createSQLQuery(sql.toString())
			                            .addEntity(User.class);
		List<User>         users = q.list();
		JSONArrayGenerator jsonArrayGenerator = new JSONArrayGenerator();

		for (User u : users)
		{
			JSONGenerator generator = new JSONGenerator();
			generator.addGenerator(new Generator("id", u.getId()));
			generator.addGenerator(new Generator("login_id", u.getLoginName()));
			generator.addGenerator(new Generator("nick", u.getNick()));
			generator.addGenerator(new Generator("sex", u.getSex()));
			generator.addGenerator(new Generator("image_head", u.getHeader()));
			generator.addGenerator(new Generator("signature", u.getSignature()));

			JSONGenerator positionGenerator = new JSONGenerator();
			positionGenerator.addGenerator(new Generator("longitude ", user.getLatestLongitude()))
			                 .addGenerator(new Generator("latitude", user.getLatestLatitude()));
			generator.addGenerator(new Generator("latest_position", positionGenerator));
			jsonArrayGenerator.addGenerator(generator);
		}

		return jsonArrayGenerator.toString();
	}

	@Override
	public String active_terminal(
	  String device_code,
	  String height,
	  String width,
	  String os_type,
	  String os_version,
	  String soft_type,
	  String soft_version,
	  String spread_code)
	{
		Terminal terminal = null;
		Session session=getSession();
		terminal=(Terminal) session.createCriteria(Terminal.class).add(Restrictions.eq("deviceCode", device_code)).uniqueResult();
		if(terminal==null)
		{
			terminal=new Terminal();
		}
		terminal.setDeviceCode(device_code);
		terminal.setHeight(BaseTypeHelper.getInteger(height));
		terminal.setWidth(BaseTypeHelper.getInteger(width));
		terminal.setOsType(os_type);
		terminal.setOsVersion(os_version);
		terminal.setSoftType(soft_type);
		terminal.setSoftVersion(soft_version);
		terminal.setSpreadCode(spread_code);
		String activeKey = device_code + os_type + os_version;
		activeKey = Base64.encode(activeKey.getBytes());
		terminal.setUniqueCode(activeKey);
		session.saveOrUpdate(terminal);

		JSONGenerator g = new JSONGenerator();
		g.addGenerator(new Generator("active", terminal.getUniqueCode()));

		return g.toString();
	}

	@Override
	public String update_userinfo(String json_userinfo)
	{
		Session       session = getSession();
		JSONGenerator json = new JSONGenerator();

		try
		{
			FrontUser user = JSONHelper.Deserialize(json_userinfo, FrontUser.class);
			FrontUser old = (FrontUser) session.createCriteria(FrontUser.class)
				                                 .add(Restrictions.eq("nickName", user.getNickName()))
				                                 .uniqueResult();

			if (old == null)
			{
				session.update(user);
				json.addGenerator(new Generator("retcode ", "0"))
				    .addGenerator(new Generator("msg", "更新成功"));
			}
			else
			{
				json.addGenerator(new Generator("retcode ", "1"))
				    .addGenerator(new Generator("msg", "昵称已经存在"));
			}
		}
		catch (Exception e)
		{
			json.addGenerator(new Generator("retcode ", "2"))
			    .addGenerator(new Generator("msg", "服务器更新出错"));
		}

		return json.toString();
	}

	public JSONArrayGenerator getGoodImages(List<ArticleMobileGoodsImageGroup> imageGroups)
	{
		JSONArrayGenerator groups = new JSONArrayGenerator();

		if (CollectionHelper.isNotEmpty(imageGroups))
		{
			for (ArticleMobileGoodsImageGroup g : imageGroups)
			{
				JSONGenerator group = new JSONGenerator();
				group.addGenerator(new Generator("group_name", g.getName()));

				if (CollectionHelper.isNotEmpty(g.getImages()))
				{
					JSONArrayGenerator images = new JSONArrayGenerator();

					for (ArticleMobileGoodsImage img : g.getImages())
					{
						JSONGenerator image = new JSONGenerator();
						image.addGenerator(new Generator("image_url", img.getUrl()));
						image.addGenerator(new Generator("image_des", img.getDes()));
						images.addGenerator(image);
					}

					group.addGenerator(new Generator("group_items", images));
				}

				groups.addGenerator(group);
			}
		}

		return groups;
	}

	public JSONArrayGenerator getGoodVideos(List<ArticleMobileGoodsVideoGroup> videoGroups)
	{
		JSONArrayGenerator groups = new JSONArrayGenerator();

		if (CollectionHelper.isNotEmpty(videoGroups))
		{
			for (ArticleMobileGoodsVideoGroup g : videoGroups)
			{
				JSONGenerator group = new JSONGenerator();
				group.addGenerator(new Generator("group_name", g.getName()));

				if (CollectionHelper.isNotEmpty(g.getVideos()))
				{
					JSONArrayGenerator videos = new JSONArrayGenerator();

					for (ArticleMobileGoodsVideo v : g.getVideos())
					{
						JSONGenerator video = new JSONGenerator();
						video.addGenerator(new Generator("video_url", v.getUrl()));
						video.addGenerator(new Generator("video_des", v.getDes()));
						videos.addGenerator(video);
					}

					group.addGenerator(new Generator("group_items", videos));
				}

				groups.addGenerator(group);
			}
		}

		return groups;
	}

	public JSONArrayGenerator getShopImages(List<ArticleMobileShopImageGroup> imageGroups)
	{
		JSONArrayGenerator groups = new JSONArrayGenerator();

		if (CollectionHelper.isNotEmpty(imageGroups))
		{
			for (ArticleMobileShopImageGroup g : imageGroups)
			{
				JSONGenerator group = new JSONGenerator();
				group.addGenerator(new Generator("group_name", g.getName()));

				if (CollectionHelper.isNotEmpty(g.getImages()))
				{
					JSONArrayGenerator images = new JSONArrayGenerator();

					for (ArticleMobileShopImage img : g.getImages())
					{
						JSONGenerator image = new JSONGenerator();
						image.addGenerator(new Generator("url", img.getUrl()));
						image.addGenerator(new Generator("des", img.getDes()));
						images.addGenerator(image);
					}

					group.addGenerator(new Generator("group_items", images));
				}

				groups.addGenerator(group);
			}
		}

		return groups;
	}

	public JSONArrayGenerator getShopVideos(List<ArticleMobileShopVideoGroup> videoGroups)
	{
		JSONArrayGenerator groups = new JSONArrayGenerator();

		if (CollectionHelper.isNotEmpty(videoGroups))
		{
			for (ArticleMobileShopVideoGroup g : videoGroups)
			{
				JSONGenerator group = new JSONGenerator();
				group.addGenerator(new Generator("group_name", g.getName()));

				if (CollectionHelper.isNotEmpty(g.getVideos()))
				{
					JSONArrayGenerator videos = new JSONArrayGenerator();

					for (ArticleMobileShopVideo v : g.getVideos())
					{
						JSONGenerator video = new JSONGenerator();
						video.addGenerator(new Generator("url", v.getUrl()));
						video.addGenerator(new Generator("des", v.getDes()));
						videos.addGenerator(video);
					}

					group.addGenerator(new Generator("group_items", videos));
				}

				groups.addGenerator(group);
			}
		}

		return groups;
	}

	public JSONArrayGenerator getRelatedNews(List<ArticleMobileNews> relatedNews)
	{
		JSONArrayGenerator rnss = new JSONArrayGenerator();

		if (CollectionHelper.isNotEmpty(relatedNews))
		{
			for (ArticleMobileNews n : relatedNews)
			{
				JSONGenerator news = new JSONGenerator();
				news.addGenerator(new Generator("id", n.getId()))
				    .addGenerator(new Generator("name", n.getTitle()))
				    .addGenerator(new Generator("description", n.getSummary()))
				    .addGenerator(new Generator("image_url", n.getTitleImage()))
				    .addGenerator(new Generator("url", n.getContentLink()));
				rnss.addGenerator(news);
			}
		}

		return rnss;
	}

	public JSONArrayGenerator getRelatedGoods(List<ArticleMobileGoods> relatedGoods)
	{
		JSONArrayGenerator rpss = new JSONArrayGenerator();

		if (CollectionHelper.isNotEmpty(relatedGoods))
		{
			for (ArticleMobileGoods g : relatedGoods)
			{
				JSONGenerator p = new JSONGenerator();
				p.addGenerator(new Generator("id", g.getId()))
				 .addGenerator(new Generator("image_head", g.getHeader()))
				 .addGenerator(new Generator("name", g.getTitle()));
				rpss.addGenerator(p);
			}
		}

		return rpss;
	}

	public JSONArrayGenerator getRelated(List<ArticleMobile> relatedArticles)
	{
		JSONArrayGenerator array = new JSONArrayGenerator();

		if (CollectionHelper.isNotEmpty(relatedArticles))
		{
			for (ArticleMobile am : relatedArticles)
			{
				JSONGenerator json = new JSONGenerator();

				json.addGenerator(new Generator("id", am.getId()))
				    .addGenerator(new Generator("name", am.getTitle()))
				    .addGenerator(new Generator("image_url", am.getTitleImage()))
				    .addGenerator(new Generator("type", getProperty(am.getContentTemplate(), "getCode")))
				    .addGenerator(new Generator("content_style", getProperty(am.getContentShowType(), "getCode")))
				    .addGenerator(new Generator("version", am.getVersion()))
				    .addGenerator(new Generator("extern_url", am.getContentLink()));
				array.addGenerator(json);
			}
		}

		return array;
	}

	protected Integer getCategoryArticleCount(Integer category)
	{
		String  sql = "SELECT COUNT(id) FROM articlemobile WHERE sectionid=:category";
		Session session = getSession();
		Query   q = session.createSQLQuery(sql)
			                 .setInteger("category", category);
		Object  c = q.uniqueResult();

		return Integer.parseInt(c.toString());
	}

	protected void addClickCount(
	  Session   session,
	  ClickType type,
	  String    clickId,
	  String    deviceType,
	  String    activeKey,
	  String    clickUser)
	{
		BaseClickRate click = null;

		if (ClickType.SECTION.equals(type))
		{
			click = new SectionClickRate();
		}
		else if (ClickType.ARTICLE.equals(type))
		{
			click = new ArticleMobileClickRate();
		}
		else if (ClickType.FOCUS.equals(type))
		{
			click = new ArticleMobileFocusClickRate();
		}

		click.setActiveKey(activeKey);
		click.setClickUser(BaseTypeHelper.getInteger(clickUser));
		click.setClickId(BaseTypeHelper.getInteger(clickId));
		click.setDeviceType(deviceType);
		session.save(click);
	}
	
	public String check_version(@WebParam(name = "type")String type,@WebParam(name = "activeKey")String activeKey)
	{
		String sql="SELECT * FROM VERSION WHERE equtype = '"+type+"' ORDER BY ID DESC LIMIT 1";
		Version v =(Version) getSession().createSQLQuery(sql).addEntity(Version.class).uniqueResult();
		if(v!=null && v.getVersion()!=null )
		{
			return JSONHelper.SerializeWithNeedAnnotation(v);
		}
		return null;
	}
}
