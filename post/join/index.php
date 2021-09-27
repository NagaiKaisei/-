<?php
require('../dbconnect.php');

session_start();

if (!empty($_POST)) {
    // エラー項目の確認
    if ($_POST['name'] == '') {
        $error['name'] = 'blank';
    }
    $fileName = $_FILES['image']['name'];
    if (!empty($fileName)) {
        $ext = substr($fileName, -3);
        if ($ext != 'jpg' && $ext !='git') {
            $error['image'] = 'type';
        }
    }

    //重複アカウントのチェック
    if (empty($error)) {
        $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
        $member->execute(array($_POST['email']));
        $record = $member->fetch();
        if ($record['cnt'] > 0) {
            $error['email'] = 'duplicate';
        }
    }
    if ($_POST['email'] == '') {
        $error['email'] = 'blank';
    }
    if (strlen($_POST['password']) < 4) {
        $error['password'] = 'blank';
    }
    $fileName = $_FILES['image']['name'];
    if (!empty($fileName)) {
        $ext = substr($fileName, -3);
        if ($ext != 'jpg' && $ext != 'git') {
            $error['image'] = 'type';
        }
    }
    if (empty($error)) {
        //画像をアップロードする
        $image = date('YmdHis') . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' .$image);

        $_SESSION['join'] = $_POST;
        $_SESSION['join']['image'] = $image;
        header('Locaiton: check.php');
        exit();
    }
}

//書き直し
if ($_REQUEST['action'] == 'rewrite') {
    $_POST = $_SESSION['join'];
    $error['rewrite'] = true;
}
?>

<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" type="text/css" href="index.css"  >
<head>
    <title>会員登録画面</title>
    </head>
    <body>
<p>次のフォームに必要項目を記入してください</p>
<form action="" method="post" enctype="multipart/form-data" class="registrationform">
   <dl>
     <dt>ニックネーム<span class="required">(必須)</dt>
     <dd>
         <input type="text" name="name" size="35" maxlength="255" 
         value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES); ?>" />
         <?php if ($error['name'] == 'blank'): ?>
         <p class="error">* ニックネームを入力してください</p>
         <?php endif; ?>
     </dd>
     <dt>メールアドレス<span class="required">(必須)</span></dt>
     <dd><input type="text" name="email" size="35" maxlength="255" 
     value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>" />
         <?php if ($error['email'] == 'blank'): ?>
         <p class="error">*メールアドレスを記入してください</p>
         <?php endif; ?>
         <?php if ($error['email'] == 'duplicate'): ?>
         <p class="error">* 指定されたメールアドレスはすでに登録されてます</p>
         <?php endif; ?>
     </dd>
     <dt>パスワード<span class="required">(必須)</span></dt>
     <dd>
         <input type="password" name="password" size="10"maxlenght="20" 
         value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>" />
         <?php if ($error['password'] == 'blank'): ?>
         <p class="error">*パスワードを入力してください</p>
         <?php endif; ?>
         <?php if ($error['password'] == 'lenght'): ?>
         <p class="error">*パスワードは4文字以上で入力し</p>
         <?php endif; ?>
     </dd>
     
     <dt>写真など</dt>
     <dd>
         <input type="file" name="image" size="35" />
         <?php if ($error['image'] == 'type'): ?>
         <p class="error">*写真などは[.gif]または[.jpg]の画面を指定してください</p>
         <?php endif; ?>
         <?php if (!empty($error)): ?>
            <p class="error">*恐れ入りますが、画像を改めて指定してください</p>
         <?php endif; ?>
        </dd>
   </dl>
   <div><input type='submit' value="入力内容を確認する" /></div>
</form>
</body>
</html>
