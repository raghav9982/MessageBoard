<?php
   session_start();
?>

<html>
<head><title>User registration</title></head>
<body bgcolor="#E6E6FA">
<form method="POST" action="">
<fieldset>
<label>Enter fullname: <input type="text" name="Fullname"/></label><br/>
<label>Enter Email-Id: <input type="text" name="email"/></label><br/>
<label>Enter username: <input type="text" name="username"/></label><br/>
<label>Enter Password: <input type="password" name="password"/></label><br/>
<input type="submit" name="register" value="register"/>
</fieldset>
</form>

<?php
    if(isset($_POST['register'])) 
    {
       $fname=$_POST['Fullname'];
       $email=$_POST['email'];
       $uname=$_POST['username'];
       $pass=md5($_POST['password']);
       try 
       {
               $dbname =  dirname($_SERVER["SCRIPT_FILENAME"]) ."/mydb.sqlite";
               $dbh = new PDO("sqlite:$dbname");
               $dbh->beginTransaction();
               $dbh->exec("insert into users values('$uname','$pass','$fname','$email')")
               or die(print_r($dbh->errorInfo(), true));
               $dbh->commit();
               header("Location: board.php");
       }
       catch (PDOException $e) 
       {
           print "Error!: " . $e->POSTMessage() . "<br/>";
           die();
       }
     }
?>

</body>
</html>
