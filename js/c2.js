$(document).ready(function(){

   $("#AH_Num,#AH_price").keyup(function(){
        var price = new String(Math.round($("#AH_price").val()*$("#AH_Num").val()*0.845));
		var old_price = new String(Math.round($("#AH_price").val()*$("#AH_Num").val()*0.65));


		var o_s = old_price.length;		
		var p_s = price.length; 
		
		if(o_s<5){
			$("#AH_result").html('会员价实际可获得金额：<span class="res" >'+price+'</span></br>非会员实际可获得金额：<span class="res" >'+old_price+'</span>');	
		}else if(o_s>8){
			var o_sbe = old_price.substring(0,o_s-8)+'亿';
			var p_sbe = price.substring(0,p_s-8)+'亿';
			var o_sbw = old_price.substring(o_s-8,o_s-4)+'万';
			var p_sbw = price.substring(p_s-8,o_s-4)+'万';
			var o_sbq = old_price.substring(o_s-4,o_s);
			var p_sbq = price.substring(p_s-4,o_s);			
			
			$("#AH_result").html('会员价实际可获得金额：<span class="res">'+p_sbe+p_sbw+p_sbq+'</span></br>非会员实际可获得金额：<span class="res" >'+o_sbe+o_sbw+o_sbq+'</span>');			
		}else{
			var o_sbw = old_price.substring(0,o_s-4)+'万';
			var p_sbw = price.substring(0,p_s-4)+'万';
			var o_sbq = old_price.substring(o_s-4,8);
			var p_sbq = price.substring(p_s-4,8);
			
			$("#AH_result").html('会员价实际可获得金额：<span class="res">'+p_sbw+p_sbq+'</span></br>非会员实际可获得金额：<span class="res" >'+o_sbw+o_sbq+'</span>');
		}
    });
 
            //方法二：
            (function ($) {
                $.getUrlParam = function (Game) {
                    var reg = new RegExp("(^|&)" + Game + "=([^&]*)(&|$)");
                    var r = window.location.search.substr(1).match(reg);
                    if (r != null) return unescape(r[2]); return null;
                }
            })(jQuery);

            //方法二：
            var Game = $.getUrlParam('Game');
			if(Game!=null){
			$("body").css({
				"background":"url(../loc17ui/images/"+Game+".png)",
				"background-size":"100%"
			});
			}

	
	$('.shop').click(function () {
		$('.shop').addClass('active');
		$('.shop > .icon').addClass('active');
		$('.food').removeClass('active');
		$('.trade').removeClass('active');
		$('.ah').removeClass('active');	
	});
	$('.food').click(function () {
		$('.food').addClass('active');
		$('.food > .icon').addClass('active');
		$('.shop').removeClass('active');
		$('.trade').removeClass('active');
		$('.ah').removeClass('active');
	});
	$('.trade').click(function () {
		$('.trade').addClass('active');
		$('.trade > .icon').addClass('active');
		$('.food').removeClass('active');
		$('.shop').removeClass('active');
		$('.ah').removeClass('active');
	});
	$('.ah').click(function () {
		$('.ah').addClass('active');
		$('.ah > .icon').addClass('active');
		$('.food').removeClass('active');
		$('.trade').removeClass('active');
		$('.shop').removeClass('active');
	});
	$('.shop').click(function () {
		$('#first').addClass('active');
		$('#second').removeClass('active');
		$('#third').removeClass('active');
		$('#fourth').removeClass('active');
	});
	$('.food').click(function () {
		$('#first').removeClass('active');
		$('#second').addClass('active');
		$('#third').removeClass('active');
		$('#fourth').removeClass('active');
	});
	$('.trade').click(function () {
		$('#first').removeClass('active');
		$('#second').removeClass('active');
		$('#third').addClass('active');
		$('#fourth').removeClass('active');
	});
	$('.ah').click(function () {
		$('#first').removeClass('active');
		$('#second').removeClass('active');
		$('#third').removeClass('active');
		$('#fourth').addClass('active');
	});
	
	$.getJSON("js/cook.json", function(data){
		var menu ="<option value ='选择料理' >选择料理</option>";
		var cooks='请选择';
		var cookresult;
		var result;
		/*料理时间*/
		var llt_time = 0;
		var llf_time = 0;
		var ljs_time = 0;
		var buff_time = 0;
		var sz_time = 0;
		var cook_time = 0;
		var llt_Durability;
		for(var p in data){
			menu += "<option value ="+data[p].name+">"+data[p].name+"</option>";			
		}
			
		$("#cook_select").html(menu); 
		$('#cook_llt').change(function(){
			llt_time = parseInt($(this).children('option:selected').val());
			switch($(this).children('option:selected').text()){
				case '料理台':llt_Durability = 0;
					break;
				case 'NPC料理道具':llt_Durability = 100;
					break;
				case '中级料理道具':llt_Durability = 500;
					break;	
				case '上级料理道具':llt_Durability = 900;
					break;
				case '巴雷诺斯传统料理道具':llt_Durability = 500;
					break;
				case '瑟琳迪亚传统料理道具':llt_Durability = 1250;
					break;
				case '卡佩恩传统料理道具':llt_Durability = 2000;
					break;	
			}
				cook_time = 10+llt_time;
			$("#cook_time").html('单次料理时间：'+cook_time.toFixed(1)+'秒');	
		});
		$('#cook_llf').change(function(){
			llf_time = parseInt($(this).children('option:selected').val());
			cook_time = 10+llt_time+llf_time;
			$("#cook_time").html('单次料理时间：'+cook_time.toFixed(1)+'秒');	
		});
		$('#cook_ljs').change(function(){
			ljs_time = parseFloat($(this).children('option:selected').val());
			cook_time = 10+llt_time+llf_time+ljs_time;
			$("#cook_time").html('单次料理时间：'+cook_time.toFixed(1)+'秒');	
		});
		$('#cook_buff').change(function(){
			buff_time = parseFloat($(this).children('option:selected').val());
			cook_time = 10+llt_time+llf_time+ljs_time+buff_time;
			$("#cook_time").html('单次料理时间：'+cook_time.toFixed(1)+'秒');	
		});
		$('#cook_sz').change(function(){
			sz_time = parseInt($(this).children('option:selected').val());
			cook_time = 10+llt_time+llf_time+ljs_time+buff_time+sz_time;
			$("#cook_time").html('单次料理时间：'+cook_time.toFixed(1)+'秒');	
		}); 
		
		$('#cook_select').change(function(){
			var cookfood = new Array();
			var cklength;
			cooks=$(this).children('option:selected').val();
			$("#cc_11").html('');
			$("#cc_22").html('');
			$("#cc_33").html('');
			$("#cc_44").html('');
			$("#cc_55").html('');
			for(var c in data){
				if(cooks==data[c].name){
					cookfood['menu']='';
					cookfood['fnum']='';
					cookfood['f0']='0';
					cookfood['f1']='0';
					cookfood['f2']='0';
					cookfood['f3']='0';
					cookfood['f4']='0';
					cookfood['pro']='';
					for(var i in data[c].list){
						cookfood['fd'+i]=data[c].list[i].substr(0,data[c].list[i].length-1);
						cookfood['f'+i]=data[c].list[i].substr(data[c].list[i].length-1,1);
						cookfood['menu']+='<li>'+data[c].list[i]+'</li>';
					}
					//cookfood['res']=data[c].res;
					cklength=data[c].list.length;
					cookfood['pro']=data[c].pro;
					var res2="";
					if(data[c].res[1]){
						res2=data[c].res[1];
					}
					$("#res").html(data[c].res[0]+'</br>'+res2);
					var fornum = c;
				}

			
			}
				for(var i=0;i<=5;i++){
					$("#f"+i+"_num").attr("style","display:none");
				}
				
				if(cooks=='选择料理'){
					cookfood['menu']='';
				}else{
					for(var i=1;i<=cklength;i++){
					$("#f"+i+"_num").removeAttr("style");
					}
				}

				
				$("#pro").html(cookfood['pro']);
				
			
				/* $('body').on("focus","#f1_num",function(){
				this.value = '';  			  
				});   */
				$("#cc_1").html("<li>"+cooks+'<span style="color: rgb(195, 199, 209);">配方</span></li>'+cookfood['menu']);
				var cookzs=function(num,result){
						if(isNaN(result))return;
						var cf3="";
						var cf4="";
						if(cookfood['f3']==0){
							cf3="";
						}else{
							cf3=result*cookfood['f3']+'个';
						}
						if(cookfood['f4']==0){
							cf4="";
						}else{
							cf4=result*cookfood['f4']+'个';
						}
						var result2="";
						if(data[fornum].res[1]){
							result2 = data[fornum].res[1]+'*'+Math.ceil(result*2.5*0.1)
						}
						
						if(cook_time<1) cook_time=1;
						$("#res").html(data[fornum].res[0]+'*'+Math.ceil(result*2.5)+'</br>'+result2);
						var llt = Math.ceil(result/parseInt(llt_Durability));
						if(llt_Durability==0)llt=0;
						if(isNaN(llt))llt=0;
						$("#llt").html(llt+'个');
						$("#cc_num").html(result+'次');
						$("#cc_11").html(result*cookfood['f0']+'个');
						$("#cc_22").html(result*cookfood['f1']+'个');
						$("#cc_33").html(result*cookfood['f2']+'个');
						$("#cc_44").html(cf3);
						$("#cc_55").html(cf4);
						
						
						var theTime = cook_time*result;// 秒 
						var theTime1 = 0;// 分 
						var theTime2 = 0;// 小时 
						if(theTime > 60) { 
						theTime1 = parseInt(theTime/60); 
						theTime = parseInt(theTime%60); 
						if(theTime1 > 60) { 
						theTime2 = parseInt(theTime1/60); 
						theTime1 = parseInt(theTime1%60); 
						} 
						} 
						var c2 = ""+parseInt(theTime)+"秒"; 
						if(theTime1 > 0) { 
						c2 = ""+parseInt(theTime1)+"分"+c2;  
						} 
						if(theTime2 > 0) { 
						c2 = ""+parseInt(theTime2)+"小时"+c2; 
						} 
						
						$("#cc_time").html(c2);
			}
			$('body').on("keyup","#f1_num",function(){
					var num =Math.floor($("#f1_num").val());
					result = Math.floor(num/cookfood['f0']);
					cookzs(num,result);
				});	
			$('body').on("keyup","#f2_num",function(){
					var num =Math.floor($("#f2_num").val());
					result = Math.floor(num/cookfood['f1']);
					cookzs(num,result);
				});
			$('body').on("keyup","#f3_num",function(){
					var num =Math.floor($("#f3_num").val());
					result = Math.floor(num/cookfood['f2']);
					cookzs(num,result);
				});
			$('body').on("keyup","#f4_num",function(){
					var num =Math.floor($("#f4_num").val());
					
					result = Math.floor(num/cookfood['f3']);
					cookzs(num,result);
				});
				$('body').on("keyup","#f5_num",function(){
					var num =Math.floor($("#f5_num").val());
					
					result = Math.floor(num/cookfood['f4']);
					cookzs(num,result);
				});		
		});
			
	});
	
	$.getJSON("js/gold.json", function(data){
		var menu ="<option value ='选择炼金' selected='selected'>选择炼金配方</option>";
		var cooks='请选择';
		var cookresult;
		var result;
		/*料理时间*/
		var llt_time = 0;
		var llf_time = 0;
		var ljs_time = 0;
		var buff_time = 0;
		var sz_time = 0;
		var cook_time = 0;
		var llt_Durability;
		for(var p in data){
			menu += "<option value ="+data[p].name+">"+data[p].name+"</option>";			
		}
			
		$("#gold_select").html(menu); 
		$('#gold_llt').change(function(){
			llt_time = parseInt($(this).children('option:selected').val());
			switch($(this).children('option:selected').text()){
				case 'NPC炼金术道具':
llt_Durability = 100;
					break;
				case '中级炼金术道具':
llt_Durability = 500;
					break;	
				case '上级炼金术道具':
llt_Durability = 900;
					break;
				case '巴雷诺斯传统炼金术道具':
llt_Durability = 500;
					break;
				case '瑟琳迪亚传统炼金术道具':
llt_Durability = 1250;
					break;
				case '卡佩恩传统炼金术道具':
llt_Durability = 2000;
					break;	
			}
			cook_time = 10+llt_time;
			$("#gold_time").html('单次炼金时间：'+cook_time.toFixed(1)+'秒');	
		});
		$('#gold_llf').change(function(){
			llf_time = parseInt($(this).children('option:selected').val());
			cook_time = 10+llt_time+llf_time;
			$("#gold_time").html('单次炼金时间：'+cook_time.toFixed(1)+'秒');	
		});
		$('#gold_ljs').change(function(){
			ljs_time = parseFloat($(this).children('option:selected').val());
			cook_time = 10+llt_time+llf_time+ljs_time;
			$("#gold_time").html('单次炼金时间：'+cook_time.toFixed(1)+'秒');	
		});
		$('#gold_buff').change(function(){
			buff_time = parseFloat($(this).children('option:selected').val());
			cook_time = 10+llt_time+llf_time+ljs_time+buff_time;
			$("#gold_time").html('单次炼金时间：'+cook_time.toFixed(1)+'秒');	
		});
		
		$('#gold_select').change(function(){
			var cookfood = new Array();
			var cklength;
			var fornum;
			cooks=$(this).children('option:selected').val();
			$("#gold_22").html('');	
			for(var c in data){
				if(cooks==data[c].name){
					cookfood['menu']='';
					cookfood['fnum']='';
					cookfood['f0']='0';
					cookfood['f1']='0';
					cookfood['f2']='0';
					cookfood['f3']='0';
					cookfood['f4']='0';
					cookfood['pro']='';
					for(var i in data[c].list){
						cookfood['fd'+i]=data[c].list[i].substr(0,data[c].list[i].length-1);
						cookfood['f'+i]=data[c].list[i].substr(data[c].list[i].length-1,1);
						cookfood['menu']+='<li>'+data[c].list[i]+'</li>';
					}
					//cookfood['res']=data[c].res;
					cookfood['pro']=data[c].pro;
					var res2="";
					if(data[c].res[1]){
						res2=data[c].res[1];
					}
					$("#goldres").html(data[c].res[0]+'</br>'+res2);
					fornum = c;
					cklength=data[c].list.length;
				}
				
			}
				for(var i=0;i<=5;i++){
					$("#g"+i+"_num").attr("style","display:none");
				}
				
				if(cooks=='选择炼金'){
					cookfood['menu']='';
				}else{
					for(var i=1;i<=cklength;i++){
					$("#g"+i+"_num").removeAttr("style");
					}
				}
				$("#goldpro").html(cookfood['pro']);
				$("#gold_1").html("<li>"+cooks+'<span style="color: rgb(195, 199, 209);">配方</span></li>'+cookfood['menu']);
				
				var goldzs=function(num,result){
					if(isNaN(result))return;
					var cf2="";
					var cf3="";
					var cf4="";
					if(cookfood['f2']==0){
						cf2="";
					}else{
						cf2=result*cookfood['f2']+'个';
					}
					if(cookfood['f3']==0){
						cf3="";
					}else{
						cf3=result*cookfood['f3']+'个';
					}
					if(cookfood['f4']==0){
						cf4="";
					}else{
						cf4=result*cookfood['f4']+'个';
					}
					var result2="";
					if(data[fornum].res[1]){
						result2 = data[fornum].res[1]+'*'+Math.ceil(result*2.5*0.2)
					}
					
					if(cook_time<1) cook_time=1;
					$("#goldres").html(data[fornum].res[0]+'*'+Math.ceil(result*2.5)+'</br>'+result2);
					var llt = Math.ceil(result/parseInt(llt_Durability));
					if(llt_Durability==0)llt=0;
					if(isNaN(llt))llt=0;
					$("#goldllt").html(llt+'个');
					$("#gold_count").html(result+'次');
					$("#gg_11").html(result*cookfood['f0']+'个');
					$("#gg_22").html(result*cookfood['f1']+'个');
					$("#gg_33").html(cf2);
					$("#gg_44").html(cf3);
					$("#gg_55").html(cf4);
					var theTime = cook_time*result;// 秒 
					var theTime1 = 0;// 分 
					var theTime2 = 0;// 小时 
					if(theTime > 60) { 
					theTime1 = parseInt(theTime/60); 
					theTime = parseInt(theTime%60); 
					if(theTime1 > 60) { 
					theTime2 = parseInt(theTime1/60); 
					theTime1 = parseInt(theTime1%60); 
					} 
					} 
					var c2 = ""+parseInt(theTime)+"秒"; 
					if(theTime1 > 0) { 
					c2 = ""+parseInt(theTime1)+"分"+c2; 
					} 
					if(theTime2 > 0) { 
					c2 = ""+parseInt(theTime2)+"小时"+c2; 
					} 
					
					$("#golds_time").html(c2);
				}
				$('body').on("keyup","#g1_num",function(){
					var num =Math.floor($("#g1_num").val());
					result = Math.floor(num/cookfood['f0']);
					goldzs(num,result);
				});

				$('body').on("keyup","#g2_num",function(){
					var num =Math.floor($("#g2_num").val());
					
					result = Math.floor(num/cookfood['f1']);
					goldzs(num,result);
				});
				$('body').on("keyup","#g3_num",function(){
					var num =Math.floor($("#g3_num").val());
					
					result = Math.floor(num/cookfood['f2']);
					goldzs(num,result);
				});
				$('body').on("keyup","#g4_num",function(){
					var num =Math.floor($("#g4_num").val());
					
					result = Math.floor(num/cookfood['f3']);
					goldzs(num,result);
				});
				$('body').on("keyup","#g5_num",function(){
					var num =Math.floor($("#g5_num").val());
					
					result = Math.floor(num/cookfood['f4']);
					goldzs(num,result);
				});				
		});
			
	});
}); 

document.oncontextmenu = function(){
    event.returnValue = false;
}
document.onselectstart = function(){
    event.returnValue = false;
}
 document.addEventListener('DOMContentLoaded', function (event) {
            document.body.style.zoom = 'reset';
            document.addEventListener('keydown', function (event) {
				
				if (event.ctrlKey==1)event.preventDefault();
				
                if ((event.ctrlKey === true || event.metaKey === true)
                && (event.which === 61 || event.which === 107
                    || event.which === 173 || event.which === 109
                    || event.which === 187  || event.which === 189))
                    {
						
                       event.preventDefault();
                    }
            }, false);
            document.addEventListener('mousewheel DOMMouseScroll', function (event) {
                if (event.ctrlKey === true || event.metaKey) {
                    event.preventDefault();
                }
            }, false);
        }, false);
