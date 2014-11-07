package com.gang.service.wssvc;

import com.gang.comms.BaseTypeHelper;
import com.gang.comms.CollectionHelper;
import com.gang.comms.JSONHelper;
import com.gang.comms.StringHelper;

import com.gang.entity.article.Article;
import com.gang.entity.article.ArticleMobile;
import com.gang.entity.article.ArticleMobileGoods;
import com.gang.entity.article.ArticleMobileLink;
import com.gang.entity.article.ArticleMobileNews;
import com.gang.entity.article.ArticleMobileShop;
import com.gang.entity.message.Message;
import com.gang.entity.process.State;
import com.gang.entity.section.Section;
import com.gang.entity.section.SectionFocus;
import com.gang.entity.statistics.ArticleMobileClickRate;
import com.gang.entity.statistics.ArticleMobileFocusClickRate;
import com.gang.entity.statistics.BaseClickRate;
import com.gang.entity.statistics.OfflineClickRate;
import com.gang.entity.statistics.SectionClickRate;

import com.gang.service.template.GetDateTemplateMethodModel;

import com.google.gson.reflect.TypeToken;

import freemarker.ext.script.FreeMarkerScriptConstants;

import org.apache.commons.lang.StringUtils;

import org.apache.oro.text.regex.MalformedPatternException;
import org.apache.oro.text.regex.MatchResult;
import org.apache.oro.text.regex.Pattern;
import org.apache.oro.text.regex.PatternMatcherInput;
import org.apache.oro.text.regex.Perl5Compiler;
import org.apache.oro.text.regex.Perl5Matcher;

import org.hibernate.Criteria;
import org.hibernate.Query;
import org.hibernate.Session;

import org.hibernate.criterion.Order;
import org.hibernate.criterion.Restrictions;

import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.InputStreamReader;

import java.lang.reflect.Type;

import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;

import java.nio.charset.Charset;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;

import javax.script.Bindings;
import javax.script.ScriptEngine;
import javax.script.ScriptEngineManager;


@javax.jws.WebService(endpointInterface = "com.gang.service.wssvc.ICMSService", targetNamespace = "http://tanjun1536.cn")
public class CMSService extends BaseCMSService implements ICMSService {
    @Override
    public String get_channels(String id, String soft_type, String active_key,
        String user_id) {
        String sql = null;

        if (id.equals("0")) {
            sql = "FROM com.gang.entity.section.Section s WHERE s.parent.id=1   ORDER BY s.orderNumber";
        } else {
            sql = "FROM com.gang.entity.section.Section s WHERE s.id=" + id +
                "   ORDER BY s.orderNumber";
        }

        Session session = getSession();
        Query q = session.createQuery(sql);
        List<Section> list = q.list();
        JSONArrayGenerator array = new JSONArrayGenerator();

        if (CollectionHelper.isNotEmpty(list)) {
            for (Section s : list) {
                JSONGenerator json = new JSONGenerator();
                json.addGenerator(new Generator("id", s.getId()))
                    .addGenerator(new Generator("name", s.getText()))
                    .addGenerator(new Generator("group_name",
                        s.getSectionType().getName()))
                    .addGenerator(new Generator("group_id",
                        s.getSectionType().getId()))
                    .addGenerator(new Generator("category_style",
                        s.getShowType().getCode()))
                    .addGenerator(new Generator("description", ""))
                    .addGenerator(new Generator("ishot", s.getIsHot()))
                    .addGenerator(new Generator("isshow", s.getShown()))
                    .addGenerator(new Generator("image_url",
                        s.getMobileTitleImage()))
                    .addGenerator(new Generator("extern_url", ""));
                array.addGenerator(json);
            }
        }

        if (!id.equals("0")) {
            addClickCount(session, ClickType.SECTION, id, soft_type,
                active_key, user_id);
        }

        return array.toString();
    }

