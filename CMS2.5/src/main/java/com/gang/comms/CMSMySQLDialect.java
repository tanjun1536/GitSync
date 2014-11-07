package com.gang.comms;

import org.hibernate.dialect.MySQLDialect;


public class CMSMySQLDialect extends MySQLDialect {
	public CMSMySQLDialect() {
		super();
		registerHibernateType(java.sql.Types.LONGVARCHAR,"text");
	}
}
