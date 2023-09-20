<?php

namespace App\Repositories;

use App\Models\News;
use App\Interfaces\NewsRepositoryInterface;
use App\Models\Comment;
use App\Events\NewsLogging;
use DB;

class NewsRepository implements NewsRepositoryInterface
{

    public function index($page, $limit){
        $news = News::paginate($limit, ['*'], 'page', $page);
        return $news;
    }

    public function store($input) {
        DB::beginTransaction();
        try {
            $file = $input['image'];
            // Generate a unique name for the file
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            // Store the file in the storage/app/news directory
            $file->storeAs('news', $fileName);
            $new_data = new News();
            $new_data->title = $input['title'];
            $new_data->content = $input['content'];
            $new_data->author = $input['user']['name'];
            $new_data->image = $fileName;
            $new_data->save();
            $log['action'] = 'Create data';
            $log['title'] = $input['title'];
            event(new NewsLogging($log));
            DB::commit();
            return $new_data;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function update($id, $input) {
        DB::beginTransaction();
        try {
            $checkExists = News::findOrFail($id);
            if($input['image']) {
                $file = $input['image'];
                // Generate a unique name for the file
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                // Store the file in the storage/app/news directory
                $file->storeAs('news', $fileName);
                $checkExists->image = $fileName;
            }
            if($input['title']) {
                $checkExists->title = $input['title'];
            }
            if($input['content']) {
                $checkExists->content = $input['content'];
            }
            $checkExists->save();
            $log['action'] = 'Update data';
            $log['title'] = $checkExists->title;
            event(new NewsLogging($log));
            DB::commit();
            return $checkExists;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

    public function delete($id) {
        $news = News::find($id);
        if ($news) {
            $news->delete();
        }
        $log['action'] = 'Delete data';
        $log['title'] = $news->title;
        event(new NewsLogging($log));
        return $news;
    }

    public function show($id) {
        $news = News::with('comments.user')->find($id);
        if(!$news){
            return null;
        }
        return $news;
    }
}

