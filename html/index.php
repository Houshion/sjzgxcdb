<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<title>共享充电宝</title>
	<link rel="stylesheet" type="text/css" href="../css/zy_common.css"/>
	<link rel="stylesheet" type="text/css" href="../css/zy_index.css"/>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/tooltipbox.js"></script>
	<script type="text/javascript" src="../js/dlc.js" ></script>
	<style>
		div[onpositionupdate="return;"],div[draggable="false"]{display: none;}
	</style>
</head>
<body>
	<div id="allmap"></div>
	<a id="list" href="zy_person_center.html">
		<img src="../img/person.png"/>
	</a>
	<div id="tool">
		<p class="getlocal"><img src="../img/location.png" style="width: 75%;"/></p>
		<div id="scanQRCode1"><img src="../img/sao.png"/></div>
		<a class="tel" id="sell_list"><img src="../img/nearby.png" alt="" style="width: 75%;"/></a>
	</div>
	<!--搜索框-->
	<header class="hd_search" id="hd_search" style="display: none;">
		<a><img src="../img/search.png"/><span>请输入搜索内容</span></a>
	</header>
	
	<!--详情-->
	<section class="Using_details" style="display: none;">
		<!--<div class="shop_details flex-center marginLR-20 paddingTB-3 border_bottom">
			<img src="../img/bg1.png" style="width: 1.76rem;height: 1.3rem;margin-right: 0.2rem;"/>
			<div class="flex-1">
				<p class="font-15 color-333">广东东莞南城高盛科技22号</p>
				<p class="font-14 color-999"><img src="../img/time.png" /><span>10:00-20:00</span></p>
				<p class="font-14 color-999"><img src="../img/s_location.png" /><span>广东东莞南城高盛科技路</span></p>
			</div>
		</div>
		<div class="flex-center  marginLR-20 justify-between color-999 font-14">
			<span>设备编号:&nbsp;0225</span>
			<span><img src="../img/an.png"  style="width: 0.3rem;"/>&nbsp;20</span>
			<span><img src="../img/ios.png"  style="width: 0.26rem;"/>&nbsp;20</span>
			<span>可归还&nbsp;50</span>
		</div>-->
	</section>
	<!--使用弹窗-->
	<div class="mask mask1 mask2 mask3 mask4 mask5" style="display: none;"></div>
	<section class="use_win" style="display: none;" id="user_win">
		<img src="../img/logo.png"/>
		<div class="cd_cot font-15 text-center">
			<p class="color-999">充电宝ID</p>
			<p class="color-333" id="device_num">45421854352135</p>
		</div>
		<a  class="confirm_index" id="userBtn">确认</a>
	</section>
	<!--缴押金-->
	<section class="user_win1" style="display: none;">
		<img src="../img/message.png"/>
		<p class="font-16 color-333">请缴纳押金再去充电哟</p>
		<a class="confirm_index" id="yj_recharge">充押金</a>
	</section>
	<!--充值-->
	<section class="user_win2" style="display: none;">
		<img src="../img/message.png"/>
		<p class="font-16 color-333">余额不足，快快充值！</p>
		<a href="recharge.html" class="confirm_index">去充值</a>
	</section>
	<!--弹出电源-->
	<section class="user_win3" style="display: none;">
		<img src="../img/power.png"/>
		<p class="font-16 color-333">请等待弹出卡槽</p>
	</section>
	
	<!--结束弹窗-->
	<section class="use_win use_win4" style="top: calc(50% - 2.4rem);display: none;">
		<img src="../img/logo.png"/>
		<div class="cd_cot font-15 text-center">
			<p class="color-999">充电宝ID</p>
			<p class="color-333 border_bottom" id="num">45421854352135</p>
			<p class="color-999">使用时间:<span id="times">30:00</span></p>
			<p class="color-999">费用:<span id="fees">30:00</span></p>
		</div>
		<a  class="confirm_index" id="end_fee">结算费用</a>
	</section>
