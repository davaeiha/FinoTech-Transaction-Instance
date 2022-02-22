<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\FinoTech\ReportService;
use App\Http\Controllers\Controller;
use App\Models\Bank\Account;
use App\Models\Bank\Bank;
use App\Models\User;
use App\Trait\HasRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use HasRequest;

    public function report(Request $request,User $user,Account $account){
        $validatedData = $request->validate([
            'fromDate'=>'required|date_format:Y-m-d',
            'toDate'=>'required|date_format:Y-m-d',
            'offset'=>'integer',
            'length'=>'integer|max:20'
        ]);

        $report = new ReportService($this->trackId,$user->finotech_token);

        $result = $report->report($this->client->id,$account->sheba_no,$validatedData);

        return \response()->json([
            'result'=>$result,
            'statues'=>'DONE',
            'trackId'=>$this->trackId
        ],200);
    }
}
