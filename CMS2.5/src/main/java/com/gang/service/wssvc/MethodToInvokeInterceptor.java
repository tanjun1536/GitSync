package com.gang.service.wssvc;

import java.lang.reflect.Method;

import org.apache.cxf.frontend.MethodDispatcher;
import org.apache.cxf.interceptor.Fault;
import org.apache.cxf.message.Exchange;
import org.apache.cxf.message.Message;
import org.apache.cxf.phase.AbstractPhaseInterceptor;
import org.apache.cxf.phase.Phase;
import org.apache.cxf.service.Service;
import org.apache.cxf.service.model.BindingOperationInfo;


public class MethodToInvokeInterceptor extends AbstractPhaseInterceptor<Message> {
	public MethodToInvokeInterceptor(String phase) {
		super(phase);
	}
	public MethodToInvokeInterceptor() {
		super(Phase.USER_LOGICAL);
	}
	public void handleMessage(Message message) throws Fault {
		Exchange exchange = message.getExchange();
		BindingOperationInfo bop = exchange.get(BindingOperationInfo.class);
		MethodDispatcher md = (MethodDispatcher) exchange.get(Service.class).get(MethodDispatcher.class.getName());
		Method method = md.getMethod(bop);
		System.out.println("********method name:" + method.getName());
	}
}