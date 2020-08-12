<?php

namespace App\Repositories;

use App\Task;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class TaskRepository implements TaskRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->setModel();
    }

    // set specific model
    private function setModel()
    {
        $this->model = app()->make(Task::class);
    }

    // get record
    public function getById($taskId)
    {
        return $this->model->findOrFail($taskId);
    }

    // get all records
    public function getAll()
    {
        try {
            return $this->model->all();
        } catch (\Exception $e) {
            return $this->queryResult($e->getMessage());
        }
    }

    // get all records by user ID
    public function getAllByUserId($userId)
    {
        try {
            $data = $this->model::select('*')->owner($userId);

            return DataTables::of($data)->addIndexColumn()->toJson();
        } catch (\Exception $e) {
            return $this->queryResult($e->getMessage());
        }
    }

    // create a record
    public function create($request)
    {
        try {
            return $this->model->create($request);
        } catch (\Exception $e) {
            return $this->queryResult($e->getMessage());
        }
    }

    // update record
    public function update($request, $object)
    {
        try {
            return $object->update($request);
        } catch (\Exception $e) {
            return $this->queryResult($e->getMessage());
        }
    }

    // delete record
    public function delete($object)
    {
        try {
            return $object->delete();
        } catch (\Exception $e) {
            return $this->queryResult($e->getMessage());
        }
    }

    // return exception error message
    private function queryResult($msg = null)
    {
        $message = ['msgError' => $msg];
        return $message;
    }
}
