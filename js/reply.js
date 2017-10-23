function gel(id) {
    return document.getElementById(id);
}
var getdata;
var getdataurl="/restful/returntid";
var data1="";

$.post(getdataurl,data1,function (result) {
    result = eval(result);
    var tid1=result[0].tid;
    var tid2=result[1].tid;
    var tid3=result[2].tid;
    var tid4=result[3].tid;
    callback(tid1);

});

    var url = "/sqlpostition.php";
    var data = JSON.stringify({"tid": "22"});
    $.post(url, data, function (result) {
        result = eval(result);
        var sc = "【主题正文】" + result[0].message;
        $("#tiecontext").text(sc);

    });
    $.post(url, data, function (result) {
        result = eval(result);

        for (var i = 1; i < result.length; i++) {
            if (result[i].bbcodeoff == 0) {
                var newresult = result[i].message;
                var index = newresult.lastIndexOf("[\/quote\]");
                newresult = newresult.substring(index + 10, newresult.length);
                var liNew = document.createElement("li");
                var votebutton = document.createElement("button").value = "引用";
                liNew.innerHTML = (i) + "楼：" + newresult + "\t\t" + "<button class=\"layui-btn layui-btn-mini layui-btn-warm\" id='use" + i + "'>" + votebutton + "</button>";
                gel("tie1").appendChild(liNew);
            } else {
                var liNew = document.createElement("li");
                var votebutton = document.createElement("button").value = "引用";
                liNew.innerHTML = (i) + "楼：" + result[i].message + "\t\t" + "<button class=\"layui-btn layui-btn-mini layui-btn-warm\" id='use" + i + "'>" + votebutton + "</button>";
                gel("tie1").appendChild(liNew);
            }
        }
        for (var i = 1; i < result.length; i++) {
            $('#use' + i).on('click', function () {
                // alert(this.id);
                var str = this.id;
                var index = str.lastIndexOf("use");
                str = str.substring(index + 3, str.length);
                var idnum = parseInt(str) + 1;
                //
                // alert(idnum);
                layer.open({
                    type: 1,
                    title: '点评',
                    skin: 'layui-layer-lan', //加上边框
                    area: ['522px', '235px'], //宽高
                    content: '<textarea name="" id="textarea2" required lay-verify="required" placeholder="吐槽点什么吧..." class="layui-textarea"></textarea></br>' +
                    '<div id="v_container" style="width: 70px;height: 40px;float: left;margin-right: 5px;margin-left: 22px"></div>\n' +
                    '\t\t<input type="text" id="code_input1" class="layui-input"   style="width: 140px;margin-right: 0px" value="" placeholder="请输入验证码"/>\n' +
                    '\t\t<button id="comment" style="float:right" class="layui-btn layui-btn-normal layui-btn-warm" name="点评">点评</button>' +
                    '\t<script>\n' +
                    '\t\tvar verifyCode = new GVerify("v_container");\n' +
                    '\t</script>'
                });
                $('#comment').on('click', function () {
                    var res = verifyCode.validate(document.getElementById("code_input1").value);
                    if (res) {
                        var url = "/usereply.php";
                        var name = "dire";
                        var text = $("#textarea2").val();
                        alert(text);
                        var authorid = 2;
                        var data = JSON.stringify({
                            "tid": "22",
                            "author": name,
                            "authorid": authorid,
                            "position": idnum,
                            "message": text
                        });
                        $.post(url, data);
                        document.location.reload();
                    }
                    else {
                        layer.msg('验证码错误', {icon: 5});
                    }
                });
            });

        }
    });



$('#reply1').on('click', function(){

        var text = $("#textarea1").val();
        var url = "/reply.php";
        var name = "dire";
        var authorid = 2;
        var authcode=$("#authcode").val();

        var data = JSON.stringify({
            "authcode":authcode,
            "tid": "22",
            "author": name,
            "authorid": authorid,
            "message": text
        });
        $.post(url, data);
        document.location.reload();

});
$.idcode.setCode();
var url8="/sqltitle.php";
var data8 = JSON.stringify({"tid": "22"});
$.post(url8,data8,function(result){
    result = result.replace("\"","").replace("\"","");
    var title="【主题】"+result;
    $("#tle1").text(title);
});