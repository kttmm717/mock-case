<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;


class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
            'item_name' => '腕時計',
            'brand_name' => 'Chrono',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'price' => 15000,
            'item_description' => 'スタイリッシュなデザインのメンズ腕時計',
            'category_ids' => [1,2],
            'condition_id' => 1,
            ],
            [
            'item_name' => 'HDD',
            'brand_name' => 'DataMax',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'price' => 5000,
            'item_description' => '高速で信頼性の高いハードディスク',
            'category_ids' => [4,9],
            'condition_id' => 2,
            ],
            [
            'item_name' => '玉ねぎ3束',
            'brand_name' => 'FreshOnion',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'price' => 300,
            'item_description' => '新鮮な玉ねぎ3束のセット',
            'category_ids' => [4,6],
            'condition_id' => 3,
            ],
            [
            'item_name' => '革靴',
            'brand_name' => 'Regal',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'price' => 4000,
            'item_description' => 'クラシックなデザインの革靴',
            'category_ids' => [2,5],
            'condition_id' => 4,
            ],
            [
            'item_name' => 'ノートPC',
            'brand_name' => 'TechNote',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'price' => 45000,
            'item_description' => '高性能なノートパソコン',
            'category_ids' => [1],
            'condition_id' => 1,
            ],
            [
            'item_name' => 'マイク',
            'brand_name' => 'ClearMic',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'price' => 8000,
            'item_description' => '高音質のレコーディング用マイク',
            'category_ids' => [2,5,7],
            'condition_id' => 2,
            ],
            [
            'item_name' => 'ショルダーバッグ',
            'brand_name' => 'UrbanBag',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'price' => 3500,
            'item_description' => 'おしゃれなショルダーバッグ',
            'category_ids' => [9,10],
            'condition_id' => 3,
            ],
            [
            'item_name' => 'タンブラー',
            'brand_name' => 'SipCup',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'price' => 500,
            'item_description' => '使いやすいタンブラー',
            'category_ids' => [3,11],
            'condition_id' => 4,
            ],
            [
            'item_name' => 'コーヒーミル',
            'brand_name' => 'Grind',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'price' => 4000,
            'item_description' => '手動のコーヒーミル',
            'category_ids' => [4,5,6],
            'condition_id' => 1,
            ],
            [
            'item_name' => 'メイクセット',
            'brand_name' => 'Glow',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'price' => 2500,
            'item_description' => '便利なメイクアップセット',
            'category_ids' => [8,13],
            'condition_id' => 2,
            ]
        ];
        
        foreach($items as $item) {
            $newItem = Item::create([
                'user_id' => 1,
                'item_name' => $item['item_name'],
                'brand_name' => $item['brand_name'],
                'image' => $item['image'], 
                'price' => $item['price'],
                'item_description' => $item['item_description'],
                'condition_id' => $item['condition_id'],
            ]);
            $newItem->categories()->attach($item['category_ids']);
        }
    }
}
