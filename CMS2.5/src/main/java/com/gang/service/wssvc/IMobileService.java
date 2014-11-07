package com.gang.service.wssvc;

import javax.jws.WebParam;
import javax.jws.WebService;

/**
 * @author tanjun1536
 */
@WebService
public interface IMobileService extends IService{

	  /**
     * 根据文章id获取文章内容
     */
    void getDoc(@WebParam(name = "docId") String docId);
    
    String getDocList(@WebParam(name = "section") String section,@WebParam(name = "startIndex") String startIndex,@WebParam(name = "offset") String offset, @WebParam(name = "activeKey") String activeKey);
    
    String getSectionFocus(@WebParam(name = "section") String section,@WebParam(name = "activeKey") String activeKey); 

}
