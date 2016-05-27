<?php
session_start();
?>

<html>
<head><title>Message Board</title></head>
<body bgcolor="#E6E6FA">
<fieldset style="background-color:#999999;">
<form method="POST" action="">
<textarea name="text" rows="20" cols="50">
</textarea>
<br/>
<input type="submit" name="post" value="post"/>
</form>
</fieldset>

<?php
   if(isset($_POST['id']))
   {
       $_SESSION['id']=$_POST['id'];
   }
   if(isset($_POST['post']))
   {
      $msg=$_SESSION['id'];
      unset($_SESSION['id']);
      $a=uniqid();
      $postby=$_SESSION['username'];
      $text=$_POST['text'];
      try 
      {
          $dbname= dirname($_SERVER["SCRIPT_FILENAME"]) ."/mydb.sqlite";
          $dbh = new PDO("sqlite:$dbname");
          if($msg)
          {
               $dbh->exec("insert into posts values('$a','$postby','$msg',datetime('now','localtime'),'$text')")
               or die(print_r($dbh->errorInfo(), true));
          }
          else 
          {
                $dbh->exec("insert into posts values('$a','$postby','',datetime('now','localtime'),'$text')")
                or die(print_r($dbh->errorInfo(), true));
          }
          header("Location: msg.php");
          exit;
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
