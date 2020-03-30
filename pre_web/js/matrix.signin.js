
$(document).ready(function(){

	var login = $('#loginform');
	var recover = $('#recoverform');
	var speed = 400;
	
	$('#log-in').click(function(){
		if(signinform.username.value =="" || signinform.Emailaddr.value=="" || signinform.password1.value=="" || signinform.password2.value=="")
		{
			$("#loginform").slideUp();
			$("#recoverform2").fadeIn();
			return false;
		}
		if(signinform.password1.value!=signinform.password2.value)
		{
			$("#loginform").slideUp();
			$("#recoverform1").fadeIn();
			return false;
		}
		if(signinform.password1.value.length<6)
		{
			alert("密码长度应大于等于6");
			signinform.password1.focus();
			return false;
		}
		var regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
		if(!regex.test(signinform.Emailaddr.value))
		{
			alert("邮箱格式不正确");
			return false;
		}
//		signinform.action="D:\\Program Files\\XAMPP\\XMAPP\\htdocs\\php\\signin_save.php";
		console.log("初步验证成功！");
		return true;
	})
	
	$('#1-to-login').click(function(){
		
		$("#recoverform1").hide();
		$("#loginform").fadeIn();
	});
	
	$('#2-to-login').click(function(){
		
		$("#recoverform2").hide();
		$("#loginform").fadeIn();
	});
    
    if($.browser.msie == true && $.browser.version.slice(0,3) < 10) {
        $('input[placeholder]').each(function(){ 
       
        var input = $(this);       
       
        $(input).val(input.attr('placeholder'));
               
        $(input).focus(function(){
             if (input.val() == input.attr('placeholder')) {
                 input.val('');
             }
        });
       
        $(input).blur(function(){
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.val(input.attr('placeholder'));
            }
        });
    });

        
        
    }
});