package com.gang.entity.article;

import java.util.Set;

import com.gang.entity.process.PadArticleAudit;

public class ArticlePad extends Article {
	private Set<PadArticleAudit> audits;

	public Set<PadArticleAudit> getAudits() {
		return audits;
	}

	public void setAudits(Set<PadArticleAudit> audits) {
		this.audits = audits;
	}

}
