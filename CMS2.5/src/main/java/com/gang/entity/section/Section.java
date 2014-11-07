package com.gang.entity.section;

import java.util.Date;
import java.util.Set;

import com.gang.entity.BaseEntity;
import com.gang.entity.article.Article;
import com.gang.entity.image.ImageInfo;
import com.gang.entity.role.Role;
import com.google.gson.annotations.Expose;
import com.thoughtworks.xstream.annotations.XStreamAsAttribute;
import com.thoughtworks.xstream.annotations.XStreamImplicit;
import com.thoughtworks.xstream.annotations.XStreamOmitField;

public class Section extends BaseEntity {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	/**
	 * 适用终端
	 */
	@Expose
	private SectionAdapter adapterTerminal;
	/**
	 * 文章数
	 */
	@Expose
	private Integer articleCount=0;
	/**
	 * 文章集合
	 */
	@XStreamOmitField
	private Set<Article> articleMobiles;
	@XStreamOmitField
	private Set<Article> articlePads;
	
	private Boolean isHot=false;

	public Boolean getIsHot() {
		return isHot;
	}
	public void setIsHot(Boolean isHot) {
		this.isHot = isHot;
	}

	/**
	 * 子栏目集合
	 */
	@XStreamImplicit
	@Expose
	private Set<Section> children;

	/**
	 * 评论是否需要审核
	 */
	@Expose
	private Boolean commentAudit;

	@Expose
	private Date createDate = new Date();

	/**
	 * 父数量
	 */
	@Expose
	private int father;

	private Set<SectionFocus> focus;
	private Set<PadSectionFocus> padFocus;

	public Set<PadSectionFocus> getPadFocus() {
		return padFocus;
	}
	public void setPadFocus(Set<PadSectionFocus> padFocus) {
		this.padFocus = padFocus;
	}

	/**
	 * 焦点图片
	 */
	private String foucusImage;

	private Set<ImageInfo> images;

	/**
	 * 手机图片
	 */
	private String mobileTitleImage;

	@Expose
	private String name;

	/**
	 * 打开树的时候是否展开
	 */
	@XStreamAsAttribute
	private String open;

	/**
	 * 平板图片
	 */
	private String padTitleImage;

	/**
	 * 上级栏目
	 */
	@XStreamOmitField
	private Section parent;

	private Set<Role> roles;

	/**
	 * 栏目所属类别
	 */
	@Expose
	private SectionType sectionType;

	/**
	 * 是否显示
	 */
	private Boolean shown;

	/**
	 * 展示类别
	 */
	@Expose
	private SectionShowType showType;

	/**
	 * 子数量
	 */
	@Expose
	private int son;

	/**
	 * 栏目名称
	 */
	@XStreamAsAttribute
	@Expose
	private String text;
	public Section() {
		super();
	}
	public SectionAdapter getAdapterTerminal() {
		return adapterTerminal;
	}
	public Integer getArticleCount() {
		return articleCount;
	}

	public Set<Article> getArticleMobiles() {
		return articleMobiles;
	}

	public Set<Article> getArticlePads() {
		return articlePads;
	}

	public Set<Section> getChildren() {
		if (children != null && children.size() > 0)
			setSon(children.size());
		return children;
	}

	public Boolean getCommentAudit() {
		return commentAudit;
	}
	
	public Date getCreateDate() {
		return createDate;
	}

	public int getFather() {
		return father;
	}

	public Set<SectionFocus> getFocus() {
		return focus;
	}

	public String getFoucusImage() {
		return foucusImage;
	}

	public Set<ImageInfo> getImages() {
		return images;
	}

	public String getMobileTitleImage() {
		return mobileTitleImage;
	}


	public String getName() {
		return name = text;
	}

	public String getOpen() {
		return open;
	}


	public String getPadTitleImage() {
		return padTitleImage;
	}

	public Section getParent() {
		return parent;
	}

	public Set<Role> getRoles() {
		return roles;
	}

	public SectionType getSectionType() {
		return sectionType;
	}

	public Boolean getShown() {
		return shown;
	}

	public SectionShowType getShowType() {
		return showType;
	}

	public int getSon() {
		return son;
	}

	public String getText() {
		return text;
	}

	public void setAdapterTerminal(SectionAdapter adapterTerminal) {
		this.adapterTerminal = adapterTerminal;
	}

	public void setArticleCount(Integer articleCount) {
		this.articleCount = articleCount;
	}

	public void setArticleMobiles(Set<Article> articleMobiles) {
		this.articleMobiles = articleMobiles;
	}

	public void setArticlePads(Set<Article> articlePads) {
		this.articlePads = articlePads;
	}

	public void setChildren(Set<Section> children) {
		this.children = children;
	}

	public void setCommentAudit(Boolean commentAudit) {
		this.commentAudit = commentAudit;
	}


	public void setCreateDate(Date createDate) {
		this.createDate = createDate;
	}

	public void setFather(int father) {
		this.father = father;
	}

	public void setFocus(Set<SectionFocus> focus) {
		this.focus = focus;
	}

	public void setFoucusImage(String foucusImage) {
		this.foucusImage = foucusImage;
	}

	public void setImages(Set<ImageInfo> images) {
		this.images = images;
	}

	public void setMobileTitleImage(String mobileTitleImage) {
		this.mobileTitleImage = mobileTitleImage;
	}

	public void setName(String name) {
		this.name = name;
	}

	public void setOpen(String open) {
		this.open = open;
	}
	public void setPadTitleImage(String padTitleImage) {
		this.padTitleImage = padTitleImage;
	}

	public void setParent(Section parent) {
		if (parent == null) {
			setFather(0);
		}
		this.parent = parent;
		String s = this.text;
		Section sec = this.getParent();
		while (sec != null) {
			s = sec.getText() + "—" + s;
			sec = sec.getParent();
			setFather(getFather() + 1);
		}

		setName(s);
	}

	public void setRoles(Set<Role> roles) {
		this.roles = roles;
	}

	public void setSectionType(SectionType sectionType) {
		this.sectionType = sectionType;
	}

	public void setShown(Boolean shown) {
		this.shown = shown;
	}

	public void setShowType(SectionShowType showType) {
		this.showType = showType;
	}

	public void setSon(int son) {
		this.son = son;
	}

	public void setText(String text) {
		this.text = text;
	}

}
