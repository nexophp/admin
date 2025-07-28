<?php 
$login_type = get_config('login_type');
?>
<?php if($login_type && in_array('email',$login_type)){?>
<a href="/admin/login/email">邮箱验证码登录</a> |

<?php }?>
<?php if($login_type && in_array('phone',$login_type)){?>
<a href="/admin/login/phone">手机号登录</a> |
<?php }?> 
<a href="/admin/login/forgot">忘记密码?</a><br>  