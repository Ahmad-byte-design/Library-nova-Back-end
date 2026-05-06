<?php

namespace App\Repository\Interfaces;

interface ReviewRepositoryInterface
{
    public function all($id , $page);
    public function create(array $data);
    public function update($id , array $data);
    public function destroy( $id);
}
