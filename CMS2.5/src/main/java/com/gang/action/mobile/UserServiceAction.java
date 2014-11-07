package com.gang.action.mobile;

import com.gang.action.DefaultAction;

import com.gang.entity.user.User;

import com.gang.service.mobile.UserService;
import com.gang.service.wssvc.Generator;
import com.gang.service.wssvc.JSONGenerator;

import org.apache.commons.io.FileUtils;
import org.apache.commons.mail.HtmlEmail;
import org.apache.commons.mail.SimpleEmail;

import org.hibernate.criterion.Order;

import java.io.File;
import java.io.IOException;

import java.util.Date;
import java.util.List;
import java.util.Random;
import java.util.UUID;

public class UserServiceAction extends DefaultAction {
	public UserService service;
	private String user_name;
	private String target_user_name;
	private String password;
	private String hash_password;
	private String new_password;
	private String confirm_new_password;

	public String getNew_password() {
		return new_password;
	}

	public void setNew_password(String new_password) {
		this.new_password = new_password;
	}

	public String getConfirm_new_password() {
		return confirm_new_password;
	}

	public void setConfirm_new_password(String confirm_new_password) {
		this.confirm_new_password = confirm_new_password;
	}

	private String nick;
	private File head;
	private String sex;
	private String birthday_year;
	private String birthday_month;
	private String birthday_day;
	private String introduction;
	private String active_key;

	public String getTarget_user_name() {
		return target_user_name;
	}

	public void setTarget_user_name(String target_user_name) {
		this.target_user_name = target_user_name;
	}

	public String getHash_password() {
		return hash_password;
	}

	public void setHash_password(String hash_password) {
		this.hash_password = hash_password;
	}

	public String getUser_name() {
		return user_name;
	}

	public void setUser_name(String user_name) {
		this.user_name = user_name;
	}

	public UserService getService() {
		return service;
	}

	public void setService(UserService service) {
		this.service = service;
	}

	public String getPassword() {
		return password;
	}

	public void setPassword(String password) {
		this.password = password;
	}

	public String getNick() {
		return nick;
	}

	public void setNick(String nick) {
		this.nick = nick;
	}

	public File getHead() {
		return head;
	}

	public void setHead(File head) {
		this.head = head;
	}

	public String getSex() {
		return sex;
	}

	public void setSex(String sex) {
		this.sex = sex;
	}

	public String getBirthday_year() {
		return birthday_year;
	}

	public void setBirthday_year(String birthday_year) {
		this.birthday_year = birthday_year;
	}

	public String getBirthday_month() {
		return birthday_month;
	}

	public void setBirthday_month(String birthday_month) {
		this.birthday_month = birthday_month;
	}

	public String getBirthday_day() {
		return birthday_day;
	}

	public void setBirthday_day(String birthday_day) {
		this.birthday_day = birthday_day;
	}

	public String getIntroduction() {
		return introduction;
	}

	public void setIntroduction(String introduction) {
		this.introduction = introduction;
	}

	public String getActive_key() {
		return active_key;
	}

	public void setActive_key(String active_key) {
		this.active_key = active_key;
	}

	/*
	 * account 用户账户 password 用户密码 active_key 用户激活码 "
	 */
	public void login() {
		User user = (User) service.get(User.class, "loginName", user_name);
		JSONGenerator json = CheckLogin(user, password);

		if (json == null) {
			json = new JSONGenerator();
			getUserJson(user, json);
		}

		Write(json.toString());
	}

