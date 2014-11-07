package com.gang.service.wssvc;

import javax.jws.WebParam;
import javax.jws.WebService;

@WebService
public interface ICMSService {

	public enum ClickType {

		SECTION("S"), ARTICLE("A"), FOCUS("F");
		private String type;

		public String getType() {
			return type;
		}

		public void setType(String type) {
			this.type = type;
		}

		private ClickType(String s) {
			this.type = s;
		}
	}

	// ~ Methods
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	/* 注册 */
	public String register(
			@WebParam(name = "user_login_id") String user_login_id,
			@WebParam(name = "password") String password,
			@WebParam(name = "sex") String sex,
			@WebParam(name = "nick") String nick,
			@WebParam(name = "active_key") String active_key);

	/* 获取用户详细 */
	public String get_userdetail(@WebParam(name = "user_id") String user_id,
			@WebParam(name = "user_login_id") String user_login_id);

	/* 获取用户基本 */
	public String get_userbrief(@WebParam(name = "user_id") String user_id,
			@WebParam(name = "user_login_id") String user_login_id);

	/* 搜素用户 */
	public String search_users(@WebParam(name = "user_id") String user_id,
			@WebParam(name = "user_login_id") String user_login_id,
			@WebParam(name = "nick") String nick,
			@WebParam(name = "sex") String sex,
			@WebParam(name = "min_age") String min_age,
			@WebParam(name = "max_age") String max_age,
			@WebParam(name = "login_time") String login_time,
			@WebParam(name = "is_nearby") String is_nearby);

	/* 激活终端 */
	public String active_terminal(
			@WebParam(name = "device_code") String device_code,
			@WebParam(name = "height") String height,
			@WebParam(name = "width") String width,
			@WebParam(name = "os_type") String os_type,
			@WebParam(name = "os_version") String os_version,
			@WebParam(name = "soft_type") String soft_type,
			@WebParam(name = "soft_version") String soft_version,
			@WebParam(name = "spread_code") String spread_code);

	/* 获取频道 */
	public String get_channels(@WebParam(name = "id") String id,
			@WebParam(name = "soft_type") String soft_type,
			@WebParam(name = "active_key") String active_key,
			@WebParam(name = "user_id") String user_id);

	/* 获取焦点 */
	public String get_focus(@WebParam(name = "parent_id") String parent_id,
			@WebParam(name = "soft_type") String soft_type,
			@WebParam(name = "active_key") String active_key,
			@WebParam(name = "user_id") String user_id);

	/* 获取栏目 */
	public String get_categories(
			@WebParam(name = "parent_id") String parent_id,
			@WebParam(name = "soft_type") String soft_type,
			@WebParam(name = "active_key") String active_key,
			@WebParam(name = "user_id") String user_id);

	/* 更新用户信息 */
	public String update_userinfo(
			@WebParam(name = "json_userinfo") String json_userinfo);

	/* 获取文章列表 */
	public String get_doclist(@WebParam(name = "parent_id") String parent_id,
			@WebParam(name = "start_index") String start_index,
			@WebParam(name = "offset") String offset,
			@WebParam(name = "soft_type") String soft_type,
			@WebParam(name = "active_key") String active_key,
			@WebParam(name = "user_id") String user_id);
	/* 搜索文章列表 */
	public String search_doc(@WebParam(name = "parent_id") String parent_id,
			@WebParam(name = "start_index") String start_index,
			@WebParam(name = "offset") String offset,
			@WebParam(name = "soft_type") String soft_type,
			@WebParam(name = "active_key") String active_key,
			@WebParam(name = "user_id") String user_id,@WebParam(name="keyword")String keyword);

	/* 获取文章 */
	public String get_doc(@WebParam(name = "id") String id,
			@WebParam(name = "soft_type") String soft_type,
			@WebParam(name = "active_key") String active_key,
			@WebParam(name = "user_id") String user_id);

	public String get_doc_html(@WebParam(name = "id") String id,
			@WebParam(name = "soft_type") String soft_type,
			@WebParam(name = "active_key") String active_key,
			@WebParam(name = "user_id") String user_id);

	public String upload_offline_statdata(
			@WebParam(name = "content") String content);
	
	public String check_version(
			@WebParam(name = "type")String type,
			@WebParam(name = "active_key")String active_key);
	
	public String get_hot_message(
			@WebParam(name = "active_key")String active_key,
			@WebParam(name = "user_id") String user_id);
	
	public String get_messagecenter_data(
			@WebParam(name = "start_index") String start_index,
			@WebParam(name = "offset") String offset,
			@WebParam(name = "active_key")String active_key,
			@WebParam(name = "user_id") String user_id);
	
	
	public String get_pm_2_5();
		
}
