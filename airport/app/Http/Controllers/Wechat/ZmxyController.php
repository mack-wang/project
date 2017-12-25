<?php

namespace App\Http\Controllers\Wechat;

use App\Fetch\Snoopy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZmxyController extends Controller
{
    //芝麻信用网关地址
    public $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
    //商户公钥文件
    //芝麻公钥文件
    public $privateKeyFile = "/home/vagrant/www/vultr/airport/app/Libs/zmxy/zmop/rsa_private_key.pem";
    public $zmPublicKeyFile = "/home/vagrant/www/vultr/airport/app/Libs/zmxy/zmop/zima_public_key.pem";

    //数据编码格式
    public $charset = "UTF-8";
    //芝麻分配给商户的appId
    public $appId = "1003162";


    //生成移动端SDK 集成需要的sign 参数 ，并进行urlEncode
//    public function generateSign($cert_name,$cert_no,$certType='IDENTITY_CARD'){
//
//        $client = new \ZmopClient(
//            $this->gatewayUrl,
//            $this->appId,
//            $this->charset,
//            $this->privateKeyFile,
//            $this->zmPublicKeyFile
//        );
//
//        $request = new \ZhimaAuthInfoAuthorizeRequest();
//        $request->setScene("CQSB");
//        // 授权来源渠道设置为appsdk
//        $request->setChannel("appsdk");
//        // 授权类型设置为2标识为证件号授权见“章节4中的业务入参说明identity_type”
//        $request->setIdentityType("2");
//        // 构造授权业务入参证件号，姓名，证件类型;“章节4中的业务入参说明identity_param”
//        //$request->setIdentityParam("{\"certNo\":\"$certNo\",\"certType\":\"IDENTITY_CARD\", \"name\":\"$name\"}");
//        $request->setIdentityParam("{\"identity_type\":\"CERT_INFO\",\"cert_type\":\"IDENTITY_CARD\",\"cert_name\":\"$cert_name\",\"cert_no\":\"$cert_no\"}");// 必要参数
//        // 构造业务入参扩展参数“章节4中的业务入参说明biz_params”
//        $request->setBizParams("{\"auth_code\":\"M_APPSDK\"}");
//
//        $params = $client->generateEncryptedParamWithUrlEncode($request);
//        $sign = $client->generateSignWithUrlEncode($request);
//
//        $data['gatewayUrl'] = $this->gatewayUrl;
//        $data['appId'] = $this->appId;
//        $data['charset'] = $this->charset;
//        $data['params']=$params;
//        $data['sign'] = $sign;
//        $this->ajaxreturn(array("desc"=>"成功","code"=>1111,"data"=>$data));
//    }


//    public function test($cert_name,$cert_no){
//        $client = new \ZmopClient(
//            $this->gatewayUrl,
//            $this->appId,
//            $this->charset,
//            $this->privateKeyFile,
//            $this->zmPublicKeyFile
//        );
//
//        $request = new \ZhimaCustomerCertificationInitializeRequest();
//        $request->setChannel("apppc");
//        $request->setPlatform("zmop");
//
//        $request->setTransactionId("CQSB".time());// 必要参数
//        //20161230w1010103000048620621(试用)
//        $request->setProductCode("w1010103000048621629");// 必要参数
//
//        $request->setBizCode("FACE");// 必要参数
//        $request->setIdentityParam("{\"identity_type\":\"CERT_INFO\",\"cert_type\":\"IDENTITY_CARD\",\"cert_name\":\"$cert_name\",\"cert_no\":\"$cert_no\"}");// 必要参数
//        $request->setExtBizParam("{}");// 必要参数
//        $response = $client->execute($request);
//        var_dump($response);die();
//        echo json_encode($response);
//    }


    public function test($cert_name,$cert_no){
        $client = new \ZmopClient(
            $this->gatewayUrl,
            $this->appId,
            $this->charset,
            $this->privateKeyFile,
            $this->zmPublicKeyFile
        );

        $request = new \ZhimaAuthInfoAuthorizeRequest();
        $request->setChannel("apppc");
        $request->setPlatform("zmop");
        $request->setIdentityType("2");// 必要参数
        $request->setIdentityParam("{\"name\":\"$cert_name\",\"certType\":\"IDENTITY_CARD\",\"certNo\":\"$cert_no\"}");// 必要参数
        $request->setBizParams("{\"auth_code\":\"M_H5\",\"channelType\":\"app\",\"state\":\"商户自定义\"}");
        $url = $client->generatePageRedirectInvokeUrl($request);
        header("location: ".$url);
    }

}
