<?php include "logincss.php" ?>

<?php
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // $slat = "2sdsfaerdvhsfsdasheyyw";
    // $password = crypt($password, $slat ); 

$stmt = $conn->prepare("SELECT * FROM users ");
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$userse = $stmt->fetchAll(); 
foreach ($userse as $user) {
    
      if($user['user_status'] !='active'){
            $error = "your account is not activated. please contact to web administrator";
       }else{
        if($user['user_email']!=$username ){
            $user_error ="Incorrent Email address";
        }elseif($user['user_password']!=$password){
            $pass_error ="Incorrent password address";
        }
        if($username == ""){
            $user_error ="Empty valid username";
        }elseif( $password == ""){ 
            $pass_error ="Empty valid password";
        }
    
        if($user['user_email']== $username && $user['user_password']== $password ){
            
            $_SESSION['username'] =$username;
            $_SESSION['uid'] = $user['user_id'];
            $_SESSION['fname'] = $user['user_first_name'];
            $_SESSION['lname'] = $user['user_last_name'];
            $_SESSION['age'] = $user['user_age'];
            $_SESSION['pass'] = $user['user_password'];
            $_SESSION['role'] = $user['user_role'];
            $_SESSION['date'] = $user['user_date'];
            $_SESSION['img'] = $user['user_img'];
            $_SESSION['address'] = $user['user_address'];
            $_SESSION['city'] = $user['city'];
            $_SESSION['bio'] = $user['user_bio'];
      
            header('location: ../index.php');
            $options = array(
                'cluster' => 'ap3',
                'useTLS' => true
              );
              $pusher = new Pusher\Pusher(
                'dc2b32aeb35c85a6b41f',
                '753a6d5719210238ca33',
                '935556',
                $options
              );

              
    $data['message'] =$user['user_first_name'].''.$user['user_last_name'];
    $pusher->trigger('my-channel', 'my-event', $data);
         }
        }
        }
        
}
?>


<div class='container-fluid '>

<div class='col-md-12'>
<div class="center_div">
<form method="post">
<?php if(isset($error)){
       echo '<span style="color:red;">'.$error.'</span></br>';
} ?> 
<h3 class='log'>LOGIN FORM</h3>
<label>Username:</label>
<?php if(isset($user_error)){
    echo '<span style="color:red;">'.$user_error.'</span>';
} ?>
<input class="form-control" type='text' name='username' placeholder="email"> <br/>
<label>Password:</label>
<?php if(isset($pass_error)){
       echo '<span style="color:red;">'.$pass_error.'</span>';
} ?>
<input class="form-control" type='password' name='password' placeholder="Password"> 
 <br/>
<div class="bot">
<button class='btn btn-danger' name="submit">LOGIN</button><br/>
</div>
<div class='creat'>
<a  href="../user.php?source=forgotpassword"><h5>Forgot password</h5></a>
<a  href="register.php?lang=en"><h5>Create New Account</h5></a>

</div>
</form>
<h3>

<?php 
 if(isset($mg, $msg2)){ echo  $mg; echo $msg2;} ?> </h3>
</div>
</div>

</div>
<?php include "footer.php" ?>
