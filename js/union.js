var url="/restful/select.php";
var data="";
$.post(url,data,function(result){
    var obj = eval( "(" + result + ")" );

    var item;
    for ( var i = 0; i < result.length; i++) {
        item = "<tr><td>" + obj[i].name + "</td><td><img style='width: 75px;height: 60px' src=\"http://www.cc8.cc/source/plugin/tshuz_clan/attach/" + obj[i].logo + "\"></td><td>" + obj[i].desc + "</td><td>" + obj[i].num + "</td><td>" + obj[i].username + "</td></tr>";
    $("#tb1").append(item);}
});