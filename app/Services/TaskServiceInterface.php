<?php

namespace App\Services;

interface TaskServiceInterface
{
    // get record
    public function getRecordById($taskId);

    // get all records by user ID
    public function getRecordsByUserId();

    // delete record
    public function deleteRecord($taskId);

    // create a record
    public function storeRecord($request);

    // get all trash records
    public function getAllTrashed();

    // permanently delete
    public function forceDelete($taskId);

    // restore trash record
    public function restoreTrash($taskId);
}
