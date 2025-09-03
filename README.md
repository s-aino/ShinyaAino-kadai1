# Laravel 確認テスト１
<!-- <課題内容が判明したらここに記述する>　 -->



## 環境構築
**Dockerビルド**
1. `git clone git@github.com:Estra-Coachtech/laravel-docker-template.git`
2. DockerDesktopアプリを立ち上げる
3. `docker compose up -d --build`

**Laravel環境構築**
1. `docker compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを コピーして「.env」を作成し、DBの設定を変更
``` ini
DB_HOST=mysql
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

4. アプリケーションキーの作成
``` bash
php artisan key:generate
```

<!-- 5. マイグレーションの実行
``` bash
php artisan migrate
```

6. シーディングの実行
``` bash
php artisan db:seed
``` -->

## ER図
- ER 図: [docs/ERD.md](docs/ERD.md)

## URL
- 開発環境：http://localhost:
- phpMyAdmin:：http://localhost:8080

## 進行チェックリスト（提出までの最短ルート）
## 0. 環境 & 初期化 ✅
- [ ] リポジトリ作成（`main` にコミット）
- [ ] `docker compose up -d --build` で起動
- [ ] `docker compose exec php bash` で PHP コンテナに入る
- [ ] `composer install`
- [ ] `.env` 作成 → `APP_KEY` 生成 → DB 接続値設定
- [ ] `php artisan migrate --seed` 実行（カテゴリ＋ダミーデータ投入）

## 1. モデル / マイグレーション ✅
- [ ] `categories` / `contacts` / `users` のテーブル作成（スネークケース・複数形）
- [ ] `contacts.category_id` → `categories.id` 外部キー
- [ ] `Contact` に `category()`（belongsTo） を定義

## 2. お問い合わせフォーム（入力） ✅
- [ ] ルート `GET /` → `ContactController@create`
- [ ] `ContactRequest`（FormRequest）作成：必須 / 形式 / 120 文字など
- [ ] Blade：姓・名分割、**性別デフォルト=男性**、カテゴリは「選択してください」初期表示
- [ ] 送信ボタンで `POST /confirm`

## 3. 確認画面 ✅
- [ ] `POST /confirm` で `session('contact')` に格納
- [ ] 表示：**姓（全角スペース）名**、性別1/2/3→表記変換、改行は `nl2br`
- [ ] 「修正」で `/` に戻り、入力値を `old(..., session(...))` で復元
- [ ] 「送信」で `POST /thanks`

## 4. サンクスページ ✅
- [ ] `store()` で保存後、`session()->forget('contact')`
- [ ] **PRG**（任意）：`redirect()->route('contact.thanks')` にして GET `/thanks` を返す
- [ ] HOME ボタンで `/` へ

## 5. 認証（Fortify） ✅
- [ ] Fortify 導入、ビュー登録：`login` / `register`
- [ ] `LoginRequest` / `RegisterRequest` を作成し日本語メッセージ
- [ ] ログイン後の遷移先：`RouteServiceProvider::HOME = '/admin'`
- [ ] `/admin` を `auth` ミドルウェアで保護

## 6. 管理画面（一覧・検索） ✅
- [ ] ルート：`GET /admin` → Admin\ContactController@index
- [ ] 検索条件：q（姓/名/フルネーム/メール）, 性別（全て/1/2/3）, カテゴリ, 日付
- [ ] 7件/ページで `->paginate(7)->withQueryString()`
- [ ] テーブル表示：お名前 / 性別 / メール / 種類 / 詳細ボタン

## 7. 詳細表示（モーダル or 別ページ） ✅
- [ ] `GET /admin/contacts/{id}` で詳細を取得
- [ ] モーダル（AJAXで部分ビュー注入）**または** 別ページ表示
- [ ] 削除ボタン（`DELETE /admin/contacts/{id}`）

## 8. CSV エクスポート ✨
- [ ] `GET /admin/contacts/export` を追加
- [ ] 現在の検索条件を反映し CSV 出力（UTF-8 BOM）

## 9. README 仕上げ & 提出 ✅
- [ ] URL / 使用技術 / 環境構築 / ER 図 / 画面一覧 / 認証 / 管理画面 / お問い合わせフロー を記載
- [ ] スクショや ER 図画像を貼る（`docs/` 配下など）
- [ ] 提出 URL からリポジトリを登録（`main` を提出）

## 10. 動作確認 ✅
- [ ] 入力：必須エラーが各項目下に日本語表示される
- [ ] 確認：姓と名の間に全角スペース、性別表記変換、修正で値が復元
- [ ] 送信：DB にレコード作成 → サンクス → HOME でトップへ
- [ ] 認証：登録 → ログイン → `/admin` 表示
- [ ] 管理：検索（q/性別/カテゴリ/日付）が効く、ページネーション7件
- [ ] （任意）詳細モーダルで削除、CSV エクスポートが動作

---

### 便利コマンド（控え）
```bash
# PHP コンテナへ
docker compose exec php bash

# DB まるっとやり直し
php artisan migrate:fresh --seed

# キャッシュ関連
php artisan optimize:clear
```
