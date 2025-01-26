<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            [
                'comment' => 'This is a comment',
                'post_id' => 1,
            ],
            [
                'comment' => 'This is another comment',
                'post_id' => 1,
            ],
            [
                'comment' => 'This is a third comment',
                'post_id' => 1,
            ],
            [
                'comment' => 'This is a comment',
                'post_id' => 1,
            ],
            [
                'comment' => 'This is another comment',
                'post_id' => 3,
            ],
            [
                'comment' => 'This is a third comment',
                'post_id' => 3,
            ],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}
