var bossNames = ["科扎卡", "库图姆", "怒贝尔", "红鼻子", "巨大的泥土怪", "树精", "卑鄙的贝克"];
var timegap = [[8, 12], [8, 12], [11, 17], [7.83, 7.83], [7.83, 7.83], [7.83, 7.83], [7.83, 7.83]];
//var url1 = "http://localhost/GamebossAPI/restful/bossselect";
var url1 = "/restful/bossselect";

var postHandler = function(i){
    return function(result){
        var temp = i;
        if(result[0] == "[") result = eval(result);
        var src =result[0]["time"];
        var control = $("#bossName" + (temp + 1));
        var control1 = $("#b" + (temp + 1));
        var control2 = $("#prediction" + (temp + 1));
        control.text(result[0]["bossName"]);
        control1.text(src);
        var timestamp2 = Date.parse(new Date(src));
        var timestamp3 = timestamp2/1000+timegap[temp][0] * 60 * 60;
        var timestamp4 = timestamp2/1000+timegap[temp][1] * 60 * 60;
        var newDate1 = new Date();
        newDate1.setTime(timestamp3 * 1000);
        var newDate2 = new Date();
        newDate2.setTime(timestamp4 * 1000);
        var time1=newDate1.toLocaleTimeString();
        var time2=newDate2.toLocaleTimeString();
        var time3=timegap[temp][0]==timegap[temp][1]?time1:time1+"~"+time2;
        control2.text(time3);
    }
};

for(var i = 0; i < bossNames.length; i++){
    var data1 = JSON.stringify({"bossName":bossNames[i]});
    $.post(url1,data1,postHandler(i));
}
