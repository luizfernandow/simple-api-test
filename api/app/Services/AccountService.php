<?php

namespace App\Services;

use App\Repositories\Contracts\AccountRepositoryInterface;

class AccountService
{
    private $repository;

    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function get($id)
    {
        return $this->repository->get($id);
    }

    public function getOrCreate($id)
    {
        $account = $this->repository->get($id);
        if (!$account) {
            $account = $this->repository->create($id);
            if ($account) {
                $account = $this->repository->get($id);
            }
        }
        return $account;
    }

    public function event(array $input)
    {
        switch ($input['type']) {
            case 'deposit':
                return $this->deposit((Integer)$input['destination'], (Integer)$input['amount']);
                break;
            case 'withdraw':
                return $this->withdraw((Integer)$input['origin'], (Integer)$input['amount']);
                break;
            case 'transfer':
                return $this->transfer((Integer)$input['origin'], (Integer)$input['amount'], (Integer)$input['destination']);
                break;
            default:
                return false;
                break;
        }
    }

    private function deposit(int $destination, int $amount)
    {
        $account = $this->getOrCreate($destination);
        if ($account === false) {
            return false;
        }

        $newBalance = $account->balance + $amount;
        if ($this->repository->update($account->id, $newBalance)) {
            return ['destination' => ['id' => $account->id, 'balance' => $newBalance]];
        }

        return false;
    }

    private function withdraw(int $origin, int $amount)
    {
        $account = $this->get($origin);
        if (!$account) {
            return false;
        }

        $newBalance = $account->balance - $amount;
        if ($this->repository->update($account->id, $newBalance)) {
            return ['origin' => ['id' => $account->id, 'balance' => $newBalance]];
        }

        return false;
    }

    private function transfer(int $origin, int $amount, int $destination)
    {
        $withdraw = $this->withdraw($origin, $amount);
        if ($withdraw === false) {
            return false;
        }

        $deposit = $this->deposit($destination, $amount);
        if ($deposit === false) {
            return false;
        }

        return $withdraw + $deposit;
    }
}
