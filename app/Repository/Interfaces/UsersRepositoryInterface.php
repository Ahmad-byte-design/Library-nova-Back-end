<?php

namespace App\Repository\Interfaces;

use App\Models\User;

interface UsersRepositoryInterface
{
    public function all($page);
    public function find($id);
    public function create(array $data);
    public function update($id,array $data);
    public function destroy($id);
    public function findByEmail($email);
}
