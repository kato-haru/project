# 残り作業計画

## 作成日
2026-03-23

## 担当者
h-kato

---

## 1. 残り作業一覧

| # | 作業内容 | 担当 | 状態 |
|---|---------|------|------|
| 1 | Claude/ChatGPTの役割分けルール策定 | h-kato | ⬜ 未実施 |
| 2 | 本番サーバーの環境確認 | h-kato | ⬜ 未実施 |
| 3 | 本番サーバーへのDocker環境構築 | Claude作成・ChatGPT確認 | ⬜ 未実施 |
| 4 | 本番サーバーへの構成展開 | Claude作成・ChatGPT確認 | ⬜ 未実施 |
| 5 | SSH設定（NKさん・義さんの2名限定） | Claude作成・ChatGPT確認 | ⬜ 未実施 |
| 6 | 本番動作確認 | ChatGPT確認 | ⬜ 未実施 |
| 7 | 最終ドキュメント整備 | h-kato | ⬜ 未実施 |

---

## 2. Claude/ChatGPTの役割分けルール

### 役割定義

| AI | 役割 | 担当内容 |
|----|------|---------|
| **Claude** | 作成担当 | 手順書作成・設定ファイル生成・コマンド提示 |
| **ChatGPT** | 確認担当 | 作成内容のレビュー・セキュリティチェック・問題点の指摘 |

### 運用フロー

```
① Claudeが手順・設定ファイルを作成
      ↓
② 作成内容をChatGPTに共有してレビュー依頼
      ↓
③ ChatGPTの指摘事項をClaudeにフィードバック
      ↓
④ 修正が必要な場合はClaudeが修正
      ↓
⑤ 問題なければ実施
      ↓
⑥ 実施結果をmdに記録
```

### チェック項目（ChatGPT確認用）

```
□ セキュリティ上の問題はないか
□ 設定ファイルに誤りはないか
□ 抜け漏れはないか
□ より良い方法はないか
□ 本番環境として適切か
```

---

## 3. 本番サーバー環境確認項目

本番サーバーに接続して以下を確認します。

### 3-1. OS・基本情報確認

```bash
# OSバージョン確認
cat /etc/os-release

# カーネルバージョン確認
uname -r

# ディスク容量確認
df -h

# メモリ確認
free -h

# CPU確認
nproc
```

### 3-2. Docker環境確認

```bash
# Dockerインストール確認
docker --version

# Docker Composeインストール確認
docker compose version
```

### 3-3. ネットワーク確認

```bash
# 開放ポート確認
ss -tlnp

# ファイアウォール確認
sudo ufw status
```

---

## 4. 本番サーバーへの構成展開手順

### 4-1. GitHubからクローン

```bash
# プロジェクトをクローン
git clone <リポジトリURL> ~/project
cd ~/project
```

### 4-2. .envファイルの作成

```bash
# .env.exampleをコピーして本番用パスワードに変更
cp .env.example .env
nano .env
```

**本番用パスワードの要件**
```
・16文字以上
・英数字・記号を混在
・推測されにくいもの
・ローカルと同じパスワードは使わない
```

### 4-3. コンテナ起動

```bash
docker compose up -d --build
docker compose ps
```

---

## 5. SSH設定（2名限定）

### 対象者

| 名前 | 役割 |
|------|------|
| NKさん | アクセス許可ユーザー1 |
| 義さん | アクセス許可ユーザー2 |

### 設定手順

```bash
# SSHディレクトリ作成
mkdir -p ~/.ssh
chmod 700 ~/.ssh

# authorized_keysに公開鍵を登録（2名分）
nano ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

### SSHセキュリティ設定

```bash
# SSH設定ファイルを編集
sudo nano /etc/ssh/sshd_config
```

**設定内容**
```
# パスワード認証を無効化
PasswordAuthentication no

# rootログインを禁止
PermitRootLogin no

# 公開鍵認証を有効化
PubkeyAuthentication yes

# アクセス許可ユーザーを限定
AllowUsers nk yoshisan
```

```bash
# SSH再起動
sudo systemctl restart sshd

# 設定確認
sudo sshd -t
```

---

## 6. 本番動作確認項目（ChatGPT確認担当）

```
□ Webページが正常に表示されるか
□ DB接続が成功しているか
□ データの登録・取得が正常か
□ DBへの外部アクセスが遮断されているか
□ SSHが2名のみアクセス可能か
□ ヘルスチェックが全てhealthyか
□ ログが正常に記録されているか
□ セキュリティヘッダーが設定されているか
```

---

## 7. 最終ドキュメント整備

```
□ 各mdファイルの実施日・結果を記入
□ 発生した問題と対処をmdに記録
□ 本番サーバー情報をまとめる
□ 運用手順書を作成
□ 障害対応手順書（ランブック）を作成
□ GitHubにプッシュして最終版を保存
```

---

## 8. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成 | h-kato |