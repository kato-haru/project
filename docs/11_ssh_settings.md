# 11. SSH設定

## 実施日
2026-03-23

## 担当者
h-kato

---

## 1. 概要

SSH接続を公開鍵認証のみに限定し、3名のアクセスを設定した。

| 対象者 | 役割 | 鍵ファイル |
|--------|------|-----------|
| h-kato | 管理者 | id_ed25519_hkato |
| NKさん | アクセス許可ユーザー1 | id_ed25519_nk |
| 義さん | アクセス許可ユーザー2 | id_ed25519_yoshisan |

---

## 2. 実施手順

### 2-1. SSH鍵の作成

```bash
# NKさん用
ssh-keygen -t ed25519 -C "nk" -f ~/.ssh/id_ed25519_nk

# 義さん用
ssh-keygen -t ed25519 -C "yoshisan" -f ~/.ssh/id_ed25519_yoshisan

# h-kato（管理者）用
ssh-keygen -t ed25519 -C "h-kato" -f ~/.ssh/id_ed25519_hkato
```

### 2-2. authorized_keysの設定

```bash
touch ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
cat ~/.ssh/id_ed25519_hkato.pub >> ~/.ssh/authorized_keys
cat ~/.ssh/id_ed25519_nk.pub >> ~/.ssh/authorized_keys
cat ~/.ssh/id_ed25519_yoshisan.pub >> ~/.ssh/authorized_keys
```

### 2-3. SSHサーバー設定（/etc/ssh/sshd_config）

```
PasswordAuthentication no   ← パスワード認証を無効化
PermitRootLogin no          ← rootログインを禁止
PubkeyAuthentication yes    ← 公開鍵認証を有効化
```

### 2-4. SSHサーバー起動

```bash
sudo service ssh start
```

---

## 3. 接続テスト結果

| 対象者 | 結果 |
|--------|------|
| h-kato | ✅ 接続成功 |
| NKさん | ✅ 接続成功 |
| 義さん | ✅ 接続成功 |

---

## 4. セキュリティ注意事項

| 項目 | 内容 |
|------|------|
| 秘密鍵の受け渡し | USB等の安全な方法で渡す（メール禁止） |
| パスフレーズ変更 | 受け取り後、各自でパスフレーズを変更する |
| 秘密鍵の管理 | 各自のPCで厳重に管理する |

---

## 5. 残り作業

| 作業 | 状態 |
|------|------|
| 秘密鍵の受け渡し方法決定 | ⬜ 未実施 |
| NKさん・義さんへの秘密鍵受け渡し | ⬜ 未実施 |
| 各自パスフレーズ変更 | ⬜ 未実施 |
| 本番サーバーへのSSH設定 | ⬜ 未実施 |

---

## 6. 変更履歴

| 日付 | 変更内容 | 担当者 |
|------|---------|--------|
| 2026-03-23 | 初版作成・SSH設定完了 | h-kato |
