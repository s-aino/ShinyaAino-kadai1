# Laravel 確認テスト１
<!-- <課題内容が判明したらここに記述する>　 -->



## 環境構築
**Dockerビルド**
1. `git clone git@github.com:Estra-Coachtech/laravel-docker-template.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

**Laravel環境構築**
1. `docker-compose exec php bash`
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
