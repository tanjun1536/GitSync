package com.gang.service.wssvc;

import javax.jws.WebParam;
import javax.jws.WebService;
@WebService
public interface IPadService extends IService{
	/**
	 * 根据栏目获取PAD下的排版页面列表
	 */
	String getPadDocPageList(@WebParam(name = "section") String section,@WebParam(name = "activeKey")String activeKey);
	
	/**
	 *根据排版获取排版的压缩包
	 */
	void getPadPage(@WebParam(name = "pageId")String pageId);
	
	  /**
     * 根据文章id获取文章内容
     */
    void getDoc(@WebParam(name = "docId") String docId);
    
    /**
     * 根据栏目获取文章列表
     */
    String getDocList(@WebParam(name = "section") String section, @WebParam(name = "activeKey") String activeKey);
	
}
