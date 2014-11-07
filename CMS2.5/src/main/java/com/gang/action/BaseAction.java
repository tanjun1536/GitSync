package com.gang.action;

import com.gang.comms.FileHelper;

import com.gang.entity.user.BackUser;
import com.gang.entity.user.User;

import com.gang.service.BaseService;
import com.gang.service.wssvc.Generator;
import com.gang.service.wssvc.JSONGenerator;

import com.opensymphony.xwork2.ActionSupport;

import freemarker.ext.script.FreeMarkerScriptConstants;

import org.acegisecurity.providers.encoding.Md5PasswordEncoder;

import org.apache.struts2.ServletActionContext;

import java.io.IOException;
import java.io.Writer;

import java.text.SimpleDateFormat;
import java.util.Iterator;
import java.util.Map;
import java.util.Map.Entry;

import javax.script.Bindings;
import javax.script.ScriptEngine;
import javax.script.ScriptEngineManager;
import javax.script.ScriptException;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;


public abstract class BaseAction extends ActionSupport {
    private static final long serialVersionUID = 1L;
    public static String OK = "OK";
    public static String NO = "NO";
    public static String LIST = "list";
    public static String EDIT = "edit";
    public static String ADD = "add";
    public static String VIEW = "view";
    public static String AUDIT = "audit";
    public static String SESSION_BACK_USER = "BackLoginUser";
    public static String SESSION_SECTION_ALL = "SESSION_SECTION_ALL";
    public static String SESSION_SECTION_USER = "SESSION_SECTION_USER";
    public static int MOBILE_WAIT_AUDIT = 2;
    public static int PAD_WAIT_AUDIT = 36;
    public static int MOBILE_SECTIONFOCUS_WAIT_AUDIT = 7;
    public static int PAD_SECTIONFOCUS_WAIT_AUDIT = 41;
    
    
    public JSONGenerator Error = new JSONGenerator();
    public JSONGenerator PasswordError = new JSONGenerator();
    public JSONGenerator Success = new JSONGenerator();
    public Md5PasswordEncoder md5Encoder = new Md5PasswordEncoder();

    public BaseAction() {
        super();
        Success.addGenerator(new Generator("error", "0"))
               .addGenerator(new Generator("title", "调用成功"))
               .addGenerator(new Generator("message", "调用成功"));
        Error.addGenerator(new Generator("error", "1"))
             .addGenerator(new Generator("title", "调用失败"));
        PasswordError.addGenerator(new Generator("error", "10010"))
        .addGenerator(new Generator("title", "调用失败"));
    }

    public JSONGenerator CheckLogin(User user, String password){
        if (user != null) {
            if (md5Encoder.encodePassword(password, user.getLoginPasswordSalt())
                              .equals(user.getLoginPassword())) {
            	 return null;
            } else {
                return getError(PasswordError.addGenerator(
                        new Generator("message", "密码错误")));
            }
        } else {
            return getError(Error.addGenerator(
                    new Generator("message", "用户名错误")));
        }
       
    }

    public JSONGenerator CheckUser(User user, String password) {
        if (user != null) {
            if (user.getLoginPassword().equals(password)) {
            	 return null;
            } else {
                return getError(PasswordError.addGenerator(
                        new Generator("message", "密码错误")));
            }
        } else {
            return getError(Error.addGenerator(
                    new Generator("message", "用户名错误")));
        }

       
    }

    public JSONGenerator getError(JSONGenerator error) {
        return new JSONGenerator().addGenerator(new Generator("result", error));
    }

    public void previewImage() {
        try {
            String img = FileHelper.ProcessRequest(getRequest());
            Write(img);
        } catch (ServletException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public HttpServletRequest getRequest() {
        return ServletActionContext.getRequest();
    }

    public HttpSession getSession() {
        return getRequest().getSession();
    }

    public HttpServletResponse getResponse() {
        return ServletActionContext.getResponse();
    }

    public void addAttribute(String name, Object o) {
        getRequest().setAttribute(name, o);
    }

    public void Write(HttpServletResponse res, String json) {
        res.setCharacterEncoding("UTF-8");
        res.setHeader("Cache-Control", "no-cache");
        res.setContentType("text/html");

        Writer writer;

        try {
            writer = res.getWriter();
            writer.write(json);
            writer.flush();
            writer.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    public void Write(String json) {
        Write(getResponse(), json);
    }

    public void WriteXml(String xml) {
        WriteXml(getResponse(), xml);
    }

    public void WriteXml(HttpServletResponse res, String json) {
        res.setCharacterEncoding("UTF-8");
        res.setHeader("Cache-Control", "no-cache");
        res.setContentType("text/xml");

        Writer writer;

        try {
            writer = res.getWriter();
            writer.write(json);
            writer.flush();
            writer.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    protected String getRealPath(String p) {
        return ServletActionContext.getServletContext().getRealPath(p) + "\\";
    }

    protected Integer getInteger(String name) {
        String p = getString(name);

        if ((p != null) && !"".equals(p)) {
            try {
                return Integer.parseInt(p);
            } catch (Exception e) {
                return new Integer(0);
            }
        }

        return new Integer(0);
    }

    protected String getString(String name) {
        return getRequest().getParameter(name);
    }

    protected Double getDouble(String name) {
        return Double.parseDouble(getString(name));
    }

    protected Integer getId() {
        return getInteger("id");
    }

    protected Integer getTemplate() {
        return getInteger("template");
    }

    public BackUser getBackUser() {
        BackUser backUser = (BackUser) getRequest().getSession()
                                           .getAttribute(SESSION_BACK_USER);

        return backUser;
    }

    public String getBasePath() {
        HttpServletRequest request = getRequest();
        String path = request.getContextPath();
        String basePath = request.getScheme() + "://" +
            request.getServerName() + ":" + request.getServerPort() + path +
            "/";

        return basePath;
    }

    public String filterFreeMarkerScript(String source,
        Map<String, Object> entities) throws ScriptException {
        ScriptEngineManager manager = new ScriptEngineManager();
        ScriptEngine engine = manager.getEngineByName("FreeMarker");
        Bindings bindings = engine.createBindings();
        bindings.put(FreeMarkerScriptConstants.STRING_OUTPUT, Boolean.TRUE);

        Iterator iter = entities.entrySet().iterator();

        while (iter.hasNext()) {
            Entry<String, Object> entry = (Entry<String, Object>) iter.next();
            bindings.put(entry.getKey(), entry.getValue());
        }

        String content = engine.eval(source, bindings).toString();

        return content;
    }
    
}
