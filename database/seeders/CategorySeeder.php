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
                'icon' => '🧠',
            ],

            [
                'name' => 'Psychology',
                'slug' => 'psychology',
                'icon' => '🧩',
            ],

            [
                'name' => 'Mystery',
                'slug' => 'mystery',
                'icon' => '🕵️',
            ],

            [
                'name' => 'Dark Facts',
                'slug' => 'dark-facts',
                'icon' => '🌑',
            ],

            [
                'name' => 'Stoic',
                'slug' => 'stoic',
                'icon' => '🏛️',
            ],

            [
                'name' => 'Space',
                'slug' => 'space',
                'icon' => '🌌',
            ],

            [
                'name' => 'AI',
                'slug' => 'ai',
                'icon' => '🤖',
            ],

            [
                'name' => 'History',
                'slug' => 'history',
                'icon' => '📜',
            ],

            [
                'name' => 'Survival',
                'slug' => 'survival',
                'icon' => '🔥',
            ],

            [
                'name' => 'Finance',
                'slug' => 'finance',
                'icon' => '💰',
            ],

            [
                'name' => 'Tech',
                'slug' => 'tech',
                'icon' => '💻',
            ],

            [
                'name' => 'Crime',
                'slug' => 'crime',
                'icon' => '🚨',
            ],

            [
                'name' => 'Nature',
                'slug' => 'nature',
                'icon' => '🍃',
            ],

            [
                'name' => 'Sleep',
                'slug' => 'sleep',
                'icon' => '🌙',
            ],

            [
                'name' => 'Focus',
                'slug' => 'focus',
                'icon' => '🎯',
            ],

            [
                'name' => 'Habits',
                'slug' => 'habits',
                'icon' => '📈',
            ],

            [
                'name' => 'Human',
                'slug' => 'human',
                'icon' => '👁️',
            ],

            [
                'name' => 'Future',
                'slug' => 'future',
                'icon' => '🚀',
            ],

            [
                'name' => 'Philosophy',
                'slug' => 'philosophy',
                'icon' => '⚖️',
            ],

            [
                'name' => 'Energy',
                'slug' => 'energy',
                'icon' => '⚡',
            ],

            [
                'name' => 'Dreams',
                'slug' => 'dreams',
                'icon' => '💭',
            ],

            [
                'name' => 'Longevity',
                'slug' => 'longevity',
                'icon' => '🧬',
            ],

            [
                'name' => 'Fitness',
                'slug' => 'fitness',
                'icon' => '🏋️',
            ],

            [
                'name' => 'Anxiety',
                'slug' => 'anxiety',
                'icon' => '🌧️',
            ],

            [
                'name' => 'Love',
                'slug' => 'love',
                'icon' => '❤️',
            ],

            [
                'name' => 'Brain',
                'slug' => 'brain',
                'icon' => '🧠',
            ],

            [
                'name' => 'Myth',
                'slug' => 'myth',
                'icon' => '🐉',
            ],

            [
                'name' => 'Cyber',
                'slug' => 'cyber',
                'icon' => '🕶️',
            ],

            [
                'name' => 'Minimal',
                'slug' => 'minimal',
                'icon' => '◻️',
            ],

            [
                'name' => 'Chaos',
                'slug' => 'chaos',
                'icon' => '🌪️',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                [
                    'slug' => $category['slug'],
                ],
                [
                    'name' => $category['name'],
                    'icon' => $category['icon'],
                ]
            );
        }
    }
}