	private void getUserJson(User user, JSONGenerator json) {
		json.addGenerator(new Generator("result", Success));
		json.addGenerator(new Generator("user_id", user.getLoginNumber()));
		json.addGenerator(new Generator("user_name", user.getLoginName()));
		json.addGenerator(new Generator("hash_password", user
				.getLoginPassword()));
		json.addGenerator(new Generator("nick", user.getNick()));
		json.addGenerator(new Generator("sex", user.getSex()));
		json.addGenerator(new Generator("head", user.getHeader()));
		json.addGenerator(new Generator("birthday_year", user.getBirthyear()));
		json.addGenerator(new Generator("birthday_month", user.getBirthmonth()));
		json.addGenerator(new Generator("birthday_day", user.getBirthday()));
		json.addGenerator(new Generator("introduction", user.getIntroduction()));
	}

	/*
	 * account 用户账户（邮箱） password 用户密码 nick 用户昵称 head 用户头像url sex 用户性别
	 * birthday_year 用户出生年 birthday_month 用户出生月 birthday_day 用户出生日 introduction
	 * 用户介绍 active_key 用户激活码 "
	 * 
	 * { result:{ error: 0 title: "调用成功" message:"调用成功" } user_id:10000
	 * //用户唯一数字标识 account:example@163.com hash_password:xxxxxxx(加密后的密码) nick:小明
	 * head:http://xxx.png sex:0 //0为男，1为女 birthday_year:1999 birthday_month:1
	 * birthday_day:1 introduction：用户介绍 }
	 */
	public void register() {
		User user = (User) service.get(User.class, "loginName", user_name);
		int maxLoginNumber = 10000;
		User lastUser = (User) service.getTop(User.class, Order.desc("id"));

		if (lastUser != null) {
			maxLoginNumber = Integer.parseInt(lastUser.getLoginNumber()) + 1;
		}

		JSONGenerator json = new JSONGenerator();

		if (user == null) {
			user = new User();
			user.setActiveKey(active_key);
			user.setLoginName(user_name);
			user.setNick(nick);
			user.setSex(sex);
			user.setBirthyear(birthday_year);
			user.setBirthmonth(birthday_month);
			user.setBirthday(birthday_day);
			user.setIntroduction(introduction);
			user.setLoginNumber(String.valueOf(maxLoginNumber));
			user.setLoginPasswordSalt(UUID.randomUUID().toString());
			user.setLoginPassword(md5Encoder.encodePassword(password,
					user.getLoginPasswordSalt()));

			if (head != null) {
				try {
					FileUtils
							.copyFile(head, new File(getRealPath("userheaders")
									+ user.getLoginNumber()));
					user.setHeader("userheaders/" + user.getLoginNumber());
				} catch (IOException e) {
					e.printStackTrace();
				}
			}

			service.save(user);

			getUserJson(user, json);
		} else {
			json = Error.addGenerator(new Generator("message", "账户已经被注册了"));
			json = getError(json);
		}

		Write(json.toString());
	}

	public void info_basic() {
		User user = (User) service.get(User.class, "loginName", user_name);
		JSONGenerator json = CheckUser(user, hash_password);
		if (json == null) {
			User targetUser = (User) service.get(User.class, "loginName",
					target_user_name);
			if (targetUser != null) {
				json = new JSONGenerator();
				json.addGenerator(new Generator("result", Success));
				json.addGenerator(new Generator("user_id", user.getLoginNumber()));
				json.addGenerator(new Generator("user_name", user.getLoginName()));
				json.addGenerator(new Generator("nick", user.getNick()));
				json.addGenerator(new Generator("sex", user.getSex()));
				json.addGenerator(new Generator("head", user.getHeader()));
				json.addGenerator(new Generator("birthday_year", user.getBirthyear()));
				json.addGenerator(new Generator("birthday_month", user.getBirthmonth()));
				json.addGenerator(new Generator("birthday_day", user.getBirthday()));
				json.addGenerator(new Generator("introduction", user.getIntroduction()));
			} else {
				json = Error.addGenerator(new Generator("message", "无此用户"));
				json = getError(json);
			}
		}
		Write(json.toString());
	}

