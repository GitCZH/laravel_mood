<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-05
 * Time: 下午 05:53
 */
namespace app\Service;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Sms\V20190711\SmsClient;
use TencentCloud\Sms\V20190711\Models\SendSmsRequest;
class SendMsg
{
    public static function send($phones, $code)
    {
        try {
            $cred = new Credential("AKIDtVzFNNpvVptlOn7leIfKiswnNHwNrkV8", "VzTjsQkoW0rSnrNhSwKXWEf172gFDuKW");
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("sms.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);
            $client = new SmsClient($cred, "", $clientProfile);

            $req = new SendSmsRequest();

            $params = array(
//                "PhoneNumberSet" => array( "+8618655959420" ),
                "PhoneNumberSet" => $phones,
//                "TemplateParamSet" => array( "666666" ),
                "TemplateParamSet" => $code,
                "TemplateID" => "766873",
                "SmsSdkAppid" => "1400445563",
                "Sign" => "一只大青"
            );
            $req->fromJsonString(json_encode($params));

            $resp = $client->SendSms($req);

            print_r($resp->toJsonString());
        }
        catch(TencentCloudSDKException $e) {
            echo $e;
        }
    }

    public static function generateCode()
    {

    }
}