    @Override
    public String get_focus(String parent_id, String soft_type,
        String active_key, String user_id) {
        StringBuffer sql = new StringBuffer();
        StringBuffer psql = null;
        State onlineState = getOnlineState();
        Session session = getSession();

        sql.append(" FROM SectionFocus sf WHERE sf.state.id=")
           .append(onlineState.getId()).append(" AND sf.section.id= ");

        if (parent_id.equals("0")) {
            sql.append(1);
        } else {
            Section s = (Section) session.get(Section.class,
                    BaseTypeHelper.getInteger(parent_id));
            Section c = s.getParent();
            Integer id = c.getId();

            if (id != 1) {
                psql = new StringBuffer(sql);

                while ((c != null) && (id != 1)) {
                    s = c;
                    c = c.getParent();
                    id = c.getId();
                }

                psql.append(s.getId());
                psql.append(" ORDER BY sf.topDate desc");
            }

            sql.append(parent_id);
        }

        sql.append(" ORDER BY sf.topDate desc");

        Query q = session.createQuery(sql.toString());

        JSONArrayGenerator array = new JSONArrayGenerator();

        List<SectionFocus> list = q.list();

        if (psql != null) {
            Query cq = session.createQuery(psql.toString());
            List<SectionFocus> clist = cq.list();

            if (list == null) {
                list = clist;
            } else {
                list.addAll(clist);
            }
        }

        if (CollectionHelper.isNotEmpty(list)) {
            for (SectionFocus sf : list) {
                Object cs = getProperty(getProperty(sf.getArticle(),
                            "getContentShowType"), "getCode");
                Object url = getProperty(sf.getArticle(), "getContentLink");
                JSONGenerator json = new JSONGenerator();
                json.addGenerator(new Generator("id", sf.getId()))
                    .addGenerator(new Generator("doc_id",
                        getProperty(sf.getArticle(), "getId")))
                    .addGenerator(new Generator("parent_id",
                        sf.getSection().getId()))
                    .addGenerator(new Generator("content_style",
                        (cs == null) ? 70 : cs))
                    .addGenerator(new Generator("title", sf.getTitle()))
                    .addGenerator(new Generator("description", sf.getContent()))
                    .addGenerator(new Generator("image_url", sf.getImagePath()))
                    .addGenerator(new Generator("version",
                        getProperty(sf.getArticle(), "getVersion")))
                    .addGenerator(new Generator("type",
                        getProperty(getProperty(sf.getArticle(),
                                "getContentType"), "getCode")))
                    .addGenerator(new Generator("extern_url",
                        (url == null) ? sf.getLinkAddress() : url));
                array.addGenerator(json);
            }
        }

        return array.toString();
    }

    @Override
    public String get_categories(String parent_id, String soft_type,
        String active_key, String user_id) {
        StringBuffer sql = new StringBuffer();
        sql.append(" FROM Section s WHERE s.shown=true AND s.parent.id = ")
           .append(parent_id).append(" ORDER BY s.orderNumber asc");

        Session session = getSession();
        Query q = session.createQuery(sql.toString());
        List<Section> list = q.list();
        JSONArrayGenerator array = new JSONArrayGenerator();

        if (CollectionHelper.isNotEmpty(list)) {
            for (Section s : list) {
                JSONGenerator json = new JSONGenerator();
                json.addGenerator(new Generator("id", s.getId()))
                    .addGenerator(new Generator("parent_id", parent_id))
                    .addGenerator(new Generator("title", s.getText()))
                    .addGenerator(new Generator("category_style",
                        s.getShowType().getCode()))
                    .addGenerator(new Generator("type", 20))
                    .addGenerator(new Generator("image_url",
                        s.getMobileTitleImage()))
                    .addGenerator(new Generator("isshow", s.getShown()))
                    .addGenerator(new Generator("doc_total",
                        getCategoryArticleCount(s.getId())));

                json.addGenerator(new Generator("children",
                        get_categories_(s.getId().toString(), soft_type,
                            active_key, user_id)));
                array.addGenerator(json);
            }
        }

        addClickCount(session, ClickType.SECTION, parent_id, soft_type,
            active_key, user_id);

        return array.toString();
    }

