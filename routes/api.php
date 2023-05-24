<?php

use App\Http\Controllers\Api\QuestionApiController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());

Route::middleware([
    'OrgIsRequired',
])->prefix('_q')->name('api.question.')->group(function (?Router $router = null) {
    Route::get('{questionId}', [QuestionApiController::class, 'index'])
        ->name('show');
});
