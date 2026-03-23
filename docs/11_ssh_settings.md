# 11. SSH設定

## 実施日
2026-03-23

## 担当者
h-kato

---

## 1. 概要

SSH接続を公開鍵認証のみに限定し、2名のアクセスを設定。

| 対象者 | 役割 |
|--------|------|
| NKさん | アクセス許可ユーザー1 |
| 義さん | アクセス許可ユーザー2 |

> ⚠️ h-katoは管理者としてサーバーを管理するが
> SSH対象者には含めない（直接ログインで管理）

---

## 2. 正しい鍵運用方針

```
❌ 非推奨（今回の試用版で実施した方法）
サーバー側で ssh-keygen を実行
→ 秘密鍵をサーバーに置いたまま渡す

✅ 本番での正しい方法
各自のPCで ssh-keygen を実行
→ 公開鍵（.pub）だけをサーバーに登録
→ 秘密鍵は各自のPCのみに保管
```

---

## 3. 本番での正しい運用フロー

```
① NKさん・義さんが自分のPCで鍵を作成
   ssh-keygen -t ed25519 -C "nk"
         ↓
② 公開鍵（.pub）をh-katoに共有
   （メール・チャットでの送付はOK）
         ↓
③ h-katoがサーバーのauthorized_keysに登録
   cat nk.pub >> ~/.ssh/authorized_keys
         ↓
④ 秘密鍵は各自のPCのみで管理
   （サーバー側に秘密鍵は置かない）
```

---

## 4. 試用版での実施内容

### 4-1. SSH鍵の作成（試用版・暫定対応）

```bash
# NKさん用（試用版のみ・本番では各自のPCで作成）
ssh-keygen -t ed25519 -C "nk" -f ~/.ssh/id_ed25519_nk

# 義さん用（試用版のみ・本番では各自のPCで作成）
ssh-keygen -t ed25519 -C "yoshisan" -f ~/.ssh/id_ed25519_yoshisan
```

### 4-2. authorized_keysの設定

```bash
# 2名分の公開鍵を登録
cat ~/.ssh/id_ed25519_nk.pub > ~/.ssh/authorized_keys
cat ~/.ssh/id_ed25519_yoshisan.pub >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

### 4-3. SSHサーバー設定（/etc/ssh/sshd_config）

```
PasswordAuthentication no   ← パスワード認証を無効化
PermitRootLogin no          ← rootログインを禁止
PubkeyAuthentication yes    ← 公開鍵認証を有効化
```

### 4-4. SSHサーバー起動

```bash
sudo service ssh start
sudo service ssh status
# → Active: active (running) ✅
```

---

## 5. 接続テスト結果

| 対象者 | 結果 |
|--------|------|
| NKさん | ✅ 接続成功 |
| 義さん | ✅ 接続成功 |

---

## 6. 秘密鍵の受け渡し（試用版・暫定）

| 項目 | 内容 |
|------|------|
| 受け渡し方法 | 未決定（要検討） |
| 推奨方法 | USB等の安全な方法（メール禁止） |
| 受け取り後 | 各自でパスフレーズを変更する |

---

## 7. 本番サーバーでの対応事項

| 作業 | 状態 |
|------|------|
| 各自PCでの鍵作成（NKさん・義さん） | ⬜ 未実施 |
| 公開鍵のサーバー登録 | ⬜ 未実施 |
| AllowUsersの設定 | ⬜ 未実施 |
| ファイアウォールでSSHポート制限 | ⬜ 未実施 |

---

## 8. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成・SSH設定完了 | h-kato |
| 2026-03-23 | ChatGPTレビュー指摘を受け修正（SSH運用方針・対象者2名に統一） | h-kato |
