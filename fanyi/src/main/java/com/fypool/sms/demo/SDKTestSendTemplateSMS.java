package com.fypool.sms.demo;

import java.util.HashMap;
import java.util.Set;

import com.fypool.sms.sdk.CCPRestSDK;
import com.fypool.sms.sdk.CCPRestSDK.BodyType;

public class SDKTestSendTemplateSMS {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		HashMap<String, Object> result = null;

		CCPRestSDK restAPI = new CCPRestSDK();
		restAPI.init("app.cloopen.com", "8883");// 初始化服务器地址和端口，格式如下，服务器地址不需要写https://
		restAPI.setAccount("8a216da85ea31fdd015ec229c10d09af", "db6296cfbbc6485c9240210fd7143263");// 初始化主帐号和主帐号TOKEN
		restAPI.setAppId("8a216da85ea31fdd015ec229c15409b5");// 初始化应用ID
		result = restAPI.sendTemplateSMS("15757130092","模板id" ,new String[]{});

		System.out.println("SDKTestSendTemplateSMS result=" + result);
		
		if("000000".equals(result.get("statusCode"))){
			//正常返回输出data包体信息（map）
			HashMap<String,Object> data = (HashMap<String, Object>) result.get("data");
			Set<String> keySet = data.keySet();
			for(String key:keySet){
				Object object = data.get(key);
				System.out.println(key +" = "+object);
			}
		}else{
			//异常返回输出错误码和错误信息
			System.out.println("错误码=" + result.get("statusCode") +" 错误信息= "+result.get("statusMsg"));
		}
	}

}
