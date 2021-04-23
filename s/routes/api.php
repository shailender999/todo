<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::post('login',[AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:api','cors'])->group(function () {
    Route::get('user', function () {
        $user = request()->user();
        return response()->json(['data' => array('name'=> $user->name)],200);
    });
    Route::get('logout', function() {
        $user = Auth::guard('api')->user()->token();
        $user->revoke();
        return response()->json(['status'=>'Success'],200);
    });
    Route::get('todos',[TaskController::class, 'allTodos']);
    Route::post('todos',[TaskController::class, 'createTodo']);
    Route::patch('todos/{id}',[TaskController::class, 'toggleTodo']);
    Route::delete('todos/{id}',[TaskController::class, 'deleteTodo']);
});

//Route::get()
