<?php

// 接続に必要な情報を定義
define('DSN', 'mysql:host=db;dbname=pet_shop;charset=utf8;');
define('USER', 'staff');
define('PASSWORD', '9999');

// DBに接続
try {
    $dbh = new PDO(DSN, USER, PASSWORD);
    // echo '接続に成功しました！' . '<br>';
} catch (PDOException $e) {
    // 接続がうまくいかない場合こちらの処理がなされる
    echo $e->getMessage();
    exit;
}

// SQL文の組み立て
$sql = 'SELECT * FROM animals';

// プリペアドステートメントの準備
// $dbh->query($sql) でも良い
$stmt = $dbh->prepare($sql);

// プリペアドステートメントの実行
$stmt->execute();

// 結果の受け取り
$animals = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($animals as $animal) {
    echo $animal['type'] . 'の' . $animal['classifcation'] . 'ちゃん<br>';
    echo $animal['description'] . '<br>';
    echo '出身地' . $animal['birthplace'] . '<br>';
    echo $animal['birthday'] . '生まれ<br>';
    echo '<hr>';
}
