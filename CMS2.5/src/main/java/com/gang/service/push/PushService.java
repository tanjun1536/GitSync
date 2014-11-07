package com.gang.service.push;

import com.baidu.yun.channel.auth.ChannelKeyPair;
import com.baidu.yun.channel.client.BaiduChannelClient;
import com.baidu.yun.channel.exception.ChannelClientException;
import com.baidu.yun.channel.exception.ChannelServerException;
import com.baidu.yun.channel.model.PushBroadcastMessageRequest;
import com.baidu.yun.channel.model.PushBroadcastMessageResponse;
import com.baidu.yun.core.log.YunLogEvent;
import com.baidu.yun.core.log.YunLogHandler;

import com.gang.entity.push.Push;
import com.gang.entity.push.PushConfig;

import com.gang.service.BaseService;

import java.util.Date;


public class PushService extends BaseService {
    // 绵阳
    // String apiKey = "mH637WbFb5OmHVKukoGnYIQA";
    // String secretKey = "sIGVsCHCQH6zqgumiDCZVB8qsKQKQYXp";
    // 南充
    // String apiKey = "6SKyWvMEBOv0rRp9gMs2RNSv";
    // String secretKey = "MFm7v0qdMILGPXo7vWcTkrgMbI78tlwy";
    public void Push(Push push) {
        PushConfig pc = this.get(PushConfig.class, 1);
        pushAndroid(push, pc);
        pushIos(push, pc);
        push.setCreateDate(new Date());
        push.setResult("");
        this.add(push);
    }

    private String pushAndroid(Push push, PushConfig pc) {
        String result = "";
        ChannelKeyPair pair = new ChannelKeyPair(pc.getApiKey(), pc.getSecretKey());

        // 2. 创建BaiduChannelClient对象实例
        BaiduChannelClient channelClient = new BaiduChannelClient(pair);

        // 3. 若要了解交互细节，请注册YunLogHandler类
        channelClient.setChannelLogHandler(new YunLogHandler() {
                @Override
                public void onHandle(YunLogEvent event) {
                    System.out.println(event.getMessage());
                }
            });

        try {
            // 4. 创建请求类对象
            PushBroadcastMessageRequest request = new PushBroadcastMessageRequest();
            request.setDeviceType(3); // device_type => 1: web 2: pc 3:android
                                      // 4:ios 5:wp

            request.setMessage(push.getMessage());

            // 若要通知，
            // request.setMessageType(1);
            // request.setMessage("{\"title\":\"Notify_title_danbo\",\"description\":\"Notify_description_content\"}");

            // 5. 调用pushMessage接口
            PushBroadcastMessageResponse response = channelClient.pushBroadcastMessage(request);

            // 6. 认证推送成功
            System.out.println("push amount : " + response.getSuccessAmount());
            result = "推送成功";
        } catch (ChannelClientException e) {
            // 处理客户端错误异常
            e.printStackTrace();
        } catch (ChannelServerException e) {
            // 处理服务端错误异常
            result = String.format("request_id: %d, error_code: %d, error_message: %s", e.getRequestId(), e.getErrorCode(), e.getErrorMsg());
        }

        return result;
    }

    public String pushIos(Push push, PushConfig pc) {
        String result = "";
        ChannelKeyPair pair = new ChannelKeyPair(pc.getApiKey(), pc.getSecretKey());

        // 2. 创建BaiduChannelClient对象实例
        BaiduChannelClient channelClient = new BaiduChannelClient(pair);

        // 3. 若要了解交互细节，请注册YunLogHandler类
        channelClient.setChannelLogHandler(new YunLogHandler() {
                @Override
                public void onHandle(YunLogEvent event) {
                    System.out.println(event.getMessage());
                }
            });

        try {
            // 4. 创建请求类对象
            PushBroadcastMessageRequest request = new PushBroadcastMessageRequest();
            request.setDeviceType(4); // device_type => 1: web 2: pc 3:android
                                      // 4:ios 5:wp

            request.setMessageType(1);
            request.setDeployStatus(pc.getDeployStatus()); // DeployStatus => 1: Developer 2:
                                        // Production

            request.setMessage("{\"aps\":{\"alert\":\""+push.getMessage()+"\"}}");

            // 5. 调用pushMessage接口
            PushBroadcastMessageResponse response = channelClient.pushBroadcastMessage(request);

            // 6. 认证推送成功
            System.out.println("push amount : " + response.getSuccessAmount());
            result = "推送成功";
        } catch (ChannelClientException e) {
            // 处理客户端错误异常
            e.printStackTrace();
        } catch (ChannelServerException e) {
            // 处理服务端错误异常
            result = String.format("request_id: %d, error_code: %d, error_message: %s", e.getRequestId(), e.getErrorCode(), e.getErrorMsg());
        }

        return result;
    }
}
