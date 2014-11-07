package com.gang.service;

import com.gang.comms.GridPageRequest;
import com.gang.comms.GridPageResponse;
import com.gang.comms.HibernateUtil;
import com.gang.comms.IOrder;
import com.gang.comms.LazyKiller;
import com.gang.comms.StringHelper;
import com.gang.comms.UpdateCollectionKiller;

import com.gang.entity.BaseEntity;
import com.gang.entity.process.State;

import com.gang.service.article.ArticleService;
import com.gang.service.statistics.ObjectToBean;

import org.apache.commons.mail.EmailException;
import org.apache.commons.mail.SimpleEmail;

import org.hibernate.Criteria;
import org.hibernate.Hibernate;
import org.hibernate.HibernateException;
import org.hibernate.Query;
import org.hibernate.SQLQuery;
import org.hibernate.Session;

import org.hibernate.criterion.Criterion;
import org.hibernate.criterion.Order;
import org.hibernate.criterion.Restrictions;

import org.springframework.orm.hibernate3.HibernateCallback;
import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import org.springframework.web.context.ContextLoader;
import org.springframework.web.context.WebApplicationContext;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

import java.sql.SQLException;

import java.util.ArrayList;
import java.util.Collection;
import java.util.Collections;
import java.util.Comparator;
import java.util.Date;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Set;


