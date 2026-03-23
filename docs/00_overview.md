### 2-1. システム要件確認
確認結果：Windows 11 25H2

| 確認項目 | 必要条件 | 結果 |
|---------|---------|------|
| Windowsバージョン | Win10 ビルド19041以上 / Win11 | ✅ Windows 11 25H2 |
| システム要件 | 満たしている / 満たしていない | ✅ 満たしている |
```

---

## 次のアクション

STEP 1 の残り作業に進みます。
```
✅ 2-1. Windowsバージョン確認 → 完了（25H2）
⬜ 2-2. WSL2 インストール
⬜ 2-3. Docker Desktop インストール
⬜ 2-4. Docker Desktop 初期設定
⬜ 2-5. VSCode 拡張機能インストール
⬜ 2-6. インストール確認（バージョン記録）
### 2-2. WSL2 インストール

| 確認項目 | 結果 |
|---------|------|
| WSL2インストール | ✅ インストール済み |
| WSL バージョン | 2.5.7.0 |
| カーネル バージョン | 6.6.87.1-1 |
| PC再起動 | 不要（インストール済みのため） |
```

---

## 進捗状況
```
✅ 2-1. Windowsバージョン確認 → Windows 11 25H2
✅ 2-2. WSL2 インストール     → v2.5.7.0 確認済み
⬜ 2-3. Docker Desktop インストール   ← 次はここ
⬜ 2-4. Docker Desktop 初期設定
⬜ 2-5. VSCode 拡張機能インストール
⬜ 2-6. インストール確認（バージョン記録）
```

---

## 次のアクション：Docker Desktop インストール

以下のURLからDocker Desktopをダウンロードしてください。
```
https://www.docker.com/products/docker-desktop/
```

**インストール手順**
```
① 上記URLにアクセス
② 「Download for Windows」をクリック
③ ダウンロードした「Docker Desktop Installer.exe」を実行
④ インストール設定画面で以下を確認：
   ✅ Use WSL 2 instead of Hyper-V
   ✅ Add shortcut to desktop（任意）
⑤ 「Ok」でインストール開始
⑥ 完了後「Close and restart」でPC再起動

### 2-6. インストール確認（バージョン記録）

| 確認項目 | バージョン / 結果 |
|---------|----------------|
| Docker バージョン | 29.2.1 |
| Docker Compose バージョン | v5.1.0 |
| hello-world 動作確認 | 成功 |