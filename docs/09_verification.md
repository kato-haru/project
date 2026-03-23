# 09. 動作確認

## 実施日
2026-03-23

## 担当者
h-kato

---

## 1. 確認結果一覧

| 確認項目 | 結果 | 備考 |
|---------|------|------|
| Web表示 | ✅ 正常 | http://localhost |
| DB接続 | ✅ 成功 | PHP→MySQL接続確認 |
| 日本語表示 | ✅ 正常 | utf8mb4設定で解決 |
| データ登録 | ✅ 正常 | フォームから登録確認 |
| データ取得 | ✅ 正常 | 一覧表示確認 |
| DB外部遮断 | ✅ 遮断確認済み | internal:true設定 |
| ヘルスチェック | ✅ 全コンテナ healthy | nginx・php・mysql |
| 自動再起動 | ✅ 動作確認済み | php強制停止→自動復帰 |
| ログ設定 | ✅ 正常 | ローテーション設定済み |

---

## 2. コンテナ状態

```
NAME      IMAGE           STATUS
mysql     mysql:8.0       Up (healthy)
nginx     project-nginx   Up (healthy)
php       project-php     Up (healthy)
```

---

## 3. 発生した問題と対処

| 問題 | 原因 | 対処法 |
|------|------|--------|
| 日本語文字化け | init.sql実行時のcharsetがlatin1 | SET NAMES utf8mb4をinit.sqlに追加 |
| Nginxヘルスチェックfail | wgetコマンド未インストール | nginx/Dockerfileを作成しcurlをインストール |
| docker-compose.yml警告 | version属性が非推奨 | version行を削除 |

---

## 4. 次のステップ

試用版の動作確認完了。
本番Ubuntuサーバーへの展開準備へ進む。

---

## 5. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成・動作確認完了 | h-kato |
