# 06. セキュリティ設定

## 実施日
2026-03-23

## 担当者
h-kato

---

## 1. セキュリティ設定一覧

| 項目 | 設定内容 | 状態 |
|------|---------|------|
| DB外部遮断 | `internal: true` | ✅ 完了 |
| 認証情報管理 | `.env`ファイルで管理・Gitに含めない | ✅ 完了 |
| Nginxセキュリティヘッダー | 各種ヘッダー追加 | ✅ 完了 |
| Nginxバージョン非表示 | `server_tokens off` | ✅ 完了 |
| PHPエラー非表示 | `display_errors = Off` | ✅ 完了 |
| 非rootユーザー実行 | PHPコンテナを非rootで実行 | ✅ 完了 |
| .envアクセス禁止 | Nginxで`.env`へのアクセスを拒否 | ✅ 完了 |

---

## 2. Nginxセキュリティヘッダー設定

```nginx
# セキュリティヘッダー
add_header X-Frame-Options "SAMEORIGIN";
add_header X-Content-Type-Options "nosniff";
add_header X-XSS-Protection "1; mode=block";
add_header Referrer-Policy "strict-origin-when-cross-origin";

# バージョン情報を隠す
server_tokens off;

# .envへのアクセスを禁止
location ~ /\.env {
    deny all;
}
```

---

## 3. .env管理

```bash
# .gitignoreに追加済み
.env
.env.*
!.env.example
```

---

## 4. DB外部遮断確認

```
mysql ... 3306/tcp（0.0.0.0:なし）← ✅ 外部遮断確認済み
```

---

## 5. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成 | h-kato |
