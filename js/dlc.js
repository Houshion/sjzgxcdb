/**
 * Created by Administrator on 2017/5/24.
 */
var ajax_url='http://kybaoxiu.app.xiaozhuschool.com/App/Api/api'
var more_url='http://kybaoxiu.app.xiaozhuschool.com/App/more/api/'

function showMask(){
    $('.mask').remove();
    $('body').append('<div class="mask" style="position: fixed;height: 100%;width: 100%;top:0;background:rgba(0,0,0,0.6);z-index: 1;"></div>');
}
//数据为空提示
function emptyTip(tip){
    return '<div class="h20"></div><div class="empty"><div class="logo"><img src="../img/empty_page_nothing.png"></div><div class="msg" style="color: #999;">'+tip+'</div></div>';
}
//判断身份证格式是否正确
function checkIdCode(value){
    return /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(value);
}
//判断是否为空
function isNull(value){
    if($.trim(value).length){
        return false;
    }else{
        return true;
    }
}
//判断手机或者电话号码格式
function checkMobileAndTel(value){
    return /^1(3|4|5|7|8)\d{9}$/.test(value);
};
//判断邮箱格式
function checkEmail(value){
	return /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/.test(value);
}
//多张图片上传，配合表单使用
function upLoadImg(file,picbox,size){
    var size = size?size:1;
    if($('.shade').length == 0){
        $('body').append($('<div class="shade" onclick="javascript:closeShade()" style="position: absolute;width: 100%;height: 100%;top: 0;left: 0;background: rgba(0, 0, 0, 0.2);z-index: 1000;display: none;"><div class="" style="width: 300px;height: 200px;line-height: 200px;position: absolute;top: 50%;left: 50%;margin-top: -100px;margin-left: -150px;background: white;border-radius: 5px;text-align: center;"><span class="text_span"></span></div></div>'));
    }
    if($('.shadeImg').length == 0) {
        $('body').append($('<div class="shadeImg" onclick="javascript:closeShadeImg()" style="position: absolute;display: none;width: 100%;height: 100%;top: 0;left: 0;z-index: 15;text-align: center;background: rgba(0, 0, 0, 0.2);"><div><img class="showImg" src="" style="width: 100%;margin-top: 140px;"></div></div>'));
    }
    var objUrl;
    var img_html;
    var template = $(file).parent().html();
    var picbox = document.getElementById(picbox);
    var filepath = $(file).val();
    if($(picbox).children('label').length > size){
        $(".shade").fadeIn(500);
        $(".text_span").text("最多可以上传"+size + '张图片');
        $(picbox).find('label:last input').attr('name','');
        return false;
    }else{
        $(picbox).find('label:last input').attr('name',"backpics[]");
    };
    for(var i = 0; i < file.files.length; i++) {
        objUrl = getObjectURL(file.files[i]);
        var extStart = filepath.lastIndexOf(".");
        var ext = filepath.substring(extStart, filepath.length).toUpperCase();
        if(ext != ".BMP" && ext != ".PNG" && ext != ".GIF" && ext != ".JPG" && ext != ".JPEG") {
            $(".shade").fadeIn(500);
            $(".text_span").text("图片限于bmp,png,gif,jpeg,jpg格式");
            return false;
        } else {
            img_html = "<div class='isImg' style='height: 100%'><img src='" + objUrl + "' onclick='javascript:lookBigImg(this)' style='height: 100%; width: 100%;' /><button class='removeBtn' onclick='javascript:removeImg(this)' style='position:absolute;right: 0;top: 0;background: rgba(0,0,0,0.2);color: #fff;border-radius: 50%;width: 0.3rem;height: 0.3rem;font-size: 0.1rem;display: flex;align-items: center;justify-content: center;'>x</button></div>";
            $(file).parent().append(img_html);
            var obj = $('<label class="a-upload fl" style="position: relative">'+template+'</label>');
            $(picbox).append(obj);
        }
    }
    return true;
}
function getObjectURL(file) {
    var url = null;
    if(window.createObjectURL != undefined) {
        url = window.createObjectURL(file);
    } else if(window.URL != undefined) {
        url = window.URL.createObjectURL(file);
    } else if(window.webkitURL != undefined) {
        url = window.webkitURL.createObjectURL(file);
    }
    return url;
}
function removeImg(r){
    $(r).parents('label').remove();
    event.stopPropagation();
    event.preventDefault();
    return false;
}
function lookBigImg(b){
    $(".shadeImg").fadeIn(500);
    $(".showImg").attr("src",$(b).attr("src"));
    event.stopPropagation();
    event.preventDefault();
    return false;
}
function closeShade(){
    $(".shade").fadeOut(500);
}
function closeShadeImg(){
    $(".shadeImg").fadeOut(500);
};
/*图片上传end*/
/*日期格式化*/
function formatDate(now,ff) {
    var year=now.getFullYear();
    var month=now.getMonth()+1<10?'0'+(now.getMonth()+1):now.getMonth()+1;
    var date=now.getDate()<10?'0'+now.getDate():now.getDate();
    var hour=now.getHours()<10?'0'+now.getHours():now.getHours();
    var minute=now.getMinutes()<10?'0'+now.getMinutes():now.getMinutes();
    var second=now.getSeconds()<10?'0'+now.getSeconds():now.getSeconds();
    if(ff=='Y-m-d'){
        return year+"-"+month+"-"+date;
    }else if(ff=='Y-m-d H:i:s'){
        return year+"-"+month+"-"+date+" "+hour+":"+minute+":"+second;
    }else if(ff=='Y-m-d H:i'){
    	return year+"-"+month+"-"+date+" "+hour+":"+minute;
    }
}
function format(time,ff){
    if(time.length==10)time=time*1000;
    var d=new Date(time);
    return formatDate(d,ff);
}
//加载中
function loadingShow(){
    $('.loading').remove();
    var str = '<div class="loading"><div class="spinner5"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div><div class="bounce4"></div></div><div class="loadingTip" style="margin-top: 0.2rem;">加载中...</div></div>';
    $('body').append(str);
}
//关掉加载
function loadingHide(){
    $('.loading').remove();
}
/**
 * 获取url参数
 */
