<!DOCTYPE html>

<?php
   session_start();
?>

<html>
<head><title>Message Board</title>
</head>
<body bgcolor="#E6E6FA">
<fieldset style="background-color:#999999;">
<form action="" method="POST">
<label>Enter username:<input type="text" name="username"/></label><br/><br/>
<label>Enter Password:<input type="password" name="password"/></label><br/>
</fieldset>
<fieldset style="background-color:#999999;">
<input class="button" type="submit" name="Login" value="Login"/>
<input class="button" type="submit" name="register" value="register"/>
<br/>
<br/>
</form>
</fieldset>

<?php
  error_reporting(E_ALL);
  ini_set('display_errors','Off');
  if(isset($_POST['register']))
  {
     header("Location: register.php");
  }
  if(isset($_POST['Login'])) 
  {
     if(!isset($_POST['username'])|| strlen($_POST['password']) == 0) 
     {
         echo " enter username and password to login";
     }
     else 
     {
        $user=$_POST['username'];
        $pass=md5($_POST['password']);
        try 
        {
  	        $dbname =  dirname($_SERVER["SCRIPT_FILENAME"]) ."/mydb.sqlite";
  		$dbh = new PDO("sqlite:$dbname");
  		$dbh->beginTransaction();
  		$stmt=$dbh->prepare("select username, password from users where username='$user' and password='$pass'");
                $stmt->execute();
  		$row = $stmt->fetch();
  		if($row>0)
		{
    		    $_SESSION['username']= $row['username'];
    		    $_SESSION['password'] = $row['password'];
    		    header("Location: msg.php");
		}
  		else 
                {
                     echo "please enter valid username and password";
                }
         }
         catch (PDOException $e) 
         {
              print "Error!: " . $e->POSTMessage() . "<br/>";
              die();
         }
     }
}
?>

</body>
</html>
