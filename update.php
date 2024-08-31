<?php

  $from = $_REQUEST["from"];
  $channel = $_REQUEST["ch"];
  try {
    $conn = new PDO("sqlite:".__DIR__."/test.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $result = $conn->query("SELECT * FROM messages WHERE id > " . $from . " AND channel = '" . $channel . "'");
//   foreach($result as $row) {
//      echo "Id: " . $row['id'] . "<br />";
//      echo "Title: " . $row['title'] . "<br />";
//      echo "Message: " . $row['message'] . "<br />";
//      echo "Time: " . $row['time'] . "<br />";
//      echo "<br />";
//    }
    $out_arr = array();
    foreach($result as $row) {
      $out_arr[] = $row;
    }
    echo json_encode($out_arr);
  } catch(PDOException $e) {
    echo $e->getMessage();
  }
?>