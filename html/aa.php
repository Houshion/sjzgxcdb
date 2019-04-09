<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
	</body>
</html>
<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/tooltipbox.js"></script>
	<script type="text/javascript" src="../js/dlc.js" ></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<?php
  $jssdk = new JSSDK('wxa63c07b968990a15', '480a4be4325cf00773490502dd80658e');
  $signPackage = $jssdk->GetSignPackage();
?>
<script language="javascript">
wx.config({
    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端//alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '<?php echo $signPackage["appId"];?>', // 必填，公众号的唯一标识
    timestamp: '<?php echo $signPackage["timestamp"];?>', // 必填，生成签名的时间戳
    nonceStr: '<?php echo $signPackage["nonceStr"];?>', // 必填，生成签名的随机串
    signature: '<?php echo $signPackage["signature"];?>',// 必填，签名，见附录1
    jsApiList: ['checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});

	wx.ready(function(){
		wx.scanQRCode({
					needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
					scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
					success: function (res) {
						var macno =getUrlParam('macno',null,res.resultStr)
						$.ajax({
							type:"post",
							url:dlcUrl()+'user_api/back_info',
							dataType:'json',
							data:{macno:macno},
							success:function(data){
								console.log(data);
								// alert(JSON.stringify(data))
								if(data.code=='1'){
									$('.user_win4').css('display','flex');
									$('#num').text(data.data.number);
									$('#times').text(data.data.use_time+'分钟');
									$('#fees').text(data.data.price);
									$('.use_win4').css('display','flex');
									$('.mask5').show();
									//结束费用
									$('#end_fee').click(function(){
										location.href='pay.html?num='+data.data.number+'&macno='+macno;
									})
								}
							}
						})
				},
				error:function(err){
					// alert(JSON.stringify(err));
				}
		});
})

</script>

<?php
//微信方法
 class JSSDK {
    private $appId;
    private $appSecret;
    public function __construct($appId, $appSecret) {
      $this->appId = $appId;
      $this->appSecret = $appSecret;
    }
    public function getSignPackage() {
      $jsapiTicket = $this->getJsApiTicket();
      $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      $timestamp = time();
      $nonceStr = $this->createNonceStr();
      // 这里参数的顺序要按照 key 值 ASCII 码升序排序
      $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
      $signature = sha1($string);
      $signPackage = array(
        "appId"     => $this->appId,
        "nonceStr"  => $nonceStr,
        "timestamp" => $timestamp,
        "url"       => $url,
        "signature" => $signature,
        "rawString" => $string
      );
      return $signPackage; 
    }
    private function createNonceStr($length = 16) {
      $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $str = "";
      for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
      }
      return $str;
    }
    private function getJsApiTicket() {
      // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
      $data = json_decode(file_get_contents("jsapi_ticket.json"));
      if ($data->expire_time < time()) {
        $accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
        $res = json_decode($this->httpGet($url));
        $ticket = $res->ticket;
        if ($ticket) {
          $data->expire_time = time() + 7000;
          $data->jsapi_ticket = $ticket;
          $fp = fopen("jsapi_ticket.json", "w");
          fwrite($fp, json_encode($data));
          fclose($fp);
        }
      } else {
        $ticket = $data->jsapi_ticket;
      }
      return $ticket;
    }
    private function getAccessToken() {
      // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
      $data = json_decode(file_get_contents("access_token.json"));
      if ($data->expire_time < time()) {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
        $res = json_decode($this->httpGet($url));
        $access_token = $res->access_token;
        if ($access_token) {
          $data->expire_time = time() + 7000;
          $data->access_token = $access_token;
          $fp = fopen("access_token.json", "w");
          fwrite($fp, json_encode($data));
          fclose($fp);
        }
      } else {
        $access_token = $data->access_token;
      }
      return $access_token;
    }
    private function httpGet($url) {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_TIMEOUT, 500);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_URL, $url);
      $res = curl_exec($curl);
      curl_close($curl);
      return $res;
    }
 }
?>