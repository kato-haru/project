# 01. 環境確認・構築

## 実施日
2026-03-23

## 担当者
h-kato

---

## 1. 環境概要

| 項目 | 内容 |
|------|------|
| ローカルPC OS | Windows 11 25H2 |
| 仮想化方式 | WSL2（Ubuntu 24.04.2 LTS） |
| コンテナ管理 | Docker Desktop for Windows |
| エディタ | VSCode |
| 最終目標環境 | Ubuntu サーバー（本番） |

---

## 2. 実施手順と結果

### 2-1. システム要件確認

```
Windowsバージョン確認コマンド：winver
確認結果：（実施後に記入）
```

| 確認項目 | 必要条件 | 結果 |
|---------|---------|------|
| Windowsバージョン | Win10 ビルド19041以上 / Win11 | （記入） |
| システム要件 | 満たしている / 満たしていない | （記入） |

---

### 2-2. WSL2 インストール

```powershell
# 実行コマンド
wsl --install
```

| 確認項目 | 結果 |
|---------|------|
| WSL2インストール | ✅ インストール済み |
| WSL バージョン | 2.5.7.0 |
| カーネル バージョン | 6.6.87.1-1 |
| Ubuntuインストール | ✅ インストール済み |
| PC再起動 | 不要（インストール済みのため） |

---

### 2-3. Docker Desktop インストール

```
ダウンロード元：https://www.docker.com/products/docker-desktop/
インストール設定：Use WSL 2 instead of Hyper-V ✅
```

| 確認項目 | 結果 |
|---------|------|
| Docker Desktopインストール | ✅ 成功 |
| WSL2統合設定 | ✅ 完了 |
| PC再起動 | ✅ 実施済み |

---

### 2-4. Docker Desktop 初期設定

```
Settings > Resources > WSL Integration
・Enable integration with my default WSL distro ✅
・Ubuntu ✅
```

| 確認項目 | 結果 |
|---------|------|
| WSL Integration設定 | ✅ 完了 |
| Apply & Restart | ✅ 実施済み |

---

### 2-5. VSCode 拡張機能インストール

| 拡張機能名 | 用途 | インストール結果 |
|-----------|------|---------------|
| WSL | WSL環境でVSCode使用 | 済 / 未 |
| Remote - SSH | 本番サーバーSSH接続 | 済 / 未 |
| Docker | コンテナ管理GUI | 済 / 未 |
| YAML | docker-compose.yml補完 | 済 / 未 |
| Markdown All in One | mdファイル編集 | 済 / 未 |
| Git Graph | コミット履歴可視化 | 済 / 未 |

---

### 2-6. インストール確認（バージョン記録）

```bash
$ docker --version
Docker version 29.2.1, build a5c7197

$ docker compose version
Docker Compose version v5.1.0

$ docker run hello-world
Hello from Docker!
This message shows that your installation appears to be working correctly.
```

| 確認項目 | バージョン / 結果 |
|---------|----------------|
| Docker バージョン | 29.2.1 |
| Docker Compose バージョン | v5.1.0 |
| hello-world 動作確認 | ✅ 成功 |

---

## 3. 発生した問題と対処

| 問題 | 対処法 | 結果 |
|------|--------|------|
| （発生した問題を記入） | （対処内容を記入） | 解決 / 未解決 |

※問題がなければ「なし」と記入

---

## 4. 次のステップ

STEP 2：ディレクトリ作成へ進む

---

## 5. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| YYYY-MM-DD | 初版作成 | （担当者名） |
