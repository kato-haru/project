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
| CSPヘッダー | Content-Security-Policyを追加 | ✅ 完了 |
| Nginxバージョン非表示 | `server_tokens off` | ✅ 完了 |
| PHPバージョン非表示 | `expose_php = Off` | ✅ 完了 |
| PHPエラー非表示 | `display_errors = Off` | ✅ 完了 |
| 非rootユーザー実行 | PHPコンテナを非rootで実行 | ✅ 完了 |
| 不要ファイルアクセス拒否 | .git/.sql/.sh/.md/.yml/.ini等を拒否 | ✅ 完了 |
| DBroot直接使用禁止 | アプリはappuserのみ使用 | ✅ 完了 |
| AllowUsers設定 | nk・yoshisanのみSSH許可 | ✅ 完了 |
| SSH専用ユーザー作成 | nk・yoshisanユーザーを作成・完全分離 | ✅ 完了 |

---

## 2. Nginxセキュリティヘッダー設定

```nginx
# セキュリティヘッダー
add_header X-Frame-Options "SAMEORIGIN";
add_header X-Content-Type-Options "nosniff";
add_header Referrer-Policy "strict-origin-when-cross-origin";

# CSP（X-XSS-Protectionから変更）
add_header Content-Security-Policy "default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;";

# バージョン情報を隠す
server_tokens off;
```

---

## 3. 不要ファイルアクセス拒否設定

```nginx
location ~ /\.ht        { deny all; }
location ~ /\.env       { deny all; }
location ~ /\.git       { deny all; }
location ~ /\.sql       { deny all; }
location ~ /\.sh        { deny all; }
location ~ /\.md        { deny all; }
location ~ /\.yml       { deny all; }
location ~ /\.ini       { deny all; }
```

---

## 4. PHP設定（custom.ini）

```ini
default_charset = "UTF-8"
mbstring.internal_encoding = UTF-8
display_errors = Off
log_errors = On
error_reporting = E_ALL
expose_php = Off
```

---

## 5. DB運用方針

| 項目 | 内容 |
|------|------|
| アプリ接続ユーザー | appuserのみ使用 |
| rootユーザー | 日常運用では使用しない |
| appuserの権限 | testdbへのアクセスのみ |

---

## 6. SSH設定

| 項目 | 内容 |
|------|------|
| 許可ユーザー | nk・yoshisan（AllowUsers設定済み） |
| 認証方式 | 公開鍵認証のみ |
| パスワード認証 | 無効（PasswordAuthentication no） |
| rootログイン | 禁止（PermitRootLogin no） |
| ユーザー分離 | nk・yoshisan専用Ubuntuユーザーを作成 |

---

## 7. DB外部遮断確認

```
mysql ... 3306/tcp（0.0.0.0:なし）← ✅ 外部遮断確認済み
```

---

## 8. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成 | h-kato |
| 2026-03-23 | PHASE1セキュリティ強化追加（CSP・不要ファイル拒否・PHP非表示・AllowUsers） | h-kato |
