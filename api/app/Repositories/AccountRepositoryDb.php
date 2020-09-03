<?php
namespace App\Repositories;

use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AccountRepositoryDb implements AccountRepositoryInterface
{
    public function create($id)
    {
        return DB::table('accounts')->insert(
            ['id' => $id, 'balance' => 0]
        );
    }

    public function get($id)
    {
        return DB::table('accounts')->find($id);
    }

    public function update($id, $balance)
    {
        return DB::table('accounts')
              ->where('id', $id)
              ->update(['balance' => $balance]);
    }
}
