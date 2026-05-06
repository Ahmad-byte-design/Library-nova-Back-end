<?php

namespace App\Repository\Interfaces;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function all($page);
    public function find($id);
    public function create(array $data);
    public function update($id , array $data);
    public function destroy($id);
}
