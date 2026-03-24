# 13. ランブック（障害対応手順書）

## 作成日
2026-03-23

## 担当者
h-kato

---

## 1. 基本情報

| 項目 | 内容 |
|------|------|
| リポジトリ | https://github.com/kato-haru/project |
| ローカル環境 | Windows 11 25H2 / WSL2 / Docker Desktop |
| 本番環境 | Ubuntu サーバー（取得後に記載） |

---

## 2. 復帰手順：GitHubから環境を再構築

### 新しいサーバー・PCでの復帰手順

```bash
# ① GitHubからクローン
git clone https://github.com/kato-haru/project.git
cd project

# ② .envファイルを作成（Gitに含まれないため手動作成）
cp .env.example .env
nano .env
# 以下を設定：
# MYSQL_ROOT_PASSWORD=（パスワードを設定）
# MYSQL_DATABASE=testdb
# MYSQL_USER=appuser
# MYSQL_PASSWORD=（パスワードを設定）

# ③ コンテナ起動
docker compose up -d --build

# ④ 確認
docker compose ps
```

**復帰時間目安：5〜10分**

---

## 3. 障害パターン別対応手順

### パターン1：コンテナのみ停止

**症状**
```
Webページが表示されない
docker compose ps でコンテナがDown
```

**対応手順**
```bash
# 状態確認
docker compose ps

# コンテナ起動
docker compose up -d

# 確認
docker compose ps
# → 全コンテナ（healthy）になればOK
```

**復帰時間目安：30秒〜1分**

---

### パターン2：Docker Desktop停止

**症状**
```
docker コマンドが使えない
タスクバーにDockerアイコンがない
```

**対応手順**
```
① Docker Desktopを起動
② クジラアイコンが安定するまで待つ
③ ターミナルで以下を実行

docker compose up -d
docker compose ps
```

**復帰時間目安：1〜2分**

---

### パターン3：WSL2停止

**症状**
```
WSLターミナルが起動しない
VSCodeのWSL接続ができない
```

**対応手順**
```powershell
# PowerShellで実行
wsl --shutdown
wsl

# WSL起動後にターミナルで実行
cd ~/project
docker compose up -d
docker compose ps
```

**復帰時間目安：2〜3分**

---

### パターン4：Windows再起動後

**症状**
```
再起動後にWebページが表示されない
```

**対応手順**
```
① Docker Desktopの自動起動を待つ
   （タスクバーのDockerアイコンが安定するまで）
② VSCodeでWSLに接続
③ ターミナルで以下を実行

cd ~/project
docker compose up -d
docker compose ps
```

**復帰時間目安：3〜5分**

---

### パターン5：コンテナ再ビルドが必要な場合

**症状**
```
設定ファイルを変更したが反映されない
コンテナが起動しない
```

**対応手順**
```bash
# 全コンテナ停止
docker compose down

# 再ビルド・起動
docker compose up -d --build

# 確認
docker compose ps
```

**復帰時間目安：5〜10分**

---

### パターン6：完全リセット（最終手段）

**症状**
```
上記全てを試しても復帰しない
DBデータが壊れた
```

⚠️ **注意：DBデータが全て削除されます**
必ずバックアップを確認してから実行してください。

```bash
# 全コンテナ・ボリューム削除
docker compose down -v

# 再ビルド・起動
docker compose up -d --build

# 確認
docker compose ps
```

**復帰時間目安：5〜15分**

---

## 4. ログ確認手順

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

## 5. 状態確認コマンド一覧

```bash
# コンテナ状態確認
docker compose ps

# ヘルスチェック詳細確認
docker inspect nginx --format='{{json .State.Health}}' | python3 -m json.tool

# DB接続確認
docker exec -it mysql mysql -u appuser -papppass123 testdb -e "SELECT 1;"

# ディスク使用量確認
df -h

# メモリ使用量確認
free -h
```

---

## 6. .env管理

| 項目 | 内容 |
|------|------|
| 保管場所 | 安全な場所に別途保管（要検討） |
| 内容 | DB接続情報・パスワード |
| 紛失時 | .env.exampleを参考に再作成 |

```bash
# .envの内容確認
cat .env.example
```

---

## 7. 緊急連絡先

| 役割 | 担当者 | 連絡先 |
|------|--------|--------|
| 管理者 | h-kato | （記入） |
| サブ担当 | NK | （記入） |

---

## 8. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成 | h-kato |