    public String get_categories_(String parent_id, String soft_type,
        String active_key, String user_id) {
        StringBuffer sql = new StringBuffer();
        sql.append(" FROM Section s WHERE s.shown=true AND s.parent.id = ")
           .append(parent_id).append(" ORDER BY s.orderNumber asc");

        Session session = getSession();
        Query q = session.createQuery(sql.toString());
        List<Section> list = q.list();
        JSONArrayGenerator array = new JSONArrayGenerator();

        if (CollectionHelper.isNotEmpty(list)) {
            for (Section s : list) {
                JSONGenerator json = new JSONGenerator();
                json.addGenerator(new Generator("id", s.getId()))
                    .addGenerator(new Generator("parent_id", parent_id))
                    .addGenerator(new Generator("title", s.getText()))
                    .addGenerator(new Generator("category_style",
                        s.getShowType().getCode()))
                    .addGenerator(new Generator("type", 20))
                    .addGenerator(new Generator("image_url",
                        s.getMobileTitleImage()))
                    .addGenerator(new Generator("doc_total",
                        getCategoryArticleCount(s.getId())));

                json.addGenerator(new Generator("children",
                        get_categories_(s.getId().toString(), soft_type,
                            active_key, user_id)));
                array.addGenerator(json);
            }
        }

        addClickCount(session, ClickType.SECTION, parent_id, soft_type,
            active_key, user_id);

        return array.toString();
    }

    @SuppressWarnings("unchecked")
    @Override
    public String get_doclist(String parent_id, String startIndex,
        String offset, String soft_type, String active_key, String user_id) {
        Integer s = Integer.parseInt(startIndex);
        Integer c = Integer.parseInt(offset);
        Session session = getSession();
        List<ArticleMobile> list = null;

        if (parent_id.equals("97") || parent_id.equals("121") ||
                parent_id.equals("122") || parent_id.equals("123") ||
                parent_id.equals("124") || parent_id.equals("125") ||
                parent_id.equals("126") || parent_id.equals("127") ||
                parent_id.equals("128") || parent_id.equals("228") ||
                parent_id.equals("231") || parent_id.equals("232") ||
                parent_id.equals("233") || parent_id.equals("234") ||
                parent_id.equals("253") || parent_id.equals("257") ||
                parent_id.equals("289")) {
            list = session.createCriteria(ArticleMobile.class)
                          .createAlias("state", "st")
                          .add(Restrictions.eq("st.id", getOnlineState().getId()))
                          .add(Restrictions.eq("section.id",
                        Integer.parseInt(parent_id))).setFirstResult(s)
                          .setMaxResults(c).addOrder(Order.desc("topDate"))
                          .list();
        } else {
            list = session.createCriteria(ArticleMobile.class)
                          .createAlias("state", "st")
                          .add(Restrictions.eq("st.id", getOnlineState().getId()))
                          .add(Restrictions.eq("section.id",
                        Integer.parseInt(parent_id)))
                          .add(Restrictions.gt("createDate",
                        BaseTypeHelper.getDate("2013-04-13 12:00:00")))
                          .setFirstResult(s).setMaxResults(c)
                          .addOrder(Order.desc("topDate")).list();
        }

        JSONArrayGenerator array = new JSONArrayGenerator();
        Object description = null;

        if (CollectionHelper.isNotEmpty(list)) {
            for (ArticleMobile am : list) {
                if (am instanceof ArticleMobileShop ||
                        am instanceof ArticleMobileGoods) {
                    description = getProperty(am, "getDescription");
                } else {
                    description = getProperty(am, "getSummary");
                }

                JSONGenerator json = new JSONGenerator();
                json.addGenerator(new Generator("id", am.getId()))
                    .addGenerator(new Generator("category_id", parent_id))
                    .addGenerator(new Generator("category_name",
                        am.getSection().getText()))
                    .addGenerator(new Generator("title", am.getTitle()))
                    .addGenerator(new Generator("description", description))
                    .addGenerator(new Generator("type",
                        am.getContentType().getCode()))
                    .addGenerator(new Generator("content_style",
                        am.getContentShowType().getCode()))
                    .addGenerator(new Generator("publish_date",
                        am.getDistributeDate()))
                    .addGenerator(new Generator("comment_total",
                        getProperty(am.getComments(), "size")))
                    .addGenerator(new Generator("image_url", am.getTitleImage()))
                    .addGenerator(new Generator("source", am.getSource()))
                    .addGenerator(new Generator("version", am.getVersion()))
                    .addGenerator(new Generator("extern_url",
                        getProperty(am, "getContentLink")));

                if (am instanceof ArticleMobileShop) {
                    ArticleMobileShop ams = (ArticleMobileShop) am;
                    JSONGenerator di = new JSONGenerator();
                    JSONGenerator address = new JSONGenerator();
                    address.addGenerator(new Generator("city", ams.getCity()))
                           .addGenerator(new Generator("district",
                            ams.getDistrict()))
                           .addGenerator(new Generator("street", ams.getStreet()))
                           .addGenerator(new Generator("building",
                            ams.getBuilding()))
                           .addGenerator(new Generator("longitude",
                            ams.getLongitude()))
                           .addGenerator(new Generator("latitude",
                            ams.getLatitude()));
                    di.addGenerator(new Generator("telephone",
                            ams.getTelephone()))
                      .addGenerator(new Generator("address", address));
                    json.addGenerator(new Generator("detail_info", di));
                }

                array.addGenerator(json);
            }
        }

        addClickCount(session, ClickType.SECTION, parent_id, soft_type,
            active_key, user_id);

        return array.toString();
    }

