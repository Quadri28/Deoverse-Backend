<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/send-message', [MessageController::class, 'create']);
Route::get('/users', [AuthController::class, 'user']);

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/messages', MessageController::class);
    Route::patch('confirm-user/{id}', function(Request $request, $id) {
        $user = User::findOrFail($id);
        $input = $request->all();
        $user->is_confirmed = $input['is_confirmed'];
        $user->save();
        return response()->json($user);
    });
    Route::get('/all-messages', [MessageController::class, 'getAllMessages']);
});
