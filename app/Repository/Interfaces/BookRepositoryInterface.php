<?php

namespace App\Repository\Interfaces;


interface BookRepositoryInterface
{
    public function all( int $page , int $per_page );
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function destroy(int $id);
}
