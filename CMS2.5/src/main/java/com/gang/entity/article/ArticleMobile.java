package com.gang.entity.article;

import java.util.Set;

import com.gang.entity.process.ArticleAudit;

public class ArticleMobile extends Article {
	private Set<ArticleAudit> audits;

	public Set<ArticleAudit> getAudits() {
		return audits;
	}

	public void setAudits(Set<ArticleAudit> audits) {
		this.audits = audits;
	}
}
