package com.gang.action.mobile;

import com.gang.action.BaseAction;

import com.gang.comms.DateHelper;
import com.gang.comms.QQWryHelper;
import com.gang.comms.StringHelper;

import com.gang.entity.article.ArticleMobile;
import com.gang.entity.comment.ArticleMobileComment;
import com.gang.entity.user.User;

import com.gang.service.article.ArticleService;
import com.gang.service.qqwry.IPZone;
import com.gang.service.wssvc.Generator;
import com.gang.service.wssvc.JSONArrayGenerator;
import com.gang.service.wssvc.JSONGenerator;

import com.sun.xml.internal.ws.message.StringHeader;

import java.util.Date;
import java.util.List;


public class CMSServiceAction extends BaseAction {
    private String user_name;
    private String hash_password;
    private String active_key;
    private Integer doc_id;
    private String comment;
    private Integer page_index;
    private Integer page_size = 20;
    private ArticleService service;

    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
    }

    public Integer getPage_size() {
        return page_size;
    }

    public void setPage_size(Integer page_size) {
        this.page_size = page_size;
    }

    public Integer getPage_index() {
        return page_index;
    }

    public void setPage_index(Integer page_index) {
        this.page_index = page_index;
    }

    public ArticleService getService() {
        return service;
    }

    public void setService(ArticleService service) {
        this.service = service;
    }

    public String getUser_name() {
        return user_name;
    }

    public void setUser_name(String user_name) {
        this.user_name = user_name;
    }

    public String getHash_password() {
        return hash_password;
    }

    public void setHash_password(String hash_password) {
        this.hash_password = hash_password;
    }

    public String getActive_key() {
        return active_key;
    }

    public void setActive_key(String active_key) {
        this.active_key = active_key;
    }

    public Integer getDoc_id() {
        return doc_id;
    }

    public void setDoc_id(Integer doc_id) {
        this.doc_id = doc_id;
    }

    public void comment_add() {
        JSONGenerator result = Success;
        JSONGenerator json = new JSONGenerator();

        try {
            User user = service.get(User.class, "loginName", user_name);

            ArticleMobile article = service.get(ArticleMobile.class, doc_id);
            ArticleMobileComment amcomment = new ArticleMobileComment();

            amcomment.setArticle(article);
            amcomment.setAuditStatus(ArticleMobileComment.AUDIT_NONE);
            amcomment.setContent(comment);
            amcomment.setPostDate(new Date());
            String ip=getRequest().getRemoteAddr();
        	String location=QQWryHelper.getLocation(ip);
        	if(StringHelper.isBlank(location))
        	{
        		location="未知地区";
        	}
            if (user == null) {
                amcomment.setLocation(location);
            } else {
                amcomment.setUserName(user.getLoginName());
                amcomment.setNick(user.getNick());
                amcomment.setSex(user.getSex());
                amcomment.setHeader(user.getHeader());
                amcomment.setLocation(location);
            }

            service.save(amcomment);
            json.addGenerator(new Generator("result", result));
            json.addGenerator(new Generator("comment_id", amcomment.getId()));
            json.addGenerator(new Generator("content", amcomment.getContent()));
            json.addGenerator(new Generator("user_name", amcomment.getUserName()));
            json.addGenerator(new Generator("nick", amcomment.getNick()));
            json.addGenerator(new Generator("sex", amcomment.getSex()));
            json.addGenerator(new Generator("head", amcomment.getHeader()));
            json.addGenerator(new Generator("location", amcomment.getLocation()));
            json.addGenerator(new Generator("create_time", DateHelper.getDate(amcomment.getPostDate())));
        } catch (Exception e) {
            result = Error.addGenerator(new Generator("message", "后台错误"));
            json = new JSONGenerator();
            json.addGenerator(new Generator("result", result));
        }

        Write(json.toString());
    }

    public void comment_list() {
        JSONGenerator result = Success;
        JSONGenerator json = new JSONGenerator();

        try {
            List<ArticleMobileComment> list = service.getComments(doc_id, page_index, page_size);
            json.addGenerator(new Generator("result", result));

            if ((list != null) && (list.size() > 0)) {
                JSONArrayGenerator jsonComments = new JSONArrayGenerator();

                for (ArticleMobileComment comment : list) {
                    JSONGenerator jsonComment = new JSONGenerator();
                    jsonComment.addGenerator(new Generator("comment_id", comment.getId()));
                    jsonComment.addGenerator(new Generator("content", comment.getContent()));
                    jsonComment.addGenerator(new Generator("user_name", comment.getUserName()));
                    jsonComment.addGenerator(new Generator("nick", comment.getNick()));
                    jsonComment.addGenerator(new Generator("sex", comment.getSex()));
                    jsonComment.addGenerator(new Generator("head", comment.getHeader()));
                    jsonComment.addGenerator(new Generator("location", comment.getLocation()));
                    jsonComment.addGenerator(new Generator("create_time", DateHelper.getDate(comment.getPostDate())));
                    jsonComments.addGenerator(jsonComment);
                }

                json.addGenerator(new Generator("comment_list", jsonComments));
            }
        } catch (Exception e) {
            result = Error.addGenerator(new Generator("message", "后台错误"));
            json = new JSONGenerator();
            json.addGenerator(new Generator("result", result));
        }

        Write(json.toString());
    }

    public void comment_num() {
        JSONGenerator result = Success;
        JSONGenerator json = new JSONGenerator();

        try {
            Integer num = service.getCommentsCount(doc_id);
            json.addGenerator(new Generator("result", result));
            json.addGenerator(new Generator("doc_id", doc_id));
            json.addGenerator(new Generator("num", num));
        } catch (Exception e) {
            result = Error.addGenerator(new Generator("message", "后台错误"));
            json.addGenerator(new Generator("result", result));
        }

        Write(json.toString());
    }
}
