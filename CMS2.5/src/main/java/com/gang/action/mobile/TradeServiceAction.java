package com.gang.action.mobile;

import com.gang.action.BaseAction;

import com.gang.comms.DateHelper;
import com.gang.comms.LazyKiller;
import com.gang.comms.StringHelper;

import com.gang.entity.article.ArticleMobile;
import com.gang.entity.product.Orders;
import com.gang.entity.product.Product;
import com.gang.entity.product.ProductImage;
import com.gang.entity.user.User;

import com.gang.service.mobile.TradeService;
import com.gang.service.template.GetDateTemplateMethodModel;
import com.gang.service.wssvc.Generator;
import com.gang.service.wssvc.JSONArrayGenerator;
import com.gang.service.wssvc.JSONGenerator;

import freemarker.ext.script.FreeMarkerScriptConstants;

import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.InputStreamReader;

import java.nio.charset.Charset;

import java.util.List;

import javax.script.Bindings;
import javax.script.ScriptEngine;
import javax.script.ScriptEngineManager;

import javax.servlet.http.HttpServletResponse;


public class TradeServiceAction extends BaseAction {
    private String user_name;
    private Integer task_id;
    private String hash_password;
    private String active_key;
    private Integer product_id;
    public TradeService service;
    private Integer page_count = 10;
    private Integer page_index;
    private Integer status;

    public Integer getStatus() {
        return status;
    }

    public void setStatus(Integer status) {
        this.status = status;
    }

    public String getUser_name() {
        return user_name;
    }

    public void setUser_name(String user_name) {
        this.user_name = user_name;
    }

    public Integer getPage_count() {
        return page_count;
    }

    public void setPage_count(Integer page_count) {
        this.page_count = page_count;
    }

    public Integer getPage_index() {
        return page_index;
    }

    public void setPage_index(Integer page_index) {
        this.page_index = page_index;
    }

    public Integer getTask_id() {
        return task_id;
    }

    public Integer getProduct_id() {
        return product_id;
    }

    public void setProduct_id(Integer product_id) {
        this.product_id = product_id;
    }

    public void setTask_id(Integer task_id) {
        this.task_id = task_id;
    }

    public String getHash_password() {
        return hash_password;
    }

    public void setHash_password(String hash_password) {
        this.hash_password = hash_password;
    }

    public String getActive_key() {
        return active_key;
    }

    public void setActive_key(String active_key) {
        this.active_key = active_key;
    }

    public TradeService getService() {
        return service;
    }

    public void setService(TradeService service) {
        this.service = service;
    }

    public void info_account() {
        User user = service.get(User.class, "loginName", user_name);

        JSONGenerator json = CheckUser(user, hash_password);

        if (json == null) {
            json = new JSONGenerator();
            json.addGenerator(new Generator("result", Success));
            json.addGenerator(new Generator("user_name", user_name));

            JSONArrayGenerator moneys = new JSONArrayGenerator();
            JSONGenerator money = new JSONGenerator();
            money.addGenerator(new Generator("money_num", user.getMoney()));
            money.addGenerator(new Generator("money_unit", 1));
            moneys.addGenerator(money);
            json.addGenerator(new Generator("account", moneys));
        }

        Write(json.toString());
    }

    public void buy() {
        JSONGenerator result = Success;
        User user = service.get(User.class, "loginName", user_name);
        JSONGenerator json = CheckUser(user, hash_password);
        String orderCode = null;

        if (json == null) {
            json = new JSONGenerator();

            Product product = service.get(Product.class, product_id);

            if (null != product) {
                if (user.getMoney() >= product.getPrice()) {
                    if (product.getStock() > 0) {
                        //没有兑换限制
                        if (product.getUserLimit() == 0) {
                            orderCode = service.buy(user, product);
                            json.addGenerator(new Generator("result", result));
                            json.addGenerator(new Generator("order_id", orderCode));
                        } else {
                            Integer buyCount = service.getBuyCount(user, product_id);

                            //查询用户已经换 了多少个
                            if (buyCount<product.getUserLimit()) {
                                orderCode = service.buy(user, product);
                                json.addGenerator(new Generator("result", result));
                                json.addGenerator(new Generator("order_id", orderCode));
                            } else {
                                result = Error.addGenerator(new Generator("message", "超出兑换限制"));
                                json.addGenerator(new Generator("result", result));
                            }
                        }
                    } else {
                        result = Error.addGenerator(new Generator("message", "商品已售空"));
                        json.addGenerator(new Generator("result", result));
                    }
                } else {
                    result = Error.addGenerator(new Generator("message", "余额不足"));
                    json.addGenerator(new Generator("result", result));
                }
            }
        }

        Write(json.toString());
    }

