# 12. セキュリティ追加事項（本番サーバー取得後に対応）

## 作成日
2026-03-23

## 担当者
h-kato

---

## 1. 概要

本番サーバー取得後に対応するセキュリティ追加事項をまとめる。
現段階（試用版）では未実施。

---

## 2. PHASE2：本番前に実施する項目

### ⑥ trivyによる脆弱性スキャン

```bash
# trivyインストール
sudo apt install -y trivy

# イメージスキャン
trivy image project-nginx
trivy image project-php
trivy image mysql:8.0
```

| 項目 | 内容 |
|------|------|
| 目的 | Dockerイメージの既知脆弱性を検出 |
| 実施タイミング | 本番サーバー構築時・定期的に実施 |
| 状態 | ⬜ 未実施 |

---

### ⑦ MySQL権限の最小化

```sql
-- appuserに必要最小限の権限のみ付与
REVOKE ALL PRIVILEGES ON testdb.* FROM 'appuser'@'%';
GRANT SELECT, INSERT, UPDATE, DELETE ON testdb.* TO 'appuser'@'%';
FLUSH PRIVILEGES;
```

| 項目 | 内容 |
|------|------|
| 目的 | appuser侵害時のDB構造変更を防ぐ |
| 実施タイミング | 本番サーバー構築時 |
| 状態 | ⬜ 未実施 |

---

### ⑧ fail2ban設定

```bash
# fail2banインストール
sudo apt install -y fail2ban

# SSH用設定ファイル作成
sudo nano /etc/fail2ban/jail.local
```

```ini
[sshd]
enabled = true
port = ssh
maxretry = 5
bantime = 3600
findtime = 600
```

| 項目 | 内容 |
|------|------|
| 目的 | SSH不正アクセスの自動ブロック |
| 効果 | 5回失敗で1時間ブロック |
| 実施タイミング | 本番サーバー構築時 |
| 状態 | ⬜ 未実施 |

---

## 3. 本番公開前に必須の項目

### HTTPS/SSL対応

| 項目 | 内容 |
|------|------|
| 方法 | Let's Encrypt（無料SSL証明書） |
| 目的 | 通信の暗号化 |
| 状態 | ⬜ 未実施（本番サーバー取得後） |

---

### HSTSヘッダー追加

```nginx
# HTTPS対応後に追加
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains";
```

| 項目 | 内容 |
|------|------|
| 目的 | HTTPSを強制・ダウングレード攻撃を防ぐ |
| 前提 | SSL対応後に設定 |
| 状態 | ⬜ 未実施 |

---

### ファイアウォール（UFW）設定

```bash
# UFW設定
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow 22/tcp    # SSH
sudo ufw allow 80/tcp    # HTTP
sudo ufw allow 443/tcp   # HTTPS
sudo ufw enable
```

| 項目 | 内容 |
|------|------|
| 目的 | 不要ポートを全て遮断 |
| 状態 | ⬜ 未実施 |

---

### OS・コンテナ定期アップデート

```bash
# OS更新
sudo apt update && sudo apt upgrade -y

# Dockerイメージ更新
docker compose pull
docker compose up -d
```

| 項目 | 内容 |
|------|------|
| 目的 | セキュリティパッチの適用 |
| 頻度 | 月1回以上 |
| 状態 | ⬜ 運用ルール未策定 |

---

## 4. 優先順位

```
本番サーバー取得後の実施順序：

① ファイアウォール（UFW）設定    ← 最初にやる
② HTTPS/SSL対応（Let's Encrypt）
③ HSTSヘッダー追加
④ trivyによる脆弱性スキャン
⑤ MySQL権限の最小化
⑥ fail2ban設定
⑦ OS・コンテナ定期アップデート運用
```

---

## 5. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成・追加事項まとめ | h-kato |
