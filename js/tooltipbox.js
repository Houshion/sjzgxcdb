    //弹出提示
	var tooltipbox = {
		clear: function(){
			$('#tooltipbox_show_div,#tooltipbox_alert').remove();
		},
        
        show: function(msg, position, duration, keep) {
			if(!keep)this.clear();

            if(!msg){
                var m=document.getElementById('tooltipbox_show_div');
                    var d = 0.2;
                    m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
                    m.style.opacity = '0';
                    setTimeout(function() {
                        try{ document.body.removeChild(m); }catch(e){}
                    }, d * 1000);
                    return;
            }
           if(position!='bottom' && position!='middle' && position!='top'){
               position ='bottom';
           }
           
            duration = isNaN(duration) ? 1000 : duration;
            var m = document.createElement('div');
            m.id = 'tooltipbox_show_div';
            m.innerHTML = msg;
            var css = "width:60%; font-size:14px;min-width:150px; background:#000; opacity:0.7; min-height:35px; overflow:hidden; color:#fff; line-height:35px; text-align:center; border-radius:5px; position:fixed; left:20%; z-index:999999;";
            if(position=='top'){
                css+="top:10%; ";
            } else if(position=='bottom'){
                 css+="bottom:10%; ";
            } else if(position=='middle'){
                 css+="top:50%;margin-top:-18px;";
            }
            m.style.cssText = css;
            document.body.appendChild(m);
            if(duration!=0){
                setTimeout(function() {
                    var d = 0.2;
                    m.style.webkitTransition = '-webkit-transform ' + d + 's ease-in, opacity ' + d + 's ease-in';
                    m.style.opacity = '0';
                    setTimeout(function() {
                        try{ document.body.removeChild(m); }catch(e){}
                    }, d * 1000);
                }, duration);
            }

        },confirm:function(msg,callback,cancelcall,data,keep){
            if(!keep)this.clear();
            var html = '<div id="tooltipbox_alert"><div class="layer"></div><div class="tips"><div class="title">';
            html+=msg;
            html+='</div><div class="sub"><nav data-action="cancel">取消</nav><nav data-action="ok">确定</nav>';
            html+='</div></div></div>';
            if($('#tooltipbox_tip').length>0){
                $('#tooltipbox_tip').remove();
            }
            var div =$(html);
           $(document.body).append(div);
            $('.layer',div).fadeIn(100);$('.tips',div).fadeIn(100);
            div.find('nav').unbind('click').click(function(){
                
                var action=$(this).data('action');
                if(action=='ok'){
                    if(callback){
                        callback(data);
                    }
                }else{
					if(cancelcall){
						cancelcall(data);
					}
				}
                div.remove();
            });
            
        },alert:function(msg,callback,data,keep){
            if(!keep)this.clear();
            var html = '<div id="tooltipbox_alert"><div class="layer"></div><div class="tips"><div class="title">';
            html+=msg;
            html+='</div><div class="sub"><nav data-action="ok">确定</nav>';
            html+='</div></div></div>';

            if($('#tooltipbox_tip').length>0){
                $('#tooltipbox_tip').remove();
            }
            var div =$(html);
            $(document.body).append(div);
            $('.layer',div).fadeIn(100);$('.tips',div).fadeIn(100);
           
            div.find('nav').unbind('click').click(function(){
               
                var action=$(this).data('action');
                if(action=='ok'){
                    if(callback){
                        callback(data);
                    }
                     div.remove();
                }
            });
        },loading:function(msg,keep){
            if(!keep)this.clear();
            var html = '<div id="tooltipbox_alert"><div class="layer"></div><div class="tips"><div class="title">';
            html+=msg;
            html+='</div></div></div>';

            if($('#tooltipbox_tip').length>0){
                $('#tooltipbox_tip').remove();
            }
            var div =$(html);
            $(document.body).append(div);
            $('.layer',div).fadeIn(100);$('.tips',div).fadeIn(100);
        }
    }