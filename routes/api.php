<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ContactGroupContactsController;
use App\Http\Controllers\Api\ContactGroupController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);


Route::middleware(['auth:sanctum'])->group(function () {

    Route::delete('logout',[AuthController::class,'logout']);
    Route::get('user',[AuthController::class,'userInfo']);
    Route::resource('contactGroups',ContactGroupController::class);
    Route::post('contactGroup/{contactGroupId}/contact',[ContactGroupContactsController::class,'store']);
    Route::get('contactGroup/{contactGroupId}/contacts',[ContactGroupContactsController::class,'getContacts']);
    Route::get('contactGroup/{contactGroupId}/contact/{contactId}',[ContactGroupContactsController::class,'getContactDetails']);
    Route::delete('contactGroup/{contactGroupId}/contact/{contactId}',[ContactGroupContactsController::class,'destroy']);
    Route::put('contactGroup/{contactGroupId}/contact/{contactId}',[ContactGroupContactsController::class,'update']);
});
