package com.gang.entity.comment;

import java.util.Date;

import com.gang.entity.BaseEntity;
import com.gang.entity.article.ArticleMobile;
import com.google.gson.annotations.Expose;


/**
 * 手机文章评论
 * @author Administrator
 *
 */
public class ArticleMobileComment extends BaseEntity {
    /**
     * 通过
     */
    public static final String AUDIT_PASS = "pass";

    /**
     * 未通过
     */
    public static final String AUDIT_NO_PASS = "nopass";

    /**
     * 待审核
     */
    public static final String AUDIT_ING = "ing";

    /**
     * 不需要审核
     */
    public static final String AUDIT_NONE = "none";

    /**
     * 手机文章
     */
    @Expose
    private ArticleMobile article;

    /**
     * 用户
     */
    @Expose
    private String userName;
    @Expose
    private String nick;
    @Expose
    private String sex;
    @Expose
    private String header;
    @Expose
    private String location;

    
    public String getLocation() {
		return location;
	}

	public void setLocation(String location) {
		this.location = location;
	}

	/**
     * 标题
     */
    private String title;

    public String getHeader() {
		return header;
	}

	public void setHeader(String header) {
		this.header = header;
	}

	/**
     * 内容
     */
    @Expose
    private String content;

    /**
     * 发送时间
     */
    @Expose
    private Date postDate;

    /**
     * 审核状态
     */
    private String auditStatus;

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public String getNick() {
        return nick;
    }

    public void setNick(String nick) {
        this.nick = nick;
    }

    public String getSex() {
        return sex;
    }

    public void setSex(String sex) {
        this.sex = sex;
    }


    public static String getAuditPass() {
        return AUDIT_PASS;
    }

    public static String getAuditNoPass() {
        return AUDIT_NO_PASS;
    }

    public static String getAuditIng() {
        return AUDIT_ING;
    }

    public static String getAuditNone() {
        return AUDIT_NONE;
    }

    public ArticleMobile getArticle() {
        return article;
    }

    public void setArticle(ArticleMobile article) {
        this.article = article;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public Date getPostDate() {
        return postDate;
    }

    public void setPostDate(Date postDate) {
        this.postDate = postDate;
    }

    public String getAuditStatus() {
        return auditStatus;
    }

    public void setAuditStatus(String auditStatus) {
        this.auditStatus = auditStatus;
    }
}
