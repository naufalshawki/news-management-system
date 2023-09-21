<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\NewsRepositoryInterface;
use App\Http\Requests\NewsRequest;
use App\Http\Requests\UpdateRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GeneralResource;
use Illuminate\Http\Response;
use Carbon\Carbon;

class NewsController extends Controller
{
    //
    private NewsRepositoryInterface $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository) 
    {
        $this->newsRepository = $newsRepository;
    }

    public function index(Request $request){
        $limit = $request->input('limit', 10); // Default to 10 items per page
        $page = $request->input('page', 1);
        return new GeneralResource(true, 'News retrieved', $this->newsRepository->index($page,$limit));
    }

    public function store(NewsRequest $request){
        $data = $request->validated();
        $data['user'] = $request->user();
        return new GeneralResource(true, 'News created!', $this->newsRepository->store($data));
    }

    public function update(UpdateRequest $request, $id){
        $data = $request->validated();
        $data['user'] = $request->user();
        return new GeneralResource(true, 'News updated!', $this->newsRepository->update($id, $data));
    }

    public function delete($id){
        return new GeneralResource(true, 'News deleted!', $this->newsRepository->delete($id));
    }

    public function show($id){
        $data = $this->newsRepository->show($id);
        return new GeneralResource(true, 'News retrieved!', $this->newsRepository->show($id));
    }
}
