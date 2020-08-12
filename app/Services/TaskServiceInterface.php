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
}
