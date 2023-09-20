<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CommentRepositoryInterface;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GeneralResource;
use Illuminate\Http\Response;
use Carbon\Carbon;

class CommentController extends Controller
{
    //
    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository) 
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(CommentRequest $request){
        $data = $request->validated();
        $data['user'] = $request->user();
        return new GeneralResource(true, 'Comment Posted!', $this->commentRepository->store($data));
    }

}
