<?php           //入力された情報を表示する
session_start();
require('../dbconnect.php');

if (!isset($_SESSION['join'])) {
   header('Location: index.php');
   exit();
}

if (!empty($_POST)) {
   //登録処理をする
   $statement = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, picture=?, created=NOW()');
   echo $ret = $statement->execte(array(
      $_SESSION['join']['name'],
      $_SESSION['join']['email'],
      shal($_SESSION['join']['password']),
      $_SESSION['join']['imge']
   ));
   unset($_SESSION['join']);

   header('Location: thanks.php');
   exit();
}
?>

<from action="" method="post">
   <input type="hidden" name="action" value="sudmit" />
   <dl>
      <dt>ニックネーム</dt>
      <dd>
      <?php echo htmlspecialchars($_SESSION['join']['name'],ENT_QUOTES); ?>
      </dd>
      <dt>メールアドレス</dt>
      <dd>
      <?php echo htmlspecialchars($_SESSION['join']['name'],ENT_QUOTES); ?>
      </dd>
      <dt>パスワード</dt>
      <dd>
      [表示されません]
      </dd>
      <dt>写真など</dt>
      <dd>
      <ing src="../member_picture/<?php echo htmlspecialchars($_SESSION['join']['image'],END_QUOTES); ?>" 
      width = "100" height = "100" alt = "" /> 
      </dd>
   </dl>
   <div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <inputtype="submit" value="登録する" /><div>
</form>