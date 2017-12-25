package com.fypool.component;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.fypool.model.Sms;
import com.fypool.repository.SmsRepository;
import com.fypool.sms.sdk.CCPRestSDK;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

import java.util.HashMap;
import java.util.Set;

@Component
public class SmsUtils {

    @Autowired
    SmsRepository smsRepository;

    @Autowired
    ObjectMapper objectMapper;

    private static final Logger logger = LoggerFactory.getLogger(SmsUtils.class);

    public CCPRestSDK sender() {
        CCPRestSDK restAPI = new CCPRestSDK();
        // 初始化服务器地址和端口，格式如下，服务器地址不需要写https://
        restAPI.init("app.cloopen.com", "8883");
        // 初始化主帐号和主帐号TOKEN
        restAPI.setAccount("8a216da85ea31fdd015ec229c10d09af", "db6296cfbbc6485c9240210fd7143263");
        // 初始化应用ID
        restAPI.setAppId("8a216da85ea31fdd015ec229c15409b5");
        return restAPI;
    }

    public Boolean deal(HashMap<String, Object> result) {
        if ("000000".equals(result.get("statusCode"))) {
            //正常返回输出data包体信息（map）
            HashMap<String, Object> data = (HashMap<String, Object>) result.get("data");
            Set<String> keySet = data.keySet();
            for (String key : keySet) {
                Object object = data.get(key);
                logger.info(key + " = " + object);
            }
            return true;
        } else {
            //异常返回输出错误码和错误信息
            logger.info("错误码=" + result.get("statusCode") + " 错误信息= " + result.get("statusMsg"));
            return false;
        }
    }

    //发送短信验证码
    //【领骄翻易】您的验证码为{1}，请于{2}内正确输入，如非本人操作，请忽略此短信。
    public Boolean sendValid(String phone, String randNumber) {
        HashMap<String, Object> result = null;
        //模板id
        String templateId = "217689";
        CCPRestSDK sender = sender();
        String[] content = new String[2];
        //随机验证码
        content[0] = randNumber;
        content[1] = "5分钟";
        result = sender.sendTemplateSMS(phone, templateId, content);

        Boolean success = deal(result);
        smsRepository.save(new Sms(phone, templateId, randNumber, success ? 1 : 0));
        logger.info("短信发送：" + result);
        return success;
    }

    //管理员创建VIP任务通知
    //【领骄翻易】尊敬的{1}，您的VIP任务已经创建，任务编号为：{2}，感谢您的支持！
    public Boolean sendVip(String phone, String nickname, String taskId) {
        HashMap<String, Object> result = null;
        //模板id
        String templateId = "217787";
        CCPRestSDK sender = sender();
        String[] content = new String[2];
        //昵称和任务编号
        content[0] = nickname;
        content[1] = taskId;
        result = sender.sendTemplateSMS(phone, templateId, content);
        Boolean success = deal(result);
        smsRepository.save(new Sms(phone, templateId, nickname + "," + taskId, success ? 1 : 0));
        logger.info("短信发送：" + result);
        return success;
    }

    //用户任务有译员报价时提醒
    //【领骄翻易】尊敬的{1}，您发布的“{2}”任务已经有译员报价，请及时上线查看。
    public Boolean sendClient(String phone, String nickname, String title) {
        HashMap<String, Object> result = null;
        //模板id
        String templateId = "217994";
        CCPRestSDK sender = sender();
        String[] content = new String[2];
        //昵称和任务编号
        content[0] = nickname;
        content[1] = title;
        result = sender.sendTemplateSMS(phone, templateId, content);

        Boolean success = deal(result);
        smsRepository.save(new Sms(phone, templateId, nickname + "," + title, success ? 1 : 0));
        logger.info("短信发送：" + result);
        return success;
    }

    //账单通知
    //【领骄翻易】尊敬的{1}，您的{2}账单已出，账单总金额{3}，请及时登录翻易结清，如有疑问请拨打{4}。
    public Boolean sendBill(String phone, String nickname, String type, String money, String contact) {
        HashMap<String, Object> result = null;
        //模板id
        String templateId = "219584";
        CCPRestSDK sender = sender();
        String[] content = new String[4];
        //昵称和任务编号
        content[0] = nickname;
        content[1] = type;
        content[2] = money;
        content[3] = contact;
        result = sender.sendTemplateSMS(phone, templateId, content);

        Boolean success = deal(result);
        smsRepository.save(new Sms(phone, templateId, nickname + "," + type + "," + money + "," + contact, success ? 1 : 0));
        logger.info("短信发送：" + result);
        return success;
    }

