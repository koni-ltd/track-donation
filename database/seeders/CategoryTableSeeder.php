<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => '医療・福祉'],
            ['name' => '開発'],
            ['name' => '環境'],
            ['name' => '国際協力'],
            ['name' => '教育・研究'],
            ['name' => 'こども'],
            ['name' => '災害・復興支援'],
            ['name' => '地域活性'],
            ['name' => '動物・ペット'],
            ['name' => '文化・スポーツ'],
            ['name' => 'その他'],
        ];

        DB::table('categories')->insert($categories);
    }
}
