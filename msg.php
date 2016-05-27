<?php
   session_start();
?>

<html>
<head>
<title>Message Board</title>
<style type="text/css">
   table {
            background-color: Beige;
            margin: 8px;
            border: 1px solid black;
   }
   td {
           border: 1px solid #DDD;
   }
</style>
</head>
<body bgcolor="#E6E6FA">
<fieldset style="background-color:#999999;">
<form action="" method="POST">
<input type="submit" name="logout" value="logout"/>
</form>
<form action="newmsg.php" method="POST">
<input type="submit" name="new message" value="new message"/>
</form>
</fieldset>
<br/>

<?php
   if(isset($_POST['logout']))
   {
      session_unset();
      header("Location: board.php");
   }
   try 
   {
      $dbname =  dirname($_SERVER["SCRIPT_FILENAME"]) ."/mydb.sqlite";
      $dbh = new PDO("sqlite:$dbname");
      $dbh->beginTransaction();
      $stmt=$dbh->prepare("select * from users, posts where posts.postedby=users.username order by datetime");
      $stmt->execute();
      echo '<fieldset style="background-color:#999999;">';
      echo "<table>";
      echo "<tbody>";
      while($row = $stmt->fetch())
      {
          $id=$row['id'];
          $follows=$row['follows'];
          $message=$row['message'];
          $username=$row['username'];
          $fullname=$row['fullname'];
          $datetime=$row['datetime'];
          echo '<tr><td><b>id:</b>'.$id. "<br/><b>Follows:</b>" .$follows.'</td>';
          echo '<td><b>msg:</b>'.$message . "<br/><b>username:</b>" . $username .'&nbsp;'."<b>fullname:</b>" . $fullname .'&nbsp;'."<b>postedat</b>:" .$datetime .'</td>';
          echo'<td><br/><form action="newmsg.php" method="POST"><input type="hidden" name="id" value="'.$id.'"/><input type="submit" value="Reply"/></form></td></tr>';
      }
      echo "</tbody>";
      echo "</table>";
      echo "</fieldset>";
   }
   catch (PDOException $e) 
   {
      print "Error!: " . $e->POSTMessage() . "<br/>";
      die();
   }
?>

</body>
</html>
