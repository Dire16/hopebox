window.onload=function(){
    new Marquee(
    "scrollBox2",  //容器ID<br>
    0,  //向上滚动(0向上 1向下 2向左 3向右)<br>
    2,  //滚动的步长<br>
    740,  //容器可视宽度<br>
    40,  //容器可视高度<br>
    50,  //定时器 数值越小，滚动的速度越快(1000=1秒,建议不小于20)<br>
    2000,  //间歇停顿时间(0为不停顿,1000=1秒)<br>
    1000,  //开始时的等待时间(0为不等待,1000=1秒)<br>
    47  //间歇滚动间距(可选)<br>
    );
    };
    function Marquee(){
    this.ID=document.getElementById(arguments[0]);
    this.Direction=arguments[1];
    this.Step=arguments[2];
    this.Width=arguments[3];
    this.Height=arguments[4];
    this.Timer=arguments[5];
    this.WaitTime=arguments[6];
    this.StopTime=arguments[7];
    if(arguments[8]){this.ScrollStep=arguments[8];}else{this.ScrollStep=this.Direction>1?this.Width:this.Height;}
    this.CTL=this.StartID=this.Stop=this.MouseOver=0;
    this.ID.style.overflowX=this.ID.style.overflowY="hidden";
    this.ID.noWrap=true;
    this.ID.style.width=this.Width;
    this.ID.style.height=this.Height;
    this.ClientScroll=this.Direction>1?this.ID.scrollWidth:this.ID.scrollHeight;
    this.ID.innerHTML+=this.ID.innerHTML;
    this.Start(this,this.Timer,this.WaitTime,this.StopTime);
    }
    Marquee.prototype.Start=function(msobj,timer,waittime,stoptime){
    msobj.StartID=function(){msobj.Scroll();}
    msobj.Continue=function(){
    if(msobj.MouseOver==1){setTimeout(msobj.Continue,waittime);}
    else{clearInterval(msobj.TimerID); msobj.CTL=msobj.Stop=0; msobj.TimerID=setInterval(msobj.StartID,timer);}
    }
    msobj.Pause=function(){msobj.Stop=1; clearInterval(msobj.TimerID); setTimeout(msobj.Continue,waittime);}
    msobj.Begin=function(){
    msobj.TimerID=setInterval(msobj.StartID,timer);
    msobj.ID.onmouseover=function(){msobj.MouseOver=1; clearInterval(msobj.TimerID);}
    msobj.ID.onmouseout=function(){msobj.MouseOver=0; if(msobj.Stop==0){clearInterval(msobj.TimerID); msobj.TimerID=setInterval(msobj.StartID,timer);}}
    }
    setTimeout(msobj.Begin,stoptime);
    }
    Marquee.prototype.Scroll=function(){
    switch(this.Direction){
    case 0:
    this.CTL+=this.Step;
    if(this.CTL>=this.ScrollStep&&this.WaitTime>0){this.ID.scrollTop+=this.ScrollStep+this.Step-this.CTL; this.Pause(); return;}
    else{if(this.ID.scrollTop>=this.ClientScroll) this.ID.scrollTop-=this.ClientScroll; this.ID.scrollTop+=this.Step;}
    break;
    case 1:
    this.CTL+=this.Step;
    if(this.CTL>=this.ScrollStep&&this.WaitTime>0){this.ID.scrollTop-=this.ScrollStep+this.Step-this.CTL; this.Pause(); return;}
    else{if(this.ID.scrollTop<=0) this.ID.scrollTop+=this.ClientScroll; this.ID.scrollTop-=this.Step;}
    break;
    case 2:
    this.CTL+=this.Step;
    if(this.CTL>=this.ScrollStep&&this.WaitTime>0){this.ID.scrollLeft+=this.ScrollStep+this.Step-this.CTL; this.Pause(); return;}
    else{if(this.ID.scrollLeft>=this.ClientScroll) this.ID.scrollLeft-=this.ClientScroll; this.ID.scrollLeft+=this.Step;}
    break;
    case 3:
    this.CTL+=this.Step;
    if(this.CTL>=this.ScrollStep&&this.WaitTime>0){this.ID.scrollLeft-=this.ScrollStep+this.Step-this.CTL; this.Pause(); return;}
    else{if(this.ID.scrollLeft<=0) this.ID.scrollLeft+=this.ClientScroll; this.ID.scrollLeft-=this.Step;}
    break;
    }
    }