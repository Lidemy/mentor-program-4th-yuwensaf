<?php
  require_once('conn.php');
  header('Content-type:application/json;charset=utf-8');
  header('Access-Control-Allow-Origin: *');

  // 錯誤處理
  if (
    empty($_POST['content']) ||
    empty($_POST['nickname']) ||
    empty($_POST['site_key'])
  ) {
    $json = array(
      'ok' => false,
      'message' => 'Please enter the missing fields.'
    );

    $response = json_encode($json);
    echo $response;
    die();
  }

  // 把東西拿進來
  $content = $_POST['content'];
  $nickname = $_POST['nickname'];
  $site_key = $_POST['site_key'];

  $sql = 'INSERT INTO saffran_discussions (site_key, nickname, content) VALUES(?, ?, ?)';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('sss', $site_key, $nickname, $content);
  $result = $stmt->execute();

  // 如果 SQL query 執行失敗
  if (!$result) {
    $json = array(
      'ok' => false,
      'message' => $conn->error
    );

    $response = json_encode($json);
    echo $response;
    die();
  }

  // 如果 SQL query 執行成功
  $json = array(
    'ok' => true,
    'message' => 'Success!'
  );

  $response = json_encode($json);
  echo $response;
?>