    //选中译员通知
    //【领骄翻易】尊敬的{1}，您参与的“{2}”任务报价已经被客户选中，请及时登录翻易查看详情，并按时完成翻译任务。
    public Boolean sendSelect(String phone, String nickname, String title) {
        HashMap<String, Object> result = null;
        //模板id
        String templateId = "219585";
        CCPRestSDK sender = sender();
        String[] content = new String[2];
        //昵称和任务编号
        content[0] = nickname;
        content[1] = title;
        result = sender.sendTemplateSMS(phone, templateId, content);

        Boolean success = deal(result);
        smsRepository.save(new Sms(phone, templateId, nickname + "," + title, success ? 1 : 0));
        logger.info("短信发送：" + result);
        return success;
    }

    //客户主动向译员发起在线沟通的通知
    //【领骄翻易】尊敬的{1}，发布“{2}”任务的客户{3}向您发起在线沟通的请求，请及时登录翻易查看沟通信息。
    public Boolean sendUser(String phone, String nickname, String title, String nickname2) {
        HashMap<String, Object> result = null;
        //模板id
        String templateId = "219586";
        CCPRestSDK sender = sender();
        String[] content = new String[3];
        //昵称和任务编号
        content[0] = nickname;
        content[1] = title;
        content[2] = nickname2;
        result = sender.sendTemplateSMS(phone, templateId, content);

        Boolean success = deal(result);
        smsRepository.save(new Sms(phone, templateId, nickname + "," + title + "," + nickname2, success ? 1 : 0));
        logger.info("短信发送：" + result);
        return success;
    }

    //译员上传稿件通知3
    //【领骄翻易】尊敬的{1}，译员{2}已经完成您的任务“{3}”并上传稿件，请及时登录翻易查看。
    public Boolean sendTranslated(String phone, String nickname, String nickname2,String title) {
        HashMap<String, Object> result = null;
        //模板id
        String templateId = "219583";
        CCPRestSDK sender = sender();
        String[] content = new String[3];
        //昵称和任务编号
        content[0] = nickname;
        content[1] = nickname2;
        content[2] = title;
        result = sender.sendTemplateSMS(phone, templateId, content);

        Boolean success = deal(result);
        smsRepository.save(new Sms(phone, templateId, nickname + "," + nickname2 + "," + title, success ? 1 : 0));
        logger.info("短信发送：" + result);
        return success;
    }

    //vip服务上传稿件通知
    //【领骄翻易】尊敬的{1}，您的VIP服务“{2}”，已经上传稿件，请及时登录翻易查看。
    public Boolean sendVipTranslated(String phone, String nickname, String title) {
        HashMap<String, Object> result = null;
        //模板id
        String templateId = "220809";
        CCPRestSDK sender = sender();
        String[] content = new String[3];
        //昵称和任务编号
        content[0] = nickname;
        content[1] = title;
        result = sender.sendTemplateSMS(phone, templateId, content);

        Boolean success = deal(result);
        smsRepository.save(new Sms(phone, templateId, nickname + "," + title, success ? 1 : 0));
        logger.info("短信发送：" + result);
        return success;
    }

    // 超级管理员强制修改用户的支付密码，发送短信到用户的手机上
    //【领骄翻易】尊敬的{1}，您的支付密码已经重置为“{2}”，请及时上线修改支付密码，避免泄露。

    public Boolean sendPayPassword(String phone, String nickname, String password) {
        HashMap<String, Object> result = null;
        //模板id
        String templateId = "221403";
        CCPRestSDK sender = sender();
        String[] content = new String[3];
        //昵称和任务编号
        content[0] = nickname;
        content[1] = password;
        result = sender.sendTemplateSMS(phone, templateId, content);

        Boolean success = deal(result);
        smsRepository.save(new Sms(phone, templateId, nickname + "," + password, success ? 1 : 0));
        logger.info("短信发送：" + result);
        return success;
    }
}
