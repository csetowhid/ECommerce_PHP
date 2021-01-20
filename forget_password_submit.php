<?php 
require('connection.inc.php');
require('functions.inc.php');

$email=get_safe_value($con,$_POST['email']);
$res=mysqli_query($con,"select * from users where email='$email'");
$check_user=mysqli_num_rows($res);

if($check_user>0) {
	$row=mysqli_fetch_assoc($res);
	$pwd=$row['password'];

	$html="Your Password is <strong>$pwd</strong>";
	include('smtp/PHPMailerAutoload.php');
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Post=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="towhidhasang1@gmail.com";
	$mail->Password="flo8678667769t5844";
	$mail->SetForm=("towhidhasang1@gmail.com");
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject="Your Password";
	$mail->Body=$html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if ($mail->send()) {
		echo "Please Check Your Email Id For Password";
	}else{
		"Error Occured";
	}
}else{
	echo "Email Id Not Register Yet";
	die();
}

?>