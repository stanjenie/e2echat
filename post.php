<!DOCTYPE html>
<html>
<body>
<?php
session_id('globalsession');
session_start();
$time = time();
$ch = $_REQUEST["ch"];
$u = $_REQUEST["u"];
$msg = $_REQUEST["msg"];
$reply = $_REQUEST["reply"];
try {
  $conn = new PDO("sqlite:".__DIR__."/test.db");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->exec("CREATE TABLE IF NOT EXISTS messages (
	id INTEGER PRIMARY KEY,
	channel TEXT,
	title TEXT,
	message TEXT,
	replyto INTEGER,
	time INTEGER)");
  $stmt = $conn->prepare("INSERT INTO messages (title, channel, message, replyto, time) VALUES (:title,:channel,:message,:replyto,:msgtime)");
  $stmt->bindParam(':title',$title);
  $stmt->bindParam(':channel',$channel);
  $stmt->bindParam(':message',$message);
  $stmt->bindParam(':replyto',$replyto);
  $stmt->bindParam(':msgtime',$msgtime);
  $title = $u;
  $channel = $ch;
  $message = $msg;
  $replyto = $reply;
  $msgtime = $time;
  $stmt->execute();
  $_SESSION["new"] = $time;
  $result = $conn->query('SELECT * FROM messages');
 
 //   foreach($result as $row) {
 //     echo "Id: " . $row['id'] . "<br />";
 //     echo "Title: " . $row['title'] . "<br />";
 //     echo "Message: " . $row['message'] . "<br />";
 //     echo "Time: " . $row['time'] . "<br />";
 //     echo "<br />";
 //   }
    echo "call update.php!";

} catch(PDOException $e) {
  echo $e->getMessage();
}

$conn = null;
file_put_contents('request.log', 
  '<b>' . $u . ':</b> ' . $msg .  ' (' . $time . ') <br />',FILE_APPEND);
?>
</body>
</html>

