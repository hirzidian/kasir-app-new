<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FacadesDB::table('products')->insert([
            [
                'name' => 'Laptop Kerja',
                'price' => 20000,
                'stock' => 12,
                'image' => 'storage/product/laptop-1.jpeg',
            ],
            [
                'name' => 'Laptop Gaming',
                'price' => 8000,
                'stock' => 100,
                'image' => 'storage/product/laptop-2.jpeg',
            ],
            [
                'name' => 'HP Gaming',
                'price' => 2000,
                'stock' => 72,
                'image' => 'storage/product/hp-1.jpeg',
            ],
            [
                'name' => 'HP Samsung',
                'price' => 2000,
                'stock' => 24,
                'image' => 'storage/product/hp-2.jpeg',
            ],
            [
                'name' => 'HP Iphone',
                'price' => 5230,
                'stock' => 10,
                'image' => 'storage/product/hp-3.jpeg',
            ],
        ]);
    }
}
