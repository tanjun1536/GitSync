package com.gang.service.wssvc;

import javax.jws.WebParam;
import javax.jws.WebService;

@WebService
public interface IService {
	String JSON_END = "}";
	String JSON_START = "{";

	String JSONARRAY_END = "]";
	String JSONARRAY_START = "[";
	/**
	 * 后台操作失败返回的字符串-false
	 */
	String NO = "false";
	/**
	 * 后台操作成功返回的字符串-true
	 */
	String OK = "true";

	/**
	 * 获取频道 
	 */
	String getChanels(@WebParam(name = "activeKey")String activeKey);
	/**
	 * 根据上级栏目获取子栏目 
	 */
	String getSections(@WebParam(name = "section") String section,@WebParam(name = "activeKey")String activeKey);
	/**
	 * 获取首页焦点
	 */
	String getIndexFocus(@WebParam(name = "activeKey")String activeKey);
   
    /**
	 * @param deviceCode
	 *            设备编号
	 * @param height
	 *            设备高度
	 * @param width
	 *            设备宽度
	 * @param osCode
	 * @param osType
	 *            操作系统类型
	 * @param osVersion
	 *            操作系统类型
	 * @param softVersion软件版本
	 * @return
	 */
	String activeTerminal(@WebParam(name = "deviceCode") String deviceCode, @WebParam(name = "height") int height, @WebParam(name = "width") int width, @WebParam(name = "osCode") String osCode, @WebParam(name = "osType") String osType, @WebParam(name = "osVersion") String osVersion, @WebParam(name = "softVersion") String softVersion);
    /**
     * 获取pad排版HTML
     */
    void getResource(@WebParam(name = "type")String type,@WebParam(name = "activeKey")String activeKey);
    /**
     * 注册
     */
    String regisiter(@WebParam(name = "name")String name, @WebParam(name = "pwd")String pwd,@WebParam(name = "email")String email,@WebParam(name = "activeKey")String activeKey);
    /**
     * 登录
     */
    String login(@WebParam(name = "name")String name, @WebParam(name = "pwd")String pwd);
    
    String checkVersion(@WebParam(name = "type")String type,@WebParam(name = "activeKey")String activeKey);
    
}
