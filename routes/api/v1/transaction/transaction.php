<?php


use App\Http\Controllers\Api\V1\Transaction\InquiryController;
use App\Http\Controllers\Api\V1\Transaction\ReportController;
use App\Http\Controllers\Api\V1\Transaction\TransactionController;
use Illuminate\Support\Facades\Route;

//transaction
Route::post('transaction',[TransactionController::class,'transaction'])->middleware('scope:transfer-to-execute');

//get inquiry of Paya and Internal transactions
//scope confirmed inside the method
Route::get('transaction/{transaction}/Inquiry',[InquiryController::class,'inquiry']);

//get report of Paya transactions
Route::get('user/{user}/transactions/account/{account}',[ReportController::class,'report'])->middleware('scope:payas-get');
