<?php  
if(isset($_REQUEST['authcode'])){  
    session_start();  
    if(strtolower($_REQUEST['authcode']) == $_SESSION['authcode']){  
        echo '<font color="#0000cc">������ȷ</font>';

    }else{  
        echo '<font color="#cc0000"><b>�������</b></font>';

    }  
    exit();
}  
  
?>  
  
<!DOCTYPE html>  
<html>  
<head>  
    <title></title>  
</head>  
<body>  
    <form method="post" action="./form.php">  
        <p>  
            ��֤��ͼƬ:<img id="captch_code" border="1" onclick="document.getElementById('captch_code').src='./captcha.php?r='+Math.random()" src="./captcha.php?r=<?php echo rand();?>" witdh="100px" />  
            <a href="javascript:void(0)" onclick="document.getElementById('captch_code').src='./captcha.php?r='+Math.random()">��һ��</a>   
        </p>  
        <p>ͼƬ����:<input type="text" name="authcode" value="" /> </p>  
        <p><input type="submit" value="�ύ" style="padding:6px 20px;"></p>  
    </form>  
</body>  
</html>  