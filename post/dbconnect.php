<?php
try {
    $db = new PDO('mysql:dbname=test.1;port=8889;charset=utf8','root','root');
} catch (PDOException $_e) {
    echo 'DB接続エラー: ' . $_e->getMessage();
}
?>