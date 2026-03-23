<?php
header('Content-Type: text/html; charset=utf-8');
// DB接続設定（環境変数から取得）
$host     = 'mysql';
$dbname   = getenv('MYSQL_DATABASE')  ?: 'testdb';
$user     = getenv('MYSQL_USER')      ?: 'appuser';
$password = getenv('MYSQL_PASSWORD')  ?: 'apppass123';

// DB接続
$pdo = null;
$error = null;
try {
$pdo = new PDO(
    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
    $user,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"  // ← この行を追加
    ]
);
} catch (PDOException $e) {
    $error = $e->getMessage();
}

// フォーム送信処理
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    $name  = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    if ($name && $email) {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email) VALUES (?, ?)"
            );
            $stmt->execute([$name, $email]);
            $message = "✅ 登録しました！";
        } catch (PDOException $e) {
            $message = "❌ エラー：" . $e->getMessage();
        }
    }
}

// ユーザー一覧取得
$users = [];
if ($pdo) {
    $users = $pdo->query(
        "SELECT * FROM users ORDER BY created_at DESC"
    )->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>試用版 Webシステム</title>
    <style>
        body { font-family: sans-serif; max-width: 800px;
               margin: 40px auto; padding: 0 20px; }
        h1   { color: #333; }
        .status { padding: 10px; border-radius: 4px; margin: 10px 0; }
        .ok  { background: #d4edda; color: #155724; }
        .err { background: #f8d7da; color: #721c24; }
        input { padding: 8px; margin: 4px 0; width: 100%;
                box-sizing: border-box; }
        button { padding: 10px 20px; background: #007bff;
                 color: white; border: none; border-radius: 4px;
                 cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>🌐 試用版 Webシステム</h1>

    <!-- DB接続ステータス -->
    <?php if ($pdo): ?>
        <div class="status ok">✅ DB接続：成功</div>
    <?php else: ?>
        <div class="status err">❌ DB接続：失敗 - <?= $error ?></div>
    <?php endif; ?>

    <!-- 登録フォーム -->
    <h2>ユーザー登録</h2>
    <?php if ($message): ?>
        <div class="status ok"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST">
        <label>名前：</label>
        <input type="text" name="name" required placeholder="名前を入力">
        <label>メール：</label>
        <input type="email" name="email" required placeholder="メールアドレスを入力">
        <br><br>
        <button type="submit">登録</button>
    </form>

    <!-- ユーザー一覧 -->
    <h2>登録済みユーザー一覧</h2>
    <?php if ($users): ?>
        <table>
            <tr><th>ID</th><th>名前</th><th>メール</th><th>登録日時</th></tr>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= $u['name'] ?></td>
                <td><?= $u['email'] ?></td>
                <td><?= $u['created_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>登録済みユーザーはいません。</p>
    <?php endif; ?>
</body>
</html>