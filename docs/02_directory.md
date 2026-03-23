# 02. ディレクトリ・ファイル構成の作成

## 実施日
2026-03-23

## 担当者
h-kato

---

## 1. 作成したディレクトリ・ファイル構成

```
~/project/
├── docker-compose.yml       ← コンテナ全体の定義
├── .env                     ← 認証情報（Gitに含めない）
├── .env.example             ← .envのサンプル（Gitに含める）
├── .gitignore               ← Git除外設定
├── nginx/
│   └── conf.d/
│       └── default.conf     ← Nginx設定
├── php/
│   ├── Dockerfile           ← PHPコンテナ定義
│   └── src/
│       └── index.php        ← 試用版Webページ
├── mysql/
│   └── init/
│       └── init.sql         ← DB初期設定
├── logs/
│   ├── nginx/               ← Nginxログ保存先
│   └── mysql/               ← MySQLログ保存先
└── docs/                    ← 手順・記録ドキュメント
    ├── 00_overview.md
    ├── 01_environment.md
    └── 02_directory.md      ← 本ファイル
```

---

## 2. 実施コマンド

```bash
# フォルダを一括作成
mkdir -p nginx/conf.d php/src mysql/init logs/nginx logs/mysql

# 空ファイルを一括作成
touch docker-compose.yml .env .env.example
touch nginx/conf.d/default.conf
touch php/Dockerfile php/src/index.php
touch mysql/init/init.sql

# 確認
find . -not -path './.git/*' | sort
```

---

## 3. 各ファイル・フォルダの役割

| パス | 役割 |
|------|------|
| `docker-compose.yml` | 全コンテナの定義・ネットワーク・ボリューム設定 |
| `.env` | DB パスワード等の認証情報（Gitに含めない） |
| `.env.example` | `.env` のサンプル（Gitに含める） |
| `.gitignore` | Git管理から除外するファイルの定義 |
| `nginx/conf.d/default.conf` | Nginxのリバースプロキシ設定 |
| `php/Dockerfile` | PHPコンテナのビルド定義 |
| `php/src/index.php` | 試用版Webページ |
| `mysql/init/init.sql` | DB初期設定・テーブル定義 |
| `logs/nginx/` | Nginxアクセスログ・エラーログ保存先 |
| `logs/mysql/` | MySQLログ保存先 |

---

## 4. 確認結果

```
find . -not -path './.git/*' | sort の出力結果：

.
./.env
./.env.example
./.gitignore
./docker-compose.yml
./docs/00_overview.md
./docs/01_environment.md
./logs/mysql
./logs/nginx
./mysql/init/init.sql
./nginx/conf.d/default.conf
./php/Dockerfile
./php/src/index.php
```

| 確認項目 | 結果 |
|---------|------|
| フォルダ構成 | ✅ 正常 |
| ファイル作成 | ✅ 正常 |

---

## 6. 次のステップ

STEP 3：ネットワーク設計へ進む

---

## 7. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| YYYY-MM-DD | 初版作成 | （担当者名） |
