<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        $f = $this->faker;

        // お問い合わせ内容は自然な日本語の定型文からランダムに選ぶ
        $samples = [
            '商品が届かないため、配送状況を確認したいです。',
            '注文内容と異なる商品が届きました。交換を希望します。',
            'サイズが合わないため返品したいです。',
            '支払い方法の変更は可能でしょうか。',
            'その他の問い合わせです。よろしくお願いします。',
            
        ];

        return [
            'last_name'    => $f->lastName(),
            'first_name'   => $f->firstName(),
            'gender'       => $f->randomElement([1, 2, 3]),
            'email'        => $f->unique()->safeEmail(),
            'tel'          => '0' . $f->numerify('##########'),
            'address'      => $f->prefecture() . ' ' . $f->city() . ' ' . $f->streetAddress(),
            'building'     => $f->optional(0.5)->secondaryAddress(),
            'category_id'  => $f->numberBetween(1, 5),
            'detail'       => $f->randomElement($samples),   // ←ここをサンプル文から
            'created_at'   => $f->dateTimeBetween('-60 days', 'now'),
            'updated_at'   => now(),
        ];
    }
}
