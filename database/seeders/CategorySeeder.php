<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = [

            [
                'name' => 'Mindset',
                'slug' => 'mindset',
                'thumbnail' => '🧠',
            ],

            [
                'name' => 'Psychology',
                'slug' => 'psychology',
                'thumbnail' => '🧩',
            ],

            [
                'name' => 'Mystery',
                'slug' => 'mystery',
                'thumbnail' => '🕵️',
            ],

            [
                'name' => 'Dark Facts',
                'slug' => 'dark-facts',
                'thumbnail' => '🌑',
            ],

            [
                'name' => 'Stoic',
                'slug' => 'stoic',
                'thumbnail' => '🏛️',
            ],

            [
                'name' => 'Space',
                'slug' => 'space',
                'thumbnail' => '🌌',
            ],

            [
                'name' => 'AI',
                'slug' => 'ai',
                'thumbnail' => '🤖',
            ],

            [
                'name' => 'History',
                'slug' => 'history',
                'thumbnail' => '📜',
            ],

            [
                'name' => 'Survival',
                'slug' => 'survival',
                'thumbnail' => '🔥',
            ],

            [
                'name' => 'Finance',
                'slug' => 'finance',
                'thumbnail' => '💰',
            ],

            [
                'name' => 'Tech',
                'slug' => 'tech',
                'thumbnail' => '💻',
            ],

            [
                'name' => 'Crime',
                'slug' => 'crime',
                'thumbnail' => '🚨',
            ],

            [
                'name' => 'Nature',
                'slug' => 'nature',
                'thumbnail' => '🍃',
            ],

            [
                'name' => 'Sleep',
                'slug' => 'sleep',
                'thumbnail' => '🌙',
            ],

            [
                'name' => 'Focus',
                'slug' => 'focus',
                'thumbnail' => '🎯',
            ],

            [
                'name' => 'Habits',
                'slug' => 'habits',
                'thumbnail' => '📈',
            ],

            [
                'name' => 'Human',
                'slug' => 'human',
                'thumbnail' => '👁️',
            ],

            [
                'name' => 'Future',
                'slug' => 'future',
                'thumbnail' => '🚀',
            ],

            [
                'name' => 'Philosophy',
                'slug' => 'philosophy',
                'thumbnail' => '⚖️',
            ],

            [
                'name' => 'Energy',
                'slug' => 'energy',
                'thumbnail' => '⚡',
            ],

            [
                'name' => 'Dreams',
                'slug' => 'dreams',
                'thumbnail' => '💭',
            ],

            [
                'name' => 'Longevity',
                'slug' => 'longevity',
                'thumbnail' => '🧬',
            ],

            [
                'name' => 'Fitness',
                'slug' => 'fitness',
                'thumbnail' => '🏋️',
            ],

            [
                'name' => 'Anxiety',
                'slug' => 'anxiety',
                'thumbnail' => '🌧️',
            ],

            [
                'name' => 'Love',
                'slug' => 'love',
                'thumbnail' => '❤️',
            ],

            [
                'name' => 'Brain',
                'slug' => 'brain',
                'thumbnail' => '🧠',
            ],

            [
                'name' => 'Myth',
                'slug' => 'myth',
                'thumbnail' => '🐉',
            ],

            [
                'name' => 'Cyber',
                'slug' => 'cyber',
                'thumbnail' => '🕶️',
            ],

            [
                'name' => 'Minimal',
                'slug' => 'minimal',
                'thumbnail' => '◻️',
            ],

            [
                'name' => 'Chaos',
                'slug' => 'chaos',
                'thumbnail' => '🌪️',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                [
                    'slug' => $category['slug'],
                ],
                [
                    'name' => $category['name'],
                    'thumbnail' => $category['thumbnail'],
                ]
            );
        }
    }
}
