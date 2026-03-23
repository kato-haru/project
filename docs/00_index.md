# プロジェクト全体まとめ・目録

## 作成日
2026-03-23

## 担当者
h-kato

---

## 1. ディレクトリ構造と役割

```
~/project/
│
├── docker-compose.yml        ← 全コンテナの定義・ネットワーク・ボリューム設定
├── .env                      ← 認証情報・環境変数（Gitに含めない）
├── .env.example              ← .envのサンプル（Gitに含める）
├── .gitignore                ← Git除外設定（.env・ログ等）
│
├── nginx/
│   ├── Dockerfile            ← NginxイメージにcurlをインストールするDocker定義
│   └── conf.d/
│       └── default.conf      ← リバースプロキシ・セキュリティヘッダー設定
│
├── php/
│   ├── Dockerfile            ← PHP拡張機能・非rootユーザー設定
│   ├── custom.ini            ← PHP文字コード・エラー表示設定
│   └── src/
│       └── index.php         ← 試用版Webページ（登録・一覧表示）
│
├── mysql/
│   └── init/
│       └── init.sql          ← DB初期設定・テーブル定義・初期データ投入
│
├── logs/
│   ├── nginx/                ← Nginxアクセスログ・エラーログ保存先
│   └── mysql/                ← MySQLログ保存先
│
└── docs/                     ← 手順・記録ドキュメント
    ├── 00_overview.md
    ├── 01_environment.md
    ├── 02_directory.md
    ├── 03_network.md
    ├── 04_db.md
    ├── 05_web.md
    ├── 06_security.md
    ├── 07_healthcheck.md
    ├── 08_logging.md
    ├── 09_verification.md
    ├── 10_remaining_tasks.md
    └── 11_ssh_settings.md
```

---

## 2. コンテナ構成と役割

| コンテナ名 | イメージ | 役割 | 外部公開 |
|-----------|---------|------|---------|
| nginx | nginx:1.25-alpine | リバースプロキシ・静的ファイル配信 | ✅ ポート80 |
| php | php:8.2-fpm-alpine | PHPアプリケーション実行 | ❌ 内部のみ |
| mysql | mysql:8.0 | データベース | ❌ 完全遮断 |

---

## 3. ネットワーク構成と役割

| ネットワーク名 | 役割 | 外部公開 |
|--------------|------|---------|
| web_network | Nginx↔PHP通信用 | ✅ ポート80のみ |
| db_network | PHP↔MySQL通信用 | ❌ internal:true |

---

## 4. mdファイル目録

| # | ファイル名 | 内容 | 状態 |
|---|-----------|------|------|
| 00 | 00_overview.md | プロジェクト全体概要・構成・方針 | ✅ 完了 |
| 01 | 01_environment.md | 環境確認・Docker Desktopインストール | ✅ 完了 |
| 02 | 02_directory.md | ディレクトリ・ファイル構成の作成 | ✅ 完了 |
| 03 | 03_network.md | Dockerネットワーク設計・DB外部遮断 | ✅ 完了 |
| 04 | 04_db.md | MySQL構築・文字コード設定・初期データ | ✅ 完了 |
| 05 | 05_web.md | Nginx・PHP-FPM構築・リバースプロキシ設定 | ✅ 完了 |
| 06 | 06_security.md | セキュリティヘッダー・非root・.env管理 | ✅ 完了 |
| 07 | 07_healthcheck.md | ヘルスチェック・自動再起動設定 | ✅ 完了 |
| 08 | 08_logging.md | ログ収集・ローテーション・追跡設定 | ✅ 完了 |
| 09 | 09_verification.md | 全項目の動作確認結果 | ✅ 完了 |
| 10 | 10_remaining_tasks.md | 残り作業計画・役割分け・本番展開手順 | ✅ 完了 |
| 11 | 11_ssh_settings.md | SSH公開鍵認証設定（3名分） | ✅ 完了 |

---

## 5. 各mdファイルの主な記載内容

### 00_overview.md
- プロジェクト構成図
- 使用技術一覧
- 優先方針（セキュリティ・追跡・耐障害性）
- ディレクトリ構成
- ネットワーク設計方針
- SSH接続方針
- Git管理方針

### 01_environment.md
- ローカルPC環境（Windows 11 25H2）
- WSL2バージョン（2.5.7.0）
- Dockerバージョン（29.2.1）
- Docker Composeバージョン（v5.1.0）
- VSCode拡張機能インストール結果

### 02_directory.md
- プロジェクトフォルダ構成
- 各ファイル・フォルダの役割
- 作成コマンド

### 03_network.md
- Dockerネットワーク構成
- web_network・db_networkの役割
- DB外部遮断設定（internal: true）

### 04_db.md
- MySQL 8.0の構築内容
- 文字コード設定（utf8mb4）
- init.sqlの内容
- 文字化け問題と対処法

### 05_web.md
- Nginx設定（リバースプロキシ）
- PHP-FPM設定
- Dockerfileの内容
- PHP文字コード設定

### 06_security.md
- Nginxセキュリティヘッダー設定
- DB外部遮断確認
- .env管理方針
- 非rootユーザー設定

### 07_healthcheck.md
- 各コンテナのヘルスチェック設定
- 自動再起動テスト結果
- Nginxヘルスチェック問題と対処法

### 08_logging.md
- ログ保存先・種類
- ログローテーション設定
- ログ確認コマンド
- Git管理方針

### 09_verification.md
- 全動作確認結果
- 発生した問題と対処まとめ
- コンテナ状態確認結果

### 10_remaining_tasks.md
- Claude/ChatGPT役割分けルール
- 本番サーバー環境確認項目
- 本番サーバー展開手順
- SSH設定計画
- 最終ドキュメント整備チェックリスト

### 11_ssh_settings.md
- SSH公開鍵認証設定（3名分）
- authorized_keys登録内容
- sshd_config設定内容
- 接続テスト結果
- 秘密鍵受け渡し注意事項

---

## 6. 優先度別対応状況

| 優先度 | 内容 | 状態 |
|--------|------|------|
| 1位 | セキュリティ | ✅ 完了 |
| 2位 | 追跡・状況把握 | ✅ 完了 |
| 3位 | 耐障害性・復帰速度 | ✅ 完了 |

---

## 7. 残り作業

| 作業 | 状態 |
|------|------|
| 秘密鍵の受け渡し方法決定 | ⬜ 未実施 |
| NKさん・義さんへの秘密鍵受け渡し | ⬜ 未実施 |
| 本番サーバーへの展開 | ⬜ 未実施 |
| 本番SSH設定 | ⬜ 未実施 |
| ChatGPTによるレビュー | ⬜ 未実施 |
| 最終ドキュメント整備 | ⬜ 未実施 |

---

## 8. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成 | h-kato |
