<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 外部キー制約が厳しいDBなら一時解除（MySQL想定）
        // \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // \App\Models\Category::truncate();
        // \App\Models\Contact::truncate();
        // \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1) カテゴリ投入（先）
        $this->call(CategorySeeder::class);

        // 2) 連絡先を35件
        Contact::factory()->count(35)->create();
    }
}
