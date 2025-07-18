<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/users',[UserController::class,'register']);
Route::post('/users/login',[UserController::class,'login']);

Route::middleware(ApiAuthMiddleware::class)->group(function(){
    Route::get('/users/current',[ UserController::class,'get']);
    Route::delete('/users/logout',[UserController::class,'logout']);
    //profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'store']);
    Route::post('/profile/update', [ProfileController::class, 'update']);

    //project
    Route::get('/project',[ProjectController::class,'get']);
    Route::get('/project/{project}',[ProjectController::class,'show']);
    Route::post('/project',[ProjectController::class,'store']);
    Route::post('/project/{project}',[ProjectController::class,'update']);
    Route::delete('/project/{project}',[ProjectController::class,'destroy']);

    //experience
    Route::get('/experience',[ExperienceController::class,'get']);
    Route::get('/experience/{experience}',[ExperienceController::class,'show']);
    Route::post('/experience',[ExperienceController::class,'store']);
    Route::patch('/experience/{experience}',[ExperienceController::class,'update']);
    Route::delete('/experience/{experience}',[ExperienceController::class,'destroy']);

    //education
    Route::get('/education',[EducationController::class,'get']);
    Route::get('education/{education}',[EducationController::class,'show']);
    Route::post('/education',[EducationController::class,'store']);
    Route::patch('/education/{education}',[EducationController::class,'update']);
    Route::delete('/education/{education}',[EducationController::class,'destroy']);

    //certifikasi
    Route::get('/certificate',[CertificateController::class,'get']);
    Route::get('/certificate/{certificate}',[CertificateController::class,'show']);
    Route::post('/certificate',[CertificateController::class,'store']);
    Route::post('/certificate/{certificate}',[CertificateController::class,'update']);
    Route::delete('/certificate/{certificate}',[CertificateController::class,'destroy']);
});
