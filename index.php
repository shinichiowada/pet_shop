<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>pet_shop</title>
</head>

<body>
    <h2>本日のご紹介ペット!</h2>
    <form action="" method="get">
        <div>
            <label for="keyword">キーワード:</label>
            <input type="text" name="keyword" placeholder="キーワードの入力">
            <input type="submit" value="検索">
        </div>
        <br>
    </form>
</body>

</html>

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

if ($_GET === '') {
    // SQL文の組み立て
    $sql = 'SELECT * FROM animals';

    // プリペアドステートメントの準備
    // $dbh->query($sql) でも良い
    $stmt = $dbh->prepare($sql);

    // プリペアドステートメントの実行
    $stmt->execute();

    // 結果の受け取り
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {

    $keyword = $_GET['keyword'];
    $keyword = '%' . $keyword . '%'; // %ではさむ
    // SQL文の組み立て
    $sql = 'SELECT * FROM animals WHERE description LIKE :keyword';
    // プリペアドステートメントの準備
    // $dbh->query($sql) でも良い
    $stmt = $dbh->prepare($sql);

    // プリペアドステートメントの実行
    $stmt->bindValue(':keyword', $keyword, PDO::PARAM_STR);
    $stmt->execute();

    // 結果の受け取り
    $animals = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<?php foreach ($animals as $animal) : ?>
    <?= $animal['type'] . 'の' . $animal['classifcation'] . 'ちゃん' ?><br>
    <?= $animal['description'] ?><br>
    <?= '出身地' . $animal['birthplace'] ?><br>
    <?= $animal['birthday'] . '生まれ' ?>
    <hr>
<?php endforeach; ?>