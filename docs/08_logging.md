# 08. ログ・追跡設定

## 実施日
2026-03-23

## 担当者
h-kato

---

## 1. ログ設定概要

| コンテナ | ログ保存先 | 種類 |
|---------|-----------|------|
| nginx | ./logs/nginx/ | アクセスログ・エラーログ |
| mysql | ./logs/mysql/ | MySQLログ |
| 全コンテナ | docker logs | コンテナログ |

---

## 2. ログローテーション設定

全コンテナに以下を設定。

```yaml
logging:
  driver: "json-file"
  options:
    max-size: "10m"
    max-file: "3"
```

---

## 3. ログ確認コマンド

```bash
# 全コンテナのログ確認
docker compose logs

# コンテナ別ログ確認
docker compose logs nginx
docker compose logs php
docker compose logs mysql

# リアルタイム監視
docker compose logs -f

# 直近20行のみ表示
docker compose logs nginx | tail -20
```

---

## 4. Git管理方針

| 項目 | 内容 |
|------|------|
| 構成ファイル | Gitで管理（docker-compose.yml等） |
| ログファイル | .gitignoreで除外 |
| .envファイル | .gitignoreで除外 |
| mdドキュメント | Gitで管理 |

---

## 5. 確認結果

| 確認項目 | 結果 |
|---------|------|
| ログローテーション設定 | ✅ 完了 |
| Nginxアクセスログ | ✅ 記録確認 |
| コンテナログ確認 | ✅ 正常 |

---

## 6. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成 | h-kato |