	// public void info_basic() {
	// User user = (User) service.get(User.class, "loginName", user_name);
	// JSONGenerator json = new JSONGenerator();
	//
	// if (user != null) {
	// getUserJson(user, json);
	// } else {
	// json = Error.addGenerator(new Generator("message", "无此用户"));
	// json = getError(json);
	// }
	//
	// Write(json.toString());
	// }

	public void info_basic_update() {
		User user = (User) service.get(User.class, "loginName", user_name);
		JSONGenerator json = CheckUser(user, hash_password);

		if (json == null) {
			String sql = "select * from user where id != " + user.getId()
					+ " and nick ='" + nick + " '";
			List<User> list = service.getList(User.class, sql);

			if ((list != null) && (list.size() > 0)) {
				json = Error.addGenerator(new Generator("message", "昵称重复"));
				json = getError(json);
			}

			if (json == null) {
				json = new JSONGenerator();
				user.setActiveKey(active_key);
				user.setNick(nick);
				user.setSex(sex);
				user.setBirthyear(birthday_year);
				user.setBirthmonth(birthday_month);
				user.setBirthday(birthday_day);
				user.setIntroduction(introduction);

				if (password != null) {
					user.setLoginPassword(md5Encoder.encodePassword(password,
							user.getLoginPasswordSalt()));
					user.setLoginPasswordSalt(UUID.randomUUID().toString());
				}

				if (head != null) {
					String header = UUID.randomUUID().toString()
							.replace("-", "");

					try {
						FileUtils.copyFile(head, new File(
								getRealPath("userheaders") + header));
						user.setHeader("userheaders/" + header);
					} catch (IOException e) {
						e.printStackTrace();
					}
				}

				service.save(user);
				getUserJson(user, json);
			}
		}

		Write(json.toString());
	}

	public String forgetPassword() {
		User user = (User) service.get(User.class, "loginName", user_name);
		if (user == null) {
			getRequest().setAttribute("error", "该用户不存在!");
			return "forgetpassword";
		} else {
			String chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
			String password = "";
			Random random=new Random(new Date().getTime());
			for (int i = 0; i < 6; i++) {
				int index = random.nextInt(63) ;
				password += chars.charAt(index);
			}
			String encodePassword = md5Encoder.encodePassword(password,
					user.getLoginPasswordSalt());
			user.setLoginPassword(encodePassword);
			service.save(user);
			// 发送邮件
			String content = "你的新密码是：" + password + " 请尽快更改你的密码。注意：密码区分大小写!";
			try {
				HtmlEmail  email = new HtmlEmail();
				email.setHostName("smtp.163.com");
				email.addTo(user.getLoginName());
				email.setSSL(true);
				email.setCharset("gbk");
				//email.setSmtpPort(465);
				email.setAuthentication("lingchentech@163.com", "Lc20122012");
				email.setFrom("lingchentech@163.com", "灵辰科技有限公司");
				email.setSubject("找回密码");
				email.setMsg(content);
				email.send();
			} catch (Exception e) {

			}
			return "forgetpasswordsuccess";
		}

	}

	public String changePassword() {
		
		User user = (User) service.get(User.class, "loginName", user_name);
		if (user == null) {
			
			getRequest().setAttribute("error", "该用户不存在!");
			return "changepassword";
		}
		else
		{
			String alterPassword=md5Encoder.encodePassword(password, user.getLoginPasswordSalt());
			//检查原密码
			if(user.getLoginPassword().equals(alterPassword))
			{
				if(new_password.equals(confirm_new_password))
				{
					alterPassword=md5Encoder.encodePassword(new_password, user.getLoginPasswordSalt());
					user.setLoginPassword(alterPassword);
					service.save(user);
				}
				else
				{
					getRequest().setAttribute("error", "两次输入的密码不一致!");
					return "changepassword";
				}
			}
			else
			{
				getRequest().setAttribute("error", "旧密码输入错误!");
				return "changepassword";
			}
		}
		return "changepasswordsuccess";
	}
}
