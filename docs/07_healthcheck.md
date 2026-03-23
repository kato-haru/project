# 07. ヘルスチェック設定

## 実施日
2026-03-23

## 担当者
h-kato

---

## 1. ヘルスチェック概要

各コンテナに自動監視・自動再起動の仕組みを設定。

| コンテナ | チェック方法 | 間隔 | タイムアウト | リトライ |
|---------|------------|------|------------|--------|
| nginx | curl -f http://localhost/ | 30s | 10s | 3回 |
| php | php-fpm -t | 30s | 10s | 3回 |
| mysql | mysqladmin ping | 30s | 10s | 3回 |

---

## 2. docker-compose.yml ヘルスチェック設定

```yaml
# Nginx
healthcheck:
  test: ["CMD", "curl", "-f", "http://localhost/"]
  interval: 30s
  timeout: 10s
  retries: 3
  start_period: 10s

# PHP
healthcheck:
  test: ["CMD", "php-fpm", "-t"]
  interval: 30s
  timeout: 10s
  retries: 3
  start_period: 10s

# MySQL
healthcheck:
  test: ["CMD", "mysqladmin", "ping", "-h", "localhost", "-u", "root", "-p${MYSQL_ROOT_PASSWORD}"]
  interval: 30s
  timeout: 10s
  retries: 3
  start_period: 30s
```

---

## 3. 発生した問題と対処

| 問題 | 原因 | 対処法 |
|------|------|--------|
| NginxがUnhealthy | wgetコマンド未インストール | nginx/Dockerfileを作成しcurlをインストール |

---

## 4. 確認結果

```
mysql ... (healthy) ✅
nginx ... (healthy) ✅
php   ... (healthy) ✅
```

---

## 5. 自動再起動テスト

```bash
# phpコンテナを強制停止
docker stop php

# 30秒後に自動再起動確認
docker compose ps
# → php Up (healthy) ✅
```

---

## 6. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成 | h-kato |