</body>
</html>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<script type="text/javascript">
	$("div#allmap").on("click", function () {
		// $(".Using_details").hide();
	});
	
	// $(".Using_details").on("click", function () {
	// 	$(".use_win").hide();
	// 	$(".use_win1").hide();
	// 	$(".use_win2").hide();
	// 	$(".use_win3").hide();
	// 	$(".use_win4").hide();
	// })

	$('#yj_recharge').click(function(){
		location.href = 'deposit.html?from=1';
	});
	var geolocation = new qq.maps.Geolocation("N6RBZ-AJN35-AACI2-Q2ICF-HYV6O-JRBBZ", "myapp");
	var options = {
		timeout: 4000
	};
	$('.getlocal').click(function(){
		location.replace('./index.php');
	});
	var lng='',lat='',seller_id='';
	loadingShow();
	var id=getUrlParam('id');
		if(id==1){//详情
			console.log(getUrlParam('seller_id'));
			$('.Using_details').show();
//				获取详情
			$.ajax({
				type:"POST",
				data:{seller_id:getUrlParam('seller_id')},
				url:dlcUrl()+"user_api/seller_detail",
				dataType:'json',
				success:function(data){
					console.log(data);
					var str='';
					if(data.code=='1'){
						seller_id=data.data.seller_id;
						str='<div class="shop_details flex-center marginLR-20 paddingTB-3 border_bottom">'+
							'<img src="'+data.data.img+'" style="width: 1.76rem;height: 1.3rem;margin-right: 0.2rem;"/>'+
							'<div class="flex-1">'+
								'<p class="font-15 color-333">'+data.data.agentname+'</p>'+
								'<p class="font-14 color-999"><img src="../img/time.png" /><span>'+data.data.work_hours+'</span></p>'+
								'<p class="font-14 color-999"><img src="../img/s_location.png" /><span>'+data.data.addr+'</span></p>'+
							'</div>'+
						'</div>'+
						'<div class="flex-center  marginLR-20 justify-between color-999 font-14">'+
							'<span>设备编号:&nbsp;'+data.data.macno+'</span>'+
							'<span><img src="../img/an.png"  style="width: 0.3rem;"/>&nbsp;'+data.data.androids+'</span>'+
							'<span><img src="../img/ios.png"  style="width: 0.26rem;"/>&nbsp;'+data.data.apples+'</span>'+
							'<span>可归还&nbsp;'+data.data.frees+'</span>'+
						'</div>';
						$('.Using_details').html(str)
				}
				}
			});
		}else{
			$('.hd_search').show();
			if(id=='2'){
				$('#device_num').text(getUrlParam('number'));
				$('.mask1').show();
				$('#user_win').css('display','flex');
			}else if(id=='3'){
				$('.mask2').show();
				$('.user_win1').css('display','flex');
			}else if(id=='4'){
				$('.mask3').show();
				$('.user_win2').css('display','flex');
			}
		}

		function showPosition(position) {
			console.log(position);
			lat=position.lat;
			lng=position.lng;
			center = new qq.maps.LatLng(lat,lng);
			map = new qq.maps.Map(document.getElementById('allmap'),{
				center: center,
				zoom: 14,
				zoomControl: false,
				draggable: true,//手势控制, 用来设置地图是否能够鼠标拖拽，默认值为“可以”；
				scrollwheel: false,//用来配置地图是否能够通过鼠标滚轮操作进行放大，默认值为“可以”；
				disableDoubleClickZoom: false// 用来配置地图是否可以通过鼠标双击进行放大，默认值为“可以”。
			});
			qq.maps.event.addListener(map, 'center_changed', function() {//地图中心发生变化
				$('.Using_details').hide();
				$('#hd_search').show();
				$('.user_win1').hide();
			});
			qq.maps.event.addListener(map, 'click', function() {
				$('.Using_details').hide();
			});
			//创建marker
			var my_pos = new qq.maps.Marker({
				position: center,
				map: map
			});

			//自定义标注图标
			var anchor = new qq.maps.Point(45, 45),
					size = new qq.maps.Size(90,90),
					origin = new qq.maps.Point(0, 0),
					markerIcon = new qq.maps.MarkerImage(
							"../img/ic_location.png",
							size,
							origin,
							anchor
					);
			my_pos.setIcon(markerIcon);
			$('#sell_list').click(function(){
				window.location.href='zy_nearby.html?lng='+lng+'&lat='+lat;
			});
			$('#hd_search').click(function(){
				window.location.href='zy_search.html?lng='+lng+'&lat='+lat;
			});
			//关闭使用弹窗
			$('.mask1').on('click',function(){
				$(this).hide();
				$('.use_win').hide();
				window.location.href="index.php";
			});
			//
			$('#userBtn').on('click',function(){
				$('.mask1').hide();
				$('.use_win').hide();
				window.location.href="index.php";
			});

			//关闭押金弹窗
			$('.mask2').on('click',function(){
				$(this).hide();
				$('.user_win1').hide();
			});
			//关闭充值弹窗
			$('.mask2').on('click',function(){
				$(this).hide();
				$('.user_win2').hide();
			});
			//关闭弹出电源弹窗
			$('.mask4').on('click',function(){
				$(this).hide();
				$('.user_win3').hide();
			});
			//关闭结束费用弹窗
			$('.mask5').on('click',function(){
				$(this).hide();
				$('.user_win4').hide();
			});
			//跳转到详情
			$('.Using_details').click(function(){
				location.href='shop_data.html?seller_id='+seller_id;
			})
			$.ajax({
				type:"post",
				url:dlcUrl()+'user_api/nearby_seller',
				dataType:'json',
				data:{lat:lat,lng:lng},
				success:function(res){
					loadingHide();
					var ret=[];markers=[];
					for(i in res.data) {
						ret.push({'lng':res.data[i].lng,'lat':res.data[i].lat,'macno':res.data[i].macno,'addr':res.data[i].addr,'name':res.data[i].agentname,'work_hours':res.data[i].work_hours,'androids':res.data[i].androids,'apples':res.data[i].apples,'frees':res.data[i].frees,'img':res.data[i].img,'seller_id':res.data[i].seller_id});
					}
					for(var i in ret){
						var logo1 = new qq.maps.LatLng(ret[i].lat,ret[i].lng);
						//创建marker
						var logo = new qq.maps.Marker({
							position: logo1,
							map: map,
							zIndex:1
						});
						//自定义标注图标
						var anchor = new qq.maps.Point(24,26),
								size = new qq.maps.Size(48,52),
								origin = new qq.maps.Point(0, 0),
								markerIcon = new qq.maps.MarkerImage(
										"../img/logo.png",
										size,
										origin,
										anchor
								);
						logo.setIcon(markerIcon);
						//设置属性
						logo.lat=ret[i].lat;
						logo.lng=ret[i].lng;
						logo.macno=ret[i].macno;
						logo.addr=ret[i].addr;
						logo.name=ret[i].name;
						logo.work_hours=ret[i].work_hours;
						logo.androids=ret[i].androids;
						logo.apples=ret[i].apples;
						logo.frees=ret[i].frees;
						logo.img=ret[i].img;
						logo.seller_id=ret[i].seller_id;
						//获取标记的点击事件
						qq.maps.event.addListener(logo, 'click', function(e){
							console.log(e);
							$('.Using_details').show();
							$('#hd_search').hide();
							var str='';
							seller_id= e.target.seller_id;
							console.log(seller_id)
							str='<div class="shop_details flex-center marginLR-20 paddingTB-3 border_bottom">'+
									'<img src="'+ e.target.img+'" style="width: 1.76rem;height: 1.3rem;margin-right: 0.2rem;"/>'+
									'<div class="flex-1">'+
									'<p class="font-15 color-333">'+e.target.name+'</p>'+
									'<p class="font-14 color-999"><img src="../img/time.png" /><span>'+ e.target.work_hours+'</span></p>'+
									'<p class="font-14 color-999"><img src="../img/s_location.png" /><span>'+ e.target.addr+'</span></p>'+
									'</div>'+
									'</div>'+
									'<div class="flex-center  marginLR-20 justify-between color-999 font-14">'+
									'<span>设备编号:&nbsp;'+ e.target.macno+'</span>'+
									'<span><img src="../img/an.png"  style="width: 0.3rem;"/>&nbsp;'+ e.target.androids+'</span>'+
									'<span><img src="../img/ios.png"  style="width: 0.26rem;"/>&nbsp;'+ e.target.apples+'</span>'+
									'<span>可归还&nbsp;'+ e.target.frees+'</span>'+
									'</div>';
							$('.Using_details').html(str);
						});
					}

				},
				error:function(err){
					console.log(err)
				}
			});
		}
		function showErr(err) {
			positionNum++;
		};
		geolocation.getLocation(showPosition, showErr, options);
