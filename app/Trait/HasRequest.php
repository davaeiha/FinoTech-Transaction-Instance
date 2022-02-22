<?php
namespace App\Trait;

use App\Models\Client\Client;
use Illuminate\Support\Facades\DB;

trait HasRequest {
    protected string $trackId;
    protected Client $client;
    /**
     * generate track id
     *
     * @return void
     */
    protected function generateTrackId($sourceUser){
        $client = new Client();
        $this->client = $client;
        $client->users()->attach($sourceUser->id);

        $clientUser = DB::table('client_user')
            ->where('client_id','=',$client->id)
            ->where('user_id',$sourceUser->id)
            ->first();

        $this->trackId = $clientUser->trackId;
    }
}