function getUrlParam(name, explode, url){
    var param = window.location.search.substr(1);
    if(url){
        if(explode){
            param = url.substr(url.indexOf(explode) + 1);
        }else{
            param = url.substr(url.indexOf('?') + 1);
        }
    }else{
        if(explode){
            param = window.location.href.substr(window.location.href.indexOf(explode) + 1);
        }
    }
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = param.match(reg);
    if (r != null) return unescape(r[2]); return '';
}
//判断checkbox被选中的个数
function checkedLong(str){
    return $(str+":checked").length;
}
function dlc_request(method, data, cb,type){
    var data = data || {};
    url = dlcUrl()+'user_api/'+method;
    $.ajax({
        type: type?type:'post',
        url: url,
        data: data,
        dataType: 'json',
        crossDomain:true,
        success:function(res){
            if(cb)cb(res);
        },
        error:function(){
            //
        }
    });
}

function preview(Class){
	$('body').append('<div class="yuLanBox"><img style="width: 100%;"/></div>');
		//图片预览
		$(Class).on('click',function(){
			var img_url=$(this).attr('src');
			$('.yuLanBox').fadeIn(300).css('display','flex');
			$('.yuLanBox img').attr('src',img_url);
			
		})
		$('.yuLanBox').click(function(){
			$(this).fadeOut(300)
		})	
}
//去掉alert上面的服务器地址
window.alert = function(name){
var iframe = document.createElement("IFRAME");
iframe.style.display="none";
iframe.setAttribute("src", 'data:text/plain,');
document.documentElement.appendChild(iframe);
window.frames[0].window.alert(name);
iframe.parentNode.removeChild(iframe);
};

//去掉confirm上面的服务器地址
window.confirm = function (message) {
var iframe = document.createElement("IFRAME");
iframe.style.display = "none";
iframe.setAttribute("src", 'data:text/plain,');
document.documentElement.appendChild(iframe);
var alertFrame = window.frames[0];
var result = alertFrame.window.confirm(message);
iframe.parentNode.removeChild(iframe);
return result;
};
//长按事件
$.fn.longPress = function(fn) {
   var timeout = undefined;
   var $this = this;
   for(var i = 0;i<$this.length;i++){
      $this[i].addEventListener('touchstart', function(event) {
         timeout = setTimeout(fn, 800);  //长按时间超过800ms，则执行传入的方法
      }, false);
      $this[i].addEventListener('touchend', function(event) {
         clearTimeout(timeout);  //长按时间少于800ms，不会执行传入的方法
      }, false);
   };
};

//禁止长按弹出的菜单
function banMenu(){
	document.oncontextmenu = new Function("return false;") 
}
function addEventback(){
	pushHistory();
	var bool=false;  
	setTimeout(function(){  
	      bool=true;  
	},1500);  
	window.addEventListener("popstate", function(e) {  
	  if(bool){  
	        //alert("我监听到了浏览器的返回按钮事件啦");//根据自己的需求实现自己的功能  
	        location.reload();
	    }  
	    pushHistory();
	}, false); 
}
function pushHistory(){
   	var state = {
        title : "",
        url : "#"
    };
    window.history.replaceState(state, "", "#");	
}

