</script>
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
		$('#scanQRCode1').click(function(){
			//if(getUrlParam('status')=='1'){ //还
				wx.scanQRCode({
					needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
					scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
					success: function (res) {
					var macno =getUrlParam('macno',null,res.resultStr); // 当needResult 为 1 时，扫码返回的结果
					$.ajax({
							type:"post",
							url:dlcUrl()+'user_api/isUserBorrow',
							dataType:'json',  
							success:function(ret){
								if(ret.code==0){ 
									//还
									$.ajax({
										type:"post",
										url:dlcUrl()+'user_api/back_open',
										dataType:'json',
										data:{macno:macno},    
										success:function(data){
											console.log(data);
											//alert(JSON.stringify(data))
											if(data.code=='1'){
												$('.user_win3').show()
												setTimeout(function(){
													$.ajax({
														type:"post",
														url:dlcUrl()+'user_api/back_info',
														dataType:'json',
														data:{macno:macno},
														success:function(res){
															console.log(data);
															//alert(JSON.stringify(data))
															if(data.code=='1'){
																$('.user_win3').hide()
																$('.user_win4').css('display','flex');
																$('#num').text(res.data.number);
																$('#times').text(res.data.use_time+'分钟');
																$('#fees').text(res.data.price+'元');
																$('.use_win4').css('display','flex');
																$('.mask5').show();
																//结束费用
																$('#end_fee').click(function(){
																	location.href='pay.html?num='+res.data.number+'&macno='+macno;
																})
															}
														}
													})
												},2000)
											}else{
												
											}
										}
									})
								}else if(ret.code == 1){
									//借
									window.localStorage.setItem("macno", macno)
									location.href='charging_type.html?macno='+macno;
								}else if(ret.code == 2){
									window.location.href='pay.html?number='+ret.data+'&macno='+macno;
								}else{

								}
							}
					})
					
					
					

					//结束费用
					/*if(getUrlParam('status')=='1'){
//						var macno='1000100010001042';
						$.ajax({
							type:"post",
							url:dlcUrl()+'user_api/back_info',
							dataType:'json',
							data:{macno:macno},
							success:function(data){
								console.log(data);
								alert(JSON.stringify(data))
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
					}*/
				},
				error:function(err){
//					alert(JSON.stringify(err));
				}
				});
//			}else{//借
//				wx.scanQRCode({
//					needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
//					scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
//					success: function (res) {
//						var macno =getUrlParam('macno',null,res.resultStr); 
//						location.href='charging_type.html?macno='+macno;
//				},
//				error:function(err){
//					alert(JSON.stringify(err));
//				}
//				});
//			}
	//setTimeout(function(){ WeixinJSBridge.call('closeWindow'); }, 500);
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