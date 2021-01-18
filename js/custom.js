function send_message(){
  var name=jQuery("#name").val();
  var email=jQuery("#email").val();
  var mobile=jQuery("#mobile").val();
  var message=jQuery("#message").val();

  if(name==""){
    alert('Please Enter Name');
  }
  else if(email==""){
    alert('Please Enter Valid Email');
  }
  else if(mobile==""){
    alert('Please Enter Mobile Number');
  }
  else if(message==""){
    alert('Please Enter Your Message');
  }
  else{
    jQuery.ajax({
      url:'send_message.php',
      type:'post',
      data:'name='+name+'&email='+email+'&mobile='+mobile+'&message='+message,
      success:function(result){
        alert(result);
      }
    });
  }

}
function user_register() {
  jQuery('.field_error').html('');
  var name=jQuery("#name").val();
  var email=jQuery("#email").val();
  var mobile=jQuery("#mobile").val();
  var password=jQuery("#password").val();
  var is_error='';
  if(name==""){
    jQuery('#name_error').html('Please Enter Name');
    is_error='yes';
  }
  if(email==""){
    jQuery('#email_error').html('Please Enter Email');
    is_error='yes';
  }
  if(mobile==""){
    jQuery('#mobile_error').html('Please Enter Mobile');
    is_error='yes';
  }
  if(password==""){
    jQuery('#password_error').html('Please Enter Password');
    is_error='yes';
  }
  if(is_error==''){
    jQuery.ajax({
      url:'register_submit.php',
      type:'post',
      data:'name='+name+'&email='+email+'&mobile='+mobile+'&password='+password,
      success:function(result){
        if(result=='email_present') {
          jQuery('#email_error').html('Email Already Exist'); 
        }
        if (result=='insert'){
          jQuery('.register_msg p').html('Thank You For Registration'); 
        }
      }
    });
  }
}
function user_login(){
  jQuery('.field_error').html('');
  var email=jQuery("#login_email").val();
  var password=jQuery("#login_password").val();
  var is_error='';
  if(email==""){
    jQuery('#login_email_error').html('Please Enter Email');
    is_error='yes';
  }
  if(password==""){
    jQuery('#login_password_error').html('Please Enter Password');
    is_error='yes';
  }
  if(is_error==''){
    jQuery.ajax({
      url:'login_submit.php',
      type:'post',
      data:'&email='+email+'&password='+password,
      success:function(result){
        if(result=='wrong') {
          jQuery('.login_msg p').html('Please Enter Valid Credintial'); 
        }
        if (result=='valid'){
          window.location.href=window.location.href;
        }
      }
    });
  }
}


function manage_cart(pid,type){
  if(type=='update'){
    var qty=jQuery("#"+pid+"qty").val();
  }else{
    var qty=jQuery("#qty").val();
  }
    jQuery.ajax({
      url:'manage_cart.php',
      type:'post',
      data:'&pid='+pid+'&qty='+qty+'&type='+type,
      success:function(result){
        if(type=='update' || type=='remove'){
          window.location.href=window.location.href;
        }
        jQuery('.htc__qua').html(result);
      }
    });
  }


function sort_product_drop(cat_id,site_path){
  var sort_product_id=jQuery('#sort_product_id').val();
  window.location.href=site_path+"categories.php?id="+cat_id+"&sort="+sort_product_id;
}