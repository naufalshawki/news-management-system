<?php
 
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController as Auth;
use App\Http\Controllers\NewsController as News;
use App\Http\Controllers\CommentController as Comment;
 
/* 
|-------------------------------------------------------------------------- 
| API Routes 
|-------------------------------------------------------------------------- 
| 
| Here is where you can register API routes for your application. These 
| routes are loaded by the RouteServiceProvider within a group which 
| is assigned the "api" middleware group. Enjoy building your API! 
| 
*/
 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 
// custom API route 
Route::middleware('auth:api')->get('/user/get', 'UserController@get');

Route::group([
    'prefix' => 'auth'
], function () {
     Route::post('login', [Auth::class, 'login'])->name('login');
     Route::post('register', [Auth::class,'register']);
     Route::group([
        'middleware' => 'auth:api'
      ], function() {
            Route::get('logout', [Auth::class, 'logout']);
            Route::get('user', [Auth::class, 'user']);
   });
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'news'
  ], function() {
        Route::get('/', [News::class, 'index']);
        Route::post('/', [News::class, 'store'])->middleware('role:admin');;
        Route::post('/{id}', [News::class, 'update'])->middleware('role:admin');;
        Route::delete('/{id}', [News::class, 'delete'])->middleware('role:admin');;
        Route::get('/{id}', [News::class, 'show']);
        Route::post('/comment/add', [Comment::class, 'store']);
});