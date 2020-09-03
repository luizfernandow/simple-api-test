<?php
namespace App\Repositories\Contracts;

interface AccountRepositoryInterface
{
    public function create($id);
    public function get($id);
    public function update($id, $balance);
}