    public void product_list() {
        List<Product> products = null;
        JSONArrayGenerator arrayGenerator = new JSONArrayGenerator();

        // User user = service.get(User.class, "loginName", user_name);
        // JSONGenerator json = CheckUser(user, hash_password);
        JSONGenerator json = new JSONGenerator();
        products = service.getProducts(page_index, page_count);

        if ((products != null) && (products.size() > 0)) {
            for (Product p : products) {
                JSONGenerator prod = new JSONGenerator();
                prod.addGenerator(new Generator("product_id", p.getId()));
                prod.addGenerator(new Generator("product_name", p.getName()));
                prod.addGenerator(new Generator("product_price", p.getPrice()));
                prod.addGenerator(new Generator("product_image", p.getImage()));
                prod.addGenerator(new Generator("product_stock", p.getStock()));
                prod.addGenerator(new Generator("product_limit", p.getUserLimit()));
                prod.addGenerator(new Generator("product_tradable", p.getTradable()));
                // prod.addGenerator(new Generator("product_type",
                // p.getType().getName()));
                arrayGenerator.addGenerator(prod);
            }

            json.addGenerator(new Generator("result", Success));
            json.addGenerator(new Generator("list", arrayGenerator));
        }

        Write(json.toString());
    }

    public void product_detail() {
        JSONGenerator result = Success;

        // User user = service.get(User.class, "loginName", user_name);
        JSONGenerator json = new JSONGenerator();

        try {
            // 获取编号
            Integer id = getInteger("product_id");

            // 查询商品
            Product p = (Product) service.get(Product.class, id, new LazyKiller().addLazyProperty("getImages"));

            if (p != null) {
                json.addGenerator(new Generator("product_id", p.getId()));
                json.addGenerator(new Generator("product_name", p.getName()));
                json.addGenerator(new Generator("product_price", p.getPrice()));
                json.addGenerator(new Generator("product_image", p.getImage()));
                json.addGenerator(new Generator("product_stock", p.getStock()));
                json.addGenerator(new Generator("product_limit", p.getUserLimit()));
                json.addGenerator(new Generator("product_tradable", p.getTradable()));
                if(StringHelper.isNotBlank(user_name))
                {
                	 User user = service.get(User.class, "loginName", user_name);
                	 if(user!=null)
                	 {
                		 Integer buyCount = service.getBuyCount(user, product_id);
                		 if(p.getUserLimit()>0&&p.getUserLimit()<=buyCount)
                		 {
                			 json.addGenerator(new Generator("user_limit",true));
                		 }
                		 else
                		 {
                			 json.addGenerator(new Generator("user_limit",false));
                		 }
                		 
                	 }
                }
                else
	       		 {
	       			 json.addGenerator(new Generator("user_limit",false));
	       		 }
                if ((p.getImages() != null) && (p.getImages().size() > 0)) {
                    JSONArrayGenerator imgArray = new JSONArrayGenerator();

                    for (ProductImage img : p.getImages()) {
                        JSONGenerator imgJson = new JSONGenerator();
                        imgJson.addGenerator(new Generator("url", img.getUrl()));
                        imgArray.addGenerator(imgJson);
                    }

                    json.addGenerator(new Generator("product_imagelist", imgArray));
                }

                json.addGenerator(new Generator("product_description", p.getDescription()));
            } else {
                result = Error.addGenerator(new Generator("message", "查询错误"));
            }
        } catch (Exception e) {
            e.printStackTrace();
            result = Error.addGenerator(new Generator("message", "查询错误"));
        }

        json.addGenerator(new Generator("result", result));
        Write(json.toString());
    }

