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

    // insert or update record
    public function ajaxStore($request);

    // find only trashed record
    public function findOnlyTrashedRecord($taskId);

    // get all trash records
    public function getAllTrashed($userId);

    // permanently delete
    public function forceDeleteRecord($taskId);

    // restore trash record
    public function restoreDeletedRecord($taskId);
}