public class BaseService
  extends HibernateDaoSupport
{
	//~ Methods --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	@SuppressWarnings("unchecked")
	public GridPageResponse getGridPage(GridPageRequest req)
	{
		GridPageResponse gpr = new GridPageResponse();
		Session          session = getSession();
		Integer          recordCount = 0;
		List             list = null;
		Query            q = null;

		if (req.isHsql())
		{
			q = session.createQuery(req.getCsql());
			processDate(q, req.getQueryDateProperties());
			recordCount = Integer.parseInt(q.uniqueResult().toString());

			if (recordCount > 0)
			{
				q = session.createQuery(req.getDsql());
				processDate(q, req.getQueryDateProperties());
				list = q.setFirstResult(req.getStartNumber())
					      .setMaxResults(req.getPageSize())
					      .list();
			}
		}
		else
		{
			q = session.createSQLQuery(req.getCsql());
			processDate(q, req.getQueryDateProperties());
			recordCount = Integer.parseInt(q.uniqueResult().toString());

			if (recordCount > 0)
			{
				q = session.createSQLQuery(req.getDsql());
				processDate(q, req.getQueryDateProperties());

				if (req.isUserResultTransformer())
				{
					q.setResultTransformer(new ObjectToBean(req.getClazz()));
				}
				else
				{
					((SQLQuery) q).addEntity(req.getClazz());
				}

				if (req.isGetAll())
				{
					list = q.setFirstResult(req.getStartNumber())
						      .setMaxResults(recordCount)
						      .list();
				}
				else
				{
					list = q.setFirstResult(req.getStartNumber())
						      .setMaxResults(req.getPageSize())
						      .list();
				}
			}
		}

		if (list != null)
		{
			if (req.getCglibProperties()
				       .size() > 0)
			{
				for (Object o : list)
				{
					for (String getter : req.getCglibProperties())
					{
						String setter = getter.replace("get", "set");

						try
						{
							Method getMethod = o.getClass()
								                  .getMethod(getter);
							Object unprox = HibernateUtil.getUnproxiedValue(getMethod.invoke(o));

							if (unprox != null)
							{
								GridPageRequest.AddCglibPropertyHandler handler = req.getCglibPropertyHandler(getter);

								if (handler != null)
								{
									handler.handler(unprox);
								}

								Method setMethod = o.getClass()
									                  .getMethod(setter, unprox.getClass());
								setMethod.invoke(o, unprox);
							}
						}
						catch (Exception e)
						{
							e.printStackTrace();
						}
					}
				}
			}

			if (req.getLazyProperties()
				       .size() > 0)
			{
				for (Object o : list)
				{
					for (String getter : req.getLazyProperties())
					{
						try
						{
							Method getMethod = o.getClass()
								                  .getMethod(getter);
							Hibernate.initialize(getMethod.invoke(o));

							GridPageRequest.AddLazyPropertyHandler handler = req.getLazyPropertyHandler(getter);

							if (handler != null)
							{
								handler.handler(o);
							}
						}
						catch (Exception e)
						{
							e.printStackTrace();
						}
					}
				}
			}
		}

		if (req.isGetAll())
		{
			return getGridPage(list);
		}

		gpr.setPage(req.getPageIndex());
		gpr.setRecords(recordCount);
		gpr.setRows(list);
		gpr.setTotal(((recordCount % req.getPageSize()) == 0) ? (recordCount / req.getPageSize()) : ((recordCount / req.getPageSize()) + 1));

		return gpr;
	}

	private void processDate(
	  Query             q,
	  Map<String, Date> sd)
	{
		if (sd.size() == 0)
		{
			return;
		}

		Iterator iter = sd.entrySet()
			                .iterator();

		while (iter.hasNext())
		{
			Entry<String, Date> entry = (Entry<String, Date>) iter.next();
			String              key = entry.getKey();
			Date                date = entry.getValue();
			q.setTimestamp(key, date);
		}
	}

	public void add(Object entity)
	{
		this.getSession()
		    .saveOrUpdate(entity);
	}

	public void merge(Object entity)
	{
		this.getSession()
		    .merge(entity);
	}

	public void save(Object entity)
	{
		this.getSession()
		    .saveOrUpdate(entity);
	}

	public void update(
	  BaseEntity             entity,
	  UpdateCollectionKiller killer)
		throws SecurityException,
			IllegalArgumentException,
			NoSuchMethodException,
			IllegalAccessException,
			InvocationTargetException
	{
		Session session = getSession();
		killer.execute(session, entity.getClass(), entity.getId());
		session.update(entity);
	}

	public GridPageResponse getGridPage(Collection list)
	{
		if (list == null)
		{
			return null;
		}

		GridPageResponse gpr = new GridPageResponse();
		gpr.setPage(1);
		gpr.setRecords(list.size());
		gpr.setRows(list);
		gpr.setTotal(1);

		return gpr;
	}

	public Criteria getCriteria(Class clazz)
	{
		return getSession()
		         .createCriteria(clazz);
	}

	@SuppressWarnings({
		"unchecked",
		"rawtypes"
	})
	public <T> T get(
	  Class   T,
	  Integer id)
	{
		return (T) getCriteria(T)
		             .add(Restrictions.idEq(id))
		             .uniqueResult();
	}
	public <T> T get(
			  Class   T,
			  String propertyName,Object value)
			{
				return (T) getCriteria(T)
				             .add(Restrictions.eq(propertyName, value))
				             .uniqueResult();
			}
	public <T>T getTop(Class T,Order order)
	{
		return (T) getCriteria(T)
	             .addOrder(order).setMaxResults(1)
	             .uniqueResult();
	}
	@SuppressWarnings("unchecked")
	public <T> T get(
	  Class                                  T,
	  Integer                                id,
	  GridPageRequest.AddLazyPropertyHandler lazyPropertyHandler)
	{
		Object o = getCriteria(T)
			           .add(Restrictions.idEq(id))
			           .uniqueResult();

		if (lazyPropertyHandler != null)
		{
			lazyPropertyHandler.handler(o);
		}

		return (T) o;
	}

	@SuppressWarnings("unchecked")
	public <T> T get(
	  final Class  T,
	  final String sql)
	{
		return (T) getHibernateTemplate()
		             .execute(new HibernateCallback()
			{
				@Override
				public Object doInHibernate(Session session)
					throws HibernateException,
						SQLException
				{
					return session.createSQLQuery(sql)
					              .addEntity(T)
					              .uniqueResult();
				}
			});
	}

	public <T> T get(
	  final Class T,
	  Integer     id,
	  String... lazyProperties)
	{
		Object result = getCriteria(T)
			                .add(Restrictions.idEq(id))
			                .uniqueResult();

		for (String property : lazyProperties)
		{
			try
			{
				Hibernate.initialize(result.getClass().getMethod(property).invoke(result));
			}
			catch (Exception e)
			{
				throw new RuntimeException(e);
			}
		}

		return (T) result;
	}

	public <T> T get(
	  final Class T,
	  Integer     id,
	  LazyKiller  killer)
	{
		Object result = getCriteria(T)
			                .add(Restrictions.idEq(id))
			                .uniqueResult();

		doLazyKiller(result, killer);

		return (T) result;
	}

	@SuppressWarnings("unchecked")
	public <T> T get(
	  final Integer    id,
	  final Class      T,
	  final LazyKiller killer)
	{
		Session session = getSession();
		Object  o = session.createCriteria(T)
			                 .add(Restrictions.idEq(id))
			                 .uniqueResult();
		this.doLazyKiller(o, killer);

		return (T) o;
	}

	@SuppressWarnings({
		"rawtypes",
		"unchecked"
	})
	protected void doLazyKiller(
	  Object     o,
	  LazyKiller killer)
	{
		if (o == null)
		{
			return;
		}

		Class clazz = o.getClass();

		for (String property : killer.getLazyProperties())
		{
			try
			{
				Method m = clazz.getMethod(property);

				if (m != null)
				{
					Object p = m.invoke(o);
					Hibernate.initialize(p);
				}
			}
			catch (Exception e)
			{
				continue;
			}
		}

		for (String getter : killer.getCglibProperties())
		{
			String setter = getter.replace("get", "set");

			try
			{
				Method get = clazz.getMethod(getter);

				if (get != null)
				{
					Object p = get.invoke(o);
					Object unprox = HibernateUtil.getUnproxiedValue(p);

					if (unprox != null)
					{
						Method set = clazz.getMethod(setter, unprox.getClass());

						if (set != null)
						{
							set.invoke(o, unprox);
						}
					}
				}
			}
			catch (Exception e)
			{
				continue;
			}
		}
	}

	public void delete(
	  Class   clazz,
	  Integer id)
	{
		try {
			String Hql = "DELETE " + clazz.toString()
                    .replace("class", "") + " WHERE id=" + id;
execHql(Hql);
		} catch (Exception e) {
			e.printStackTrace();
		}
		
	}

	public void deleteObject(
	  Class   clazz,
	  Integer id)
	{
		Session session = getSession();

		session.delete(session.get(clazz, id));
	}

	public Boolean checkWetherLayout(Integer id)
	{
		Session session = getSession();
		String  sql = "SELECT id FROM padpagelayoutarticle WHERE article=:article";
		List    list = session.createSQLQuery(sql)
			                    .setInteger("article", id)
			                    .list();

		return (list != null) && (list.size() > 0);
	}

	public <T> List<T> getList(Class clazz)
	{
		return getCriteria(clazz)
		         .list();
	}
	public <T> List<T> getList(Class clazz,String sql)
	{
		return getSession().createSQLQuery(sql).addEntity(clazz)
		         .list();
	}
	public <T> List<T> getList(
	  Class  clazz,
	  String propertyName,
	  Object value)
	{
		return getCriteria(clazz)
		         .add(Restrictions.eq(propertyName, value))
		         .list();
	}

	public List getList(String hql)
	{
		return getSession()
		         .createQuery(hql)
		         .list();
	}

	public <T> List<T> getList(Set<T> set)
	{
		List<T> list = new ArrayList<T>(set);
		Collections.sort(list, new Comparator<T>()
			{
				@Override
				public int compare(
				  T o1,
				  T o2)
				{
					IOrder io = (IOrder) o1;
					IOrder iio = (IOrder) o2;

					return io.getOrderNumber() - iio.getOrderNumber();
				}
			});

		return list;
	}

	public List<State> getStates(int type)
	{
		List<State> states = new ArrayList<State>();
		State       s = (State) getCriteria(State.class)
			                        .add(Restrictions.eq("nodeType", type))
			                        .addOrder(Order.asc("id"))
			                        .list()
			                        .get(0);
		states.add((State) HibernateUtil.getUnproxiedValue(s));
		states.add((State) HibernateUtil.getUnproxiedValue(s.getNext()));

		return states;
	}

	public List<State> getStatesAll(int type)
	{
		List<State> list = getCriteria(State.class)
			                   .add(Restrictions.eq("nodeType", type))
			                   .addOrder(Order.asc("id"))
			                   .list();

		if (null != list)
		{
			list.add(getOnlineState());
			list.add(getOfflineState());
		}

		return list;
	}

	public void exec(String sql)
	{
		getSession()
		  .createSQLQuery(sql)
		  .executeUpdate();
	}

	public void execHql(String sql)
	{
		getSession()
		  .createQuery(sql)
		  .executeUpdate();
	}

	public void batchDelete(
	  Class  clazz,
	  String ids)
	{
		String Hql = "DELETE " + clazz.toString()
			                            .replace("class", "") + " WHERE id in (" + ids + ")";
		getSession()
		  .createQuery(Hql)
		  .executeUpdate();
	}

	public State getOnlineState()
	{
		return (State) HibernateUtil.getUnproxiedValue(getCriteria(State.class).add(Restrictions.eq("name", "上线")).uniqueResult());
	}

	public State getOfflineState()
	{
		return (State) HibernateUtil.getUnproxiedValue(getCriteria(State.class).add(Restrictions.eq("name", "下线")).uniqueResult());
	}

	public State getEditState(int type)
	{
		return (State) HibernateUtil.getUnproxiedValue(getCriteria(State.class).add(Restrictions.eq("name", "编辑")).add(Restrictions.eq("nodeType", type)).uniqueResult());
	}

	public State getPrepareDistributeState(int type)
	{
		String sql = " FROM State s WHERE s.next.next=null and nodeType=:type";

		return (State) getSession()
		                 .createQuery(sql)
		                 .setInteger("type", type)
		                 .uniqueResult();
	}

	public String getWebRoot()
	{
		WebApplicationContext ctx = ContextLoader.getCurrentWebApplicationContext();
		String                path = ctx.getServletContext()
			                              .getRealPath("/");

		return path;
	}

	public String getWebRoot(String virtual)
	{
		WebApplicationContext ctx = ContextLoader.getCurrentWebApplicationContext();
		String                path = null;

		if (StringHelper.isBlank(virtual))
		{
			path = ctx.getServletContext()
				        .getRealPath("/");
		}
		else
		{
			path = ctx.getServletContext()
				        .getRealPath(virtual.replace(ctx.getServletContext().getContextPath(), ""));
		}

		return path;
	}

	public Object execute(HibernateCallback action)
	{
		return getHibernateTemplate()
		         .execute(action);
	}

	@SuppressWarnings("unchecked")
	public <T> List<T> execute(
	  final Class  T,
	  final String sql)
	{
		List<T> list = (List<T>) getHibernateTemplate()
			                         .execute(new HibernateCallback()
				{
					@Override
					public Object doInHibernate(Session session)
						throws HibernateException,
							SQLException
					{
						return session.createSQLQuery(sql)
						              .setResultTransformer(new ObjectToBean(T))
						              .list();
					}
				});

		return list;
	}

	@SuppressWarnings({
		"unchecked",
		"rawtypes"
	})
	public Object getProperty(
	  Object o,
	  String property)
	{
		if (o == null)
		{
			return null;
		}

		Class  clazz = o.getClass();
		Object ret = null;

		try
		{
			Method m = clazz.getMethod(property);

			if (m != null)
			{
				ret = m.invoke(o);
			}
		}
		catch (Exception e)
		{
		}

		return ret;
	}
    public Integer getInteger(String sql)
    {
    	Object obj=getSession().createSQLQuery(sql).uniqueResult();
    	if(obj!=null)
    	{
    		return Integer.parseInt(obj.toString());
    	}
    	return 0;
    }
	public void sendEmail()
		throws EmailException
	{
		SimpleEmail email = new SimpleEmail();
		email.setHostName("smtp.gmail.com");
		email.addTo("254527732@qq.com", "测试COMMON EMAIL");
		email.setSSL(true);
		email.setSmtpPort(465);
		email.setFrom("tanjun1536@gmail.com", "灵辰科技无限公司");
		email.setSubject("Test message");
		email.setMsg("This is a simple test of commons-email");
		email.send();
	}
}
