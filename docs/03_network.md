# 03. ネットワーク設計

## 実施日
2026-03-23

## 担当者
h-kato

---

## 1. ネットワーク構成

```
インターネット
      ↓
   [Nginx コンテナ]     ← 外部公開（ポート80）
      ↓ web_network
   [PHP-FPM コンテナ]   ← 内部通信のみ
      ↓ db_network
   [MySQL コンテナ]     ← 外部完全遮断（internal: true）
```

---

## 2. ネットワーク定義

| ネットワーク名 | 種別 | 外部公開 | 接続コンテナ |
|--------------|------|---------|------------|
| `web_network` | bridge | ✅ あり（80のみ） | Nginx・PHP-FPM |
| `db_network` | bridge（internal） | ❌ 完全遮断 | PHP-FPM・MySQL |

---

## 3. docker-compose.yml ネットワーク設定

```yaml
networks:
  web_network:
    driver: bridge
  db_network:
    driver: bridge
    internal: true
```

---

## 4. 確認結果

| 確認項目 | 結果 |
|---------|------|
| web_network作成 | ✅ 正常 |
| db_network作成（internal） | ✅ 正常 |
| DB外部遮断確認 | ✅ 3306番ポート外部非公開 |

---

## 5. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成 | h-kato |