    @Override
    public String get_doc(String id, String soft_type, String active_key,
        String user_id) {
        Article a = null;
        JSONGenerator json = new JSONGenerator();
        Session session = getSession();
        a = (Article) session.get(ArticleMobile.class,
                BaseTypeHelper.getInteger(id));

        if (a instanceof ArticleMobileNews || a instanceof ArticleMobileLink) {
            json.addGenerator(new Generator("id", a.getId()))
                .addGenerator(new Generator("type",
                    a.getContentTemplate().getCode()))
                .addGenerator(new Generator("content_style",
                    a.getContentShowType().getCode()))
                .addGenerator(new Generator("category_id",
                    a.getSection().getId()))
                .addGenerator(new Generator("category_name",
                    a.getSection().getText()))
                .addGenerator(new Generator("title", a.getTitle()))
                .addGenerator(new Generator("publish_date",
                    a.getDistributeDate()))
                .addGenerator(new Generator("doc_url", a.getContentLink()))
                .addGenerator(new Generator("source", a.getSource()))
                .addGenerator(new Generator("version", a.getVersion()))
                .addGenerator(new Generator("content_list",
                    HTMLPraser.parseJson(a.getContent()), false));
        } else if (a instanceof ArticleMobileGoods) {
            ArticleMobileGoods amg = (ArticleMobileGoods) a;
            json.addGenerator(new Generator("id", a.getId()))
                .addGenerator(new Generator("type",
                    a.getContentTemplate().getCode()))
                .addGenerator(new Generator("content_style",
                    a.getContentShowType().getCode()))
                .addGenerator(new Generator("name", a.getTitle()))
                .addGenerator(new Generator("image_head", amg.getTitleImage()))
                .addGenerator(new Generator("images",
                    getGoodImages(amg.getImagesGroups())))
                .addGenerator(new Generator("videos",
                    getGoodVideos(amg.getVideosGroups())))
                .addGenerator(new Generator("keyword", a.getKeywords()))
                .addGenerator(new Generator("des_basic", amg.getBasicDesc()))
                .addGenerator(new Generator("des_detail", amg.getDetailDesc()))
                .addGenerator(new Generator("version", a.getVersion()))
                .addGenerator(new Generator("description", amg.getDescription()))
                .addGenerator(new Generator("related",
                    getRelated(amg.getRelatedArticles())));
        } else if (a instanceof ArticleMobileShop) {
            ArticleMobileShop ams = (ArticleMobileShop) a;
            JSONGenerator address = new JSONGenerator();
            address.addGenerator(new Generator("city", ams.getCity()))
                   .addGenerator(new Generator("district", ams.getDistrict()))
                   .addGenerator(new Generator("street", ams.getStreet()))
                   .addGenerator(new Generator("building", ams.getBuilding()))
                   .addGenerator(new Generator("longitude", ams.getLongitude()))
                   .addGenerator(new Generator("latitude", ams.getLatitude()));
            json.addGenerator(new Generator("id", a.getId()))
                .addGenerator(new Generator("type",
                    a.getContentTemplate().getCode()))
                .addGenerator(new Generator("content_style",
                    a.getContentShowType().getCode()))
                .addGenerator(new Generator("name", a.getTitle()))
                .addGenerator(new Generator("image_head", ams.getTitleImage()))
                .addGenerator(new Generator("images",
                    getShopImages(ams.getImagesGroups())))
                .addGenerator(new Generator("videos",
                    getShopVideos(ams.getVideosGroups())))
                .addGenerator(new Generator("address", address))
                .addGenerator(new Generator("telephone", ams.getTelephone()))
                .addGenerator(new Generator("email", ams.getEmail()))
                .addGenerator(new Generator("qq", ams.getQq()))
                .addGenerator(new Generator("other_contact_info",
                    ams.getOtherContactInfo()))
                .addGenerator(new Generator("keyword", ams.getKeywords()))
                .addGenerator(new Generator("des_basic", ams.getBasicDesc()))
                .addGenerator(new Generator("des_detail", ams.getDetailDesc()))
                .addGenerator(new Generator("version", a.getVersion()))
                .addGenerator(new Generator("description", ams.getDescription()))
                .addGenerator(new Generator("related",
                    getRelated(ams.getRelatedArticles())));
        }

        addClickCount(session, ClickType.ARTICLE, id, soft_type, active_key,
            user_id);

        return json.toString();
    }

