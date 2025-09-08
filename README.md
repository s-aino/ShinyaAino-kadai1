# お問い合わせフォーム

## 概要

Docker 上で動く Laravel 製のお問い合わせフォームです。Fortify による認証、バリデーション、確認画面、管理（検索・ページネーション・CSV エクスポート）までを実装しています。

## 機能

お問い合わせフォーム（入力 → 確認 → 送信）

バリデーション（氏名/メール/電話/住所/詳細 など、詳細は 120 文字まで）

認証（Laravel Fortify）

管理画面 /admin

キーワード（姓・名・フルネーム・メール）検索

性別・カテゴリ・作成日 での絞り込み

7件/ページのページネーション

絞り込み後の結果をそのまま CSV エクスポート

詳細モーダル（確認・削除）

## 環境構築
**Dockerビルド**
1. `git clone git@github.com:Estra-Coachtech/laravel-docker-template.git`
2. DockerDesktopアプリを立ち上げる
3. `docker compose up -d --build`

## 使用技術

- PHP **8.1** 
- Laravel **10.x**
- MySQL **8.0**

## Laravel環境構築
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

5. マイグレーションの実行
``` bash
php artisan migrate
```

6. シーディングの実行
``` bash
php artisan db:seed
```

## ルーティング情報
| Method | URI              | Name            | Middleware |
| ------ | ---------------- | --------------- | ---------- |
| GET    | /                | home            | web        |
| GET    | /contact         | contact.create  | web        |
| POST   | /contact/confirm | contact.confirm | web        |
| POST   | /contact         | contact.store   | web        |
| GET    | /thanks          | thanks          | web        |
| GET    | /login           | login           | guest      |
| GET    | /register        | register        | guest      |
| GET    | /admin           | admin.index     | **auth**   |
| GET    | /admin/{contact} | admin.show      | **auth**   |
| DELETE | /admin/{contact} | admin.destroy   | **auth**   |
| GET    | /admin/export    | admin.export    | **auth**   |

## DB テーブル仕様（要約）

**contacts**

- id (bigint, PK)

- last_name (string) / first_name (string)

- gender (tinyint) … 1:男性 / 2:女性 / 3:その他

- email (string)

- tel (string)

- address (string)

- building (string, nullable)

- category_id (bigint, FK → categories.id)

- detail (string, max 120)

- created_at / updated_at (timestamps)

**categories**

- id (bigint, PK)
- content (string) 
- timestamps
```
（Seeder で 5 件: 「商品の届けについて / 商品の交換について / 商品トラブル / ショップへのお問い合わせ / その他」）を投入。
重複防止のため firstOrCreate を使用。
```

**users**

- id, 
- name, 
- email, 
- password, 
- timestamps

## バリデーションのルール

姓 / 名: required|string|max:255

性別: required|in:1,2,3

メール: required|email|max:255

電話番号: required|regex:/^0\d{9,10}$/

住所: required|string|max:255

建物名: nullable|string|max:255

お問い合わせ種別: required|exists:categories,id

お問い合わせ内容: required|string|max:120

## ダミーデータ（シーディング）ルール

categories … 上記 5 件を Seeder で投入

contacts … Factory + Faker（ja_JP）で 35 件生成（氏名・住所・電話・メール・性別はランダム、detail は 120 文字以内）


## ER図
- ER 図: [docs/ERD.md](docs/ERD.md)

## URL
- 開発環境：http://localhost:
- ログイン: http://localhost/login
- 登録: http://localhost/register
- 管理: http://localhost/admin
- phpMyAdmin: http://localhost:8080