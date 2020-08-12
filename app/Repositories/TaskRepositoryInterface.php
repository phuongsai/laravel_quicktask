<?php

namespace App\Repositories;

interface TaskRepositoryInterface
{
    // get record
    public function getById($taskId);

    // get all records
    public function getAll();

    // get all records by user ID
    public function getAllByUserId($userId);

    // create a record
    public function create($request);

    // update record
    public function update($request, $object);

    // delete record
    public function delete($object);
}
