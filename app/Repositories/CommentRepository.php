<?php

namespace App\Repositories;

use App\Models\News;
use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use App\Events\NewsLogging;
use App\Jobs\InsertCommentJob;
use DB;

class CommentRepository implements CommentRepositoryInterface
{


    public function store($input) {
        $userId = $input['user']['id'];
        $username = $input['user']['name'];
        $newsId = $input['news_id'];
        $content = $input['content'];
        $data = [
            'user_id' => $userId,
            'user_name' => $username,
            'news_id' => $newsId,
            'content' => $content,
        ];

        dispatch(new InsertCommentJob($data));
        return $input;
    }
}

