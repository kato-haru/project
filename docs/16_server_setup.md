# 16. Kagoya VPSサーバー初期設定・デプロイ

## 実施日
2026-03-26

## 担当者
h-kato

---

## 1. サーバー情報

| 項目 | 内容 |
|------|------|
| サービス | Kagoya VPS |
| IPアドレス | 133.18.180.254 |
| OS | Ubuntu 24.04.3 LTS |
| CPU | 2コア |
| メモリ | 2GB |
| ストレージ | 200GB（NVMe SSD） |
| 料金 | 日額28円（月額上限770円） |
| 用途 | テスト運用 |

---

## 2. 実施内容

### 2-1. インスタンス作成

| 項目 | 設定内容 |
|------|---------|
| OS | Ubuntu Server 24.04 LTS |
| CPU | 2コア |
| メモリ | 2GB |
| ストレージ | 200GB |
| virtio | ON |
| セキュリティグループ | 未設定（後でUFW設定） |

---

### 2-2. 初回SSH接続のトラブルと対処

| 問題 | 原因 | 対処法 |
|------|------|--------|
| SSHパスワード認証が失敗 | Ubuntu24.04の初期設定でパスワード認証が無効 | WebコンソールでPasswordAuthentication yes・PermitRootLogin yesに変更 |
| nanoが未インストール | Ubuntu Serverの最小構成 | viを使用 |
| sshd.serviceが見つからない | Ubuntu24.04はssh.service | systemctl restart sshに変更 |
| REMOTE HOST IDENTIFICATION HAS CHANGED | 初期化後にSSH鍵が変わった | ssh-keygen -R 133.18.180.254で古い鍵を削除 |

---

### 2-3. 一般ユーザー作成

```bash
# ユーザー作成
adduser hkato

# sudo権限付与
usermod -aG sudo hkato
```

---

### 2-4. Dockerインストール

```bash
# パッケージ最新化
apt update && apt upgrade -y

# Dockerインストール
curl -fsSL https://get.docker.com | sh

# hkatoをdockerグループに追加
usermod -aG docker hkato

# Docker起動・自動起動設定
systemctl start docker
systemctl enable docker
```

| 確認項目 | バージョン |
|---------|-----------|
| Docker | 29.3.1 |
| Docker Compose | v5.1.1 |

---

### 2-5. GitHubからクローン

```bash
su - hkato
git clone https://github.com/kato-haru/project.git
cd ~/project
```

---

### 2-6. .envファイルの作成

```bash
cp .env.example .env
vi .env
```

| 項目 | 内容 |
|------|------|
| MYSQL_ROOT_PASSWORD | 強力なパスワードを設定 |
| MYSQL_DATABASE | testdb |
| MYSQL_USER | appuser |
| MYSQL_PASSWORD | 強力なパスワードを設定 |

---

### 2-7. docker-compose.ymlの修正

apacheコンテナに環境変数を渡すため
env_fileを追加。

```yaml
apache:
  build: ./apache
  container_name: apache
  ports:
    - "80:80"
  env_file:
    - .env        # ← 追加
  volumes:
    ...
```

---

### 2-8. コンテナ起動

```bash
docker compose up -d --build
docker compose ps
```

| コンテナ | 状態 |
|---------|------|
| apache | ✅ healthy |
| mysql | ✅ healthy |

---

## 3. 動作確認結果

| 確認項目 | 結果 |
|---------|------|
| Webページ表示 | ✅ 正常 |
| DB接続 | ✅ 成功 |
| 日本語表示 | ✅ 正常 |
| データ登録 | ✅ 正常 |
| データ削除 | ✅ 正常 |

**アクセスURL：http://133.18.180.254**

---

## 4. 構成について

| 項目 | 内容 |
|------|------|
| WebとDBの関係 | 同じサーバー上で別コンテナとして分離 |
| DB外部遮断 | internal:trueで外部からアクセス不可 |
| 将来の拡張 | 本番本格化時に別サーバー構成を検討 |

---

## 5. 残り作業

| 作業 | 状態 |
|------|------|
| ファイアウォール（UFW）設定 | ⬜ 未実施 |
| SSH公開鍵認証設定 | ⬜ 未実施 |
| パスワード認証の無効化 | ⬜ 未実施 |
| サブドメインのDNS設定 | ⬜ 未実施 |
| SSL/HTTPS設定 | ⬜ 未実施 |
| Apacheセキュリティ設定 | ⬜ 未実施 |
| 監視アラート設定 | ⬜ 未実施 |
| バックアップ設定 | ⬜ 未実施 |

---

## 6. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-26 | 初版作成・デプロイ完了 | h-kato |