    public void product() {
        // 获取编号
        Integer id = getInteger("product_id");

        // 查询商品
        Product p = (Product) service.get(Product.class, id);

        // 加载模版
        String temp = getRealPath("product/iPhone/ProductTemplate.html");
        StringBuilder TemplateHtml = new StringBuilder();
        String html = "";

        try {
            InputStreamReader reader = new InputStreamReader(new FileInputStream(temp), Charset.forName("UTF-8"));
            BufferedReader br = new BufferedReader(reader);
            String line = null;

            while ((line = br.readLine()) != null) {
                TemplateHtml.append(line);
            }

            br.close();
            reader.close();

            ScriptEngineManager manager = new ScriptEngineManager();
            ScriptEngine engine = manager.getEngineByName("FreeMarker");

            Bindings bindings = engine.createBindings();
            bindings.put(FreeMarkerScriptConstants.STRING_OUTPUT, Boolean.TRUE);

            // String content = changeImage(am.getContent());
            bindings.put("product", p);
            bindings.put("basepath", getBasePath());
            bindings.put("getDate", new GetDateTemplateMethodModel());

            html = engine.eval(TemplateHtml.toString(), bindings).toString();

            HttpServletResponse response = getResponse();
            response.setCharacterEncoding("UTF-8");
            getResponse().getWriter().write(html);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void buy_list() {
        JSONArrayGenerator arrayGenerator = new JSONArrayGenerator();
        User user = service.get(User.class, "loginName", user_name);
        JSONGenerator json = CheckLogin(user, hash_password);

        if (json == null) {
            json = new JSONGenerator();

            List<Product> products = service.getBuyList(user_name, page_index, page_count);

            if ((products != null) && (products.size() > 0)) {
                for (Product p : products) {
                    JSONGenerator prod = new JSONGenerator();
                    prod.addGenerator(new Generator("product_id", p.getId()));
                    prod.addGenerator(new Generator("product_name", p.getName()));
                    prod.addGenerator(new Generator("product_price", p.getPrice()));
                    prod.addGenerator(new Generator("product_stock", p.getStock()));
                    prod.addGenerator(new Generator("product_tradable", p.getTradable()));
                    // prod.addGenerator(new Generator("product_type",
                    // p.getType().getName()));
                    arrayGenerator.addGenerator(prod);
                }
            }

            json.addGenerator(new Generator("result", Success));
            json.addGenerator(new Generator("list", arrayGenerator));
        }

        Write(json.toString());
    }

    public void order_list() {
        JSONGenerator result = Success;
        User user = service.get(User.class, "loginName", user_name);
        JSONGenerator json = CheckUser(user, hash_password);
        String orderCode = null;

        if (json == null) {
            json = new JSONGenerator();

            List<Orders> orders = null;

            if (status == 0) {
                orders = service.getOrders(user, page_index, page_count);
            } else {
                orders = service.getOrders(user, (status == 10) ? "已支付" : "已完成", page_index, page_count);
            }

            json.addGenerator(new Generator("result", Success));

            JSONArrayGenerator arrayGenerator = new JSONArrayGenerator();

            if ((orders != null) && (orders.size() > 0)) {
                for (Orders order : orders) {
                    JSONGenerator orderJson = new JSONGenerator();
                    orderJson.addGenerator(new Generator("order_id", order.getOrderCode()));
                    orderJson.addGenerator(new Generator("status", "已支付".equals(order.getStatus()) ? 10 : 11));
                    orderJson.addGenerator(new Generator("create_time", DateHelper.getDate(order.getOrderDate())));
                    orderJson.addGenerator(new Generator("product_id", order.getProduct().getId()));
                    orderJson.addGenerator(new Generator("product_name", order.getProduct().getName()));
                    orderJson.addGenerator(new Generator("product_image", order.getProduct().getImage()));
                    orderJson.addGenerator(new Generator("user_name", order.getUser().getLoginName()));
                    orderJson.addGenerator(new Generator("nick", order.getUser().getNick()));
                    arrayGenerator.addGenerator(orderJson);
                }
            }

            json.addGenerator(new Generator("order_list", arrayGenerator));
        }

        Write(json.toString());
    }
}
