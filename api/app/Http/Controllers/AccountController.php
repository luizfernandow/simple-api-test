<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $service;

    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }

    /**
    * Get balance for an account
    *
    * @param  Request  $request
    * @return Response
    */
    public function balance(Request $request)
    {
        $account = $this->service->get($request->input('account_id'));
        if (!$account) {
            return $this->notFound();
        }
        return response($account->balance, 200);
    }

    /**
     * Execute event for an account
     *
     * @param  Request  $request
     * @return Response
     */
    public function event(Request $request)
    {
        $response = $this->service->event($request->all());
        if ($response === false) {
            return $this->notFound();
        }

        return response()
                ->json($response, 201);
    }
}