    public String get_doc_html(String id, String soft_type, String active_key,
        String user_id) {
        Session session = getSession();
        ArticleMobile am = (ArticleMobile) session.get(ArticleMobile.class,
                BaseTypeHelper.getInteger(id));
        String temp = getRealPath("resource/iPhone/Tmplate.html");
        StringBuilder TemplateHtml = new StringBuilder();
        String html = "";

        try {
            ArticleMobileNews amn = (ArticleMobileNews) am;

            if ((amn.getTextType() != null) && amn.getTextType().equals(1)) {
                html = changeImage(am.getContent());
            } else {
                InputStreamReader reader = new InputStreamReader(new FileInputStream(
                            temp), Charset.forName("UTF-8"));
                BufferedReader br = new BufferedReader(reader);
                String line = null;

                while ((line = br.readLine()) != null) {
                    TemplateHtml.append(line);
                }

                br.close();
                reader.close();

                ScriptEngineManager manager = new ScriptEngineManager();
                ScriptEngine engine = manager.getEngineByName("FreeMarker");

                Bindings bindings = engine.createBindings();
                bindings.put(FreeMarkerScriptConstants.STRING_OUTPUT,
                    Boolean.TRUE);

                String content = changeImage(am.getContent());
                bindings.put("content", am);
                bindings.put("zw", content);
                bindings.put("getDate", new GetDateTemplateMethodModel());

                html = engine.eval(TemplateHtml.toString(), bindings).toString();
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

        addClickCount(session, ClickType.ARTICLE, id, soft_type, active_key,
            user_id);

        return html;
    }

    private String changeImage(String content) {
        if (StringHelper.isBlank(content)) {
            return content;
        }

        String regex = "<img [^>]* />";
        String srcRegex = "src\\s*=\\s*\"([^\"]*)\"";
        Perl5Compiler compiler = new Perl5Compiler();
        Pattern pattern = null;
        Pattern srcPattern = null;

        try {
            pattern = compiler.compile(regex,
                    Perl5Compiler.CASE_INSENSITIVE_MASK);
            srcPattern = compiler.compile(srcRegex,
                    Perl5Compiler.CASE_INSENSITIVE_MASK);
        } catch (MalformedPatternException e) {
            e.printStackTrace();
        }

        Perl5Matcher matcher = new Perl5Matcher();
        PatternMatcherInput matcherInput = new PatternMatcherInput(content);

        while (matcher.contains(matcherInput, pattern)) {
            MatchResult result = matcher.getMatch();
            PatternMatcherInput input = new PatternMatcherInput(result.toString());

            if (matcher.contains(input, srcPattern)) {
                MatchResult src = matcher.getMatch();
                String img = src.group(1);

                if (StringHelper.isNotBlank(img)) {
                    content = content.replaceAll(srcRegex,
                            "src=\"../../../resource/html_image_default.jpg\"");
                }
            }
        }

        return content;
    }

    @Override
    public String upload_offline_statdata(String content) {
        JSONGenerator json = new JSONGenerator();

        try {
            Type typeOfT = new TypeToken<List<OfflineClickRate>>() {
                    }.getType();
            List<OfflineClickRate> list = JSONHelper.Deserialize(content,
                    typeOfT);

            if (CollectionHelper.isNotEmpty(list)) {
                BaseClickRate click = null;
                Session session = getSession();

                for (OfflineClickRate oc : list) {
                    Integer type = BaseTypeHelper.getInteger(oc.getType());

                    switch (type) {
                    case 10:
                        click = new SectionClickRate(oc);

                        break;

                    case 20:
                        click = new SectionClickRate(oc);

                        break;

                    case 30:
                        click = new ArticleMobileFocusClickRate();

                        break;

                    case 40:
                        click = new ArticleMobileClickRate(oc);

                        break;

                    case 50:
                        click = new ArticleMobileClickRate(oc);

                        break;

                    case 60:
                        click = new ArticleMobileClickRate(oc);

                        break;

                    case 70:
                        click = new ArticleMobileClickRate(oc);

                        break;
                    }

                    session.save(click);
                }
            }

            json.addGenerator(new Generator("retcode", 0));
            json.addGenerator(new Generator("msg", "成功"));
        } catch (Exception e) {
            json.addGenerator(new Generator("retcode", 1));
            json.addGenerator(new Generator("msg", "上传数据格式错误"));
        }

        return json.toString();
    }

    @Override
    public String search_doc(String parent_id, String startIndex,
        String offset, String soft_type, String active_key, String user_id,
        String keyword) {
        Integer s = Integer.parseInt(startIndex);
        Integer c = Integer.parseInt(offset);
        Session session = getSession();
        List<ArticleMobile> list = null;
        Criteria criteria = session.createCriteria(ArticleMobileShop.class);
        criteria.createAlias("state", "st");
        criteria.add(Restrictions.eq("st.id", getOnlineState().getId()));

        if (!"1".equals(parent_id)) {
            criteria.add(Restrictions.eq("section.id",
                    Integer.parseInt(parent_id)));
        }

        criteria.add(Restrictions.like("title", "%" + keyword + "%"));
        criteria.setFirstResult(s);
        criteria.setMaxResults(c);
        criteria.addOrder(Order.desc("topDate"));
        list = criteria.list();

        JSONArrayGenerator array = new JSONArrayGenerator();
        Object description = null;

        if (CollectionHelper.isNotEmpty(list)) {
            for (ArticleMobile am : list) {
                if (am instanceof ArticleMobileShop ||
                        am instanceof ArticleMobileGoods) {
                    description = getProperty(am, "getDescription");
                } else {
                    description = getProperty(am, "getSummary");
                }

                JSONGenerator json = new JSONGenerator();
                json.addGenerator(new Generator("id", am.getId()))
                    .addGenerator(new Generator("category_id",
                        am.getSection().getId()))
                    .addGenerator(new Generator("category_name",
                        am.getSection().getText()))
                    .addGenerator(new Generator("title", am.getTitle()))
                    .addGenerator(new Generator("description", description))
                    .addGenerator(new Generator("type",
                        am.getContentType().getCode()))
                    .addGenerator(new Generator("content_style",
                        am.getContentShowType().getCode()))
                    .addGenerator(new Generator("publish_date",
                        am.getDistributeDate()))
                    .addGenerator(new Generator("comment_total",
                        getProperty(am.getComments(), "size")))
                    .addGenerator(new Generator("image_url", am.getTitleImage()))
                    .addGenerator(new Generator("source", am.getSource()))
                    .addGenerator(new Generator("version", am.getVersion()))
                    .addGenerator(new Generator("extern_url",
                        getProperty(am, "getContentLink")));

                if (am instanceof ArticleMobileShop) {
                    ArticleMobileShop ams = (ArticleMobileShop) am;
                    JSONGenerator di = new JSONGenerator();
                    JSONGenerator address = new JSONGenerator();
                    address.addGenerator(new Generator("city", ams.getCity()))
                           .addGenerator(new Generator("district",
                            ams.getDistrict()))
                           .addGenerator(new Generator("street", ams.getStreet()))
                           .addGenerator(new Generator("building",
                            ams.getBuilding()))
                           .addGenerator(new Generator("longitude",
                            ams.getLongitude()))
                           .addGenerator(new Generator("latitude",
                            ams.getLatitude()));
                    di.addGenerator(new Generator("telephone",
                            ams.getTelephone()))
                      .addGenerator(new Generator("address", address));
                    json.addGenerator(new Generator("detail_info", di));
                }

                array.addGenerator(json);
            }
        }

        return array.toString();
    }

    @Override
    public String get_hot_message(String active_key, String user_id) {
        List<Integer> idList = getSession()
                                   .createQuery("SELECT h.articleId FROM ArticleMobileHot h Order by h.orderNumber")
                                   .list();
        String ids = StringUtils.join(idList.iterator(), ",");
        String sql = "FROM ArticleMobile a WHERE a.id in(" + ids +
            " ) order by field(id," + ids + ")";
        List<ArticleMobile> list = getSession().createQuery(sql).list();
        JSONArrayGenerator array = new JSONArrayGenerator();
        Object description = null;

        if (CollectionHelper.isNotEmpty(list)) {
            for (ArticleMobile am : list) {
                if (am instanceof ArticleMobileShop ||
                        am instanceof ArticleMobileGoods) {
                    description = getProperty(am, "getDescription");
                } else {
                    description = getProperty(am, "getSummary");
                }

                JSONGenerator json = new JSONGenerator();
                json.addGenerator(new Generator("id", am.getId()))
                    .addGenerator(new Generator("category_id",
                        am.getSection().getId()))
                    .addGenerator(new Generator("category_name",
                        am.getSection().getText()))
                    .addGenerator(new Generator("title", am.getTitle()))
                    .addGenerator(new Generator("description", description))
                    .addGenerator(new Generator("type",
                        am.getContentType().getCode()))
                    .addGenerator(new Generator("content_style",
                        am.getContentShowType().getCode()))
                    .addGenerator(new Generator("publish_date",
                        am.getDistributeDate()))
                    .addGenerator(new Generator("comment_total",
                        getProperty(am.getComments(), "size")))
                    .addGenerator(new Generator("image_url", am.getTitleImage()))
                    .addGenerator(new Generator("source", am.getSource()))
                    .addGenerator(new Generator("version", am.getVersion()))
                    .addGenerator(new Generator("extern_url",
                        getProperty(am, "getContentLink")));

                if (am instanceof ArticleMobileShop) {
                    ArticleMobileShop ams = (ArticleMobileShop) am;
                    JSONGenerator di = new JSONGenerator();
                    JSONGenerator address = new JSONGenerator();
                    address.addGenerator(new Generator("city", ams.getCity()))
                           .addGenerator(new Generator("district",
                            ams.getDistrict()))
                           .addGenerator(new Generator("street", ams.getStreet()))
                           .addGenerator(new Generator("building",
                            ams.getBuilding()))
                           .addGenerator(new Generator("longitude",
                            ams.getLongitude()))
                           .addGenerator(new Generator("latitude",
                            ams.getLatitude()));
                    di.addGenerator(new Generator("telephone",
                            ams.getTelephone()))
                      .addGenerator(new Generator("address", address));
                    json.addGenerator(new Generator("detail_info", di));
                }

                array.addGenerator(json);
            }
        }

        return array.toString();
    }

    @Override
    public String get_messagecenter_data(String start_index, String offset,
        String active_key, String user_id) {
        Integer s = Integer.parseInt(start_index);
        Integer c = Integer.parseInt(offset);
        Session session = getSession();
        List<Message> list = session.createCriteria(Message.class)
                                    .setFirstResult(s).setMaxResults(c)
                                    .addOrder(Order.desc("id")).list();

        JSONArrayGenerator array = new JSONArrayGenerator();
        Object description = null;

        if (CollectionHelper.isNotEmpty(list)) {
            for (Message message : list) {
                JSONGenerator json = new JSONGenerator();

                json.addGenerator(new Generator("date", message.getCreateDate()));

                JSONArrayGenerator articles = new JSONArrayGenerator();

                for (ArticleMobile am : message.getArticles()) {
                    if (am instanceof ArticleMobileShop ||
                            am instanceof ArticleMobileGoods) {
                        description = getProperty(am, "getDescription");
                    } else {
                        description = getProperty(am, "getSummary");
                    }

                    JSONGenerator article = new JSONGenerator();
                    article.addGenerator(new Generator("id", am.getId()))
                           .addGenerator(new Generator("category_id",
                            am.getSection().getId()))
                           .addGenerator(new Generator("category_name",
                            am.getSection().getText()))
                           .addGenerator(new Generator("title", am.getTitle()))
                           .addGenerator(new Generator("description",
                            description))
                           .addGenerator(new Generator("type",
                            am.getContentType().getCode()))
                           .addGenerator(new Generator("content_style",
                            am.getContentShowType().getCode()))
                           .addGenerator(new Generator("publish_date",
                            am.getDistributeDate()))
                           .addGenerator(new Generator("comment_total",
                            getProperty(am.getComments(), "size")))
                           .addGenerator(new Generator("image_url",
                            am.getTitleImage()))
                           .addGenerator(new Generator("source", am.getSource()))
                           .addGenerator(new Generator("version",
                            am.getVersion()))
                           .addGenerator(new Generator("extern_url",
                            getProperty(am, "getContentLink")));

                    if (am instanceof ArticleMobileShop) {
                        ArticleMobileShop ams = (ArticleMobileShop) am;
                        JSONGenerator di = new JSONGenerator();
                        JSONGenerator address = new JSONGenerator();
                        address.addGenerator(new Generator("city", ams.getCity()))
                               .addGenerator(new Generator("district",
                                ams.getDistrict()))
                               .addGenerator(new Generator("street",
                                ams.getStreet()))
                               .addGenerator(new Generator("building",
                                ams.getBuilding()))
                               .addGenerator(new Generator("longitude",
                                ams.getLongitude()))
                               .addGenerator(new Generator("latitude",
                                ams.getLatitude()));
                        di.addGenerator(new Generator("telephone",
                                ams.getTelephone()))
                          .addGenerator(new Generator("address", address));
                        article.addGenerator(new Generator("detail_info", di));
                    }

                    articles.addGenerator(article);
                }

                json.addGenerator(new Generator("msg", articles));

                array.addGenerator(json);
            }
        }

        return array.toString();
    }

    public String get_pm_2_5() {
        String api = "http://www.pm25.in/api/querys/pm2_5.json";
        String token = "5j1znBVAsnSf5xQyNQyq";
        String city = "nanchong";
        String url = new StringBuffer(api).append("?token=").append(token)
                                          .append("&city=").append(city)
                                          .toString();
        StringBuilder sb=new StringBuilder();
        SimpleDateFormat sdf=new SimpleDateFormat("yyyyMMdd");
        String key=sdf.format(new Date());
        if(Cache.containsKey(key))
        {
        	return Cache.get(key);
        }
        try {
            URL getUrl = new URL(url);

            // 根据拼凑的URL，打开连接，URL.openConnection函数会根据URL的类型，
            // 返回不同的URLConnection子类的对象，这里URL是一个http，因此实际返回的是HttpURLConnection
            HttpURLConnection connection = (HttpURLConnection) getUrl.openConnection();
            // 进行连接，但是实际上get request要在下一句的connection.getInputStream()函数中才会真正发到
            // 服务器
            connection.connect();

            // 取得输入流，并使用Reader读取
            BufferedReader reader = new BufferedReader(new InputStreamReader(
                        connection.getInputStream(), "utf-8")); // 设置编码,否则中文乱码

            String line;

            while ((line = reader.readLine()) != null) {
                // lines = new String(lines.getBytes(), "utf-8");
                sb.append(line);
            }
            Cache.put(key, sb.toString());
            reader.close();
            connection.disconnect();
        } catch (Exception e) {
        } finally {
        	
        }
        return sb.toString();
        		
    }
}
