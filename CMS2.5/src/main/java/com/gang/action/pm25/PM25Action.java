package com.gang.action.pm25;

import com.gang.action.DefaultAction;

import java.io.BufferedReader;
import java.io.InputStreamReader;

import java.net.HttpURLConnection;
import java.net.URL;

import java.text.SimpleDateFormat;

import java.util.Date;
import java.util.HashMap;
import java.util.Map;


public class PM25Action extends DefaultAction {
    public static Map<String, String> Cache = new HashMap<String, String>(1);

    public void get_pm_2_5() throws Exception {
        String api = "http://www.pm25.in/api/querys/pm2_5.json";
        String token = "5j1znBVAsnSf5xQyNQyq";
        String city = "nanchong";
        String url = new StringBuffer(api).append("?token=").append(token)
                                          .append("&city=").append(city)
                                          .toString();
        StringBuilder sb = new StringBuilder();
        SimpleDateFormat sdf = new SimpleDateFormat("yyyyMMdd");
        String key = sdf.format(new Date());

        if (Cache.containsKey(key)) {
            Write(Cache.get(key));

            return;
        }

        URL getUrl = new URL(url);

        // 根据拼凑的URL，打开连接，URL.openConnection函数会根据URL的类型，
        // 返回不同的URLConnection子类的对象，这里URL是一个http，因此实际返回的是HttpURLConnection
        HttpURLConnection connection = (HttpURLConnection) getUrl.openConnection();
        // 进行连接，但是实际上get request要在下一句的connection.getInputStream()函数中才会真正发到
        // 服务器
        connection.connect();

        // 取得输入流，并使用Reader读取
        BufferedReader reader = new BufferedReader(new InputStreamReader(
                    connection.getInputStream(), "utf-8")); // 设置编码,否则中文乱码

        String line;

        while ((line = reader.readLine()) != null) {
            // lines = new String(lines.getBytes(), "utf-8");
            sb.append(line);
        }

        Cache.put(key, sb.toString());
        reader.close();
        connection.disconnect();
        Write(sb.toString());
    }
}
