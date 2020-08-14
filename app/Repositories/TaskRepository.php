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

    // insert or update record
    public function ajaxStore($request)
    {
        try {
            if (isset($request['task_id'])) {
                $task = $this->getById($request['task_id']);

                return $this->update($request, $task);
            }

            return $this->create($request);
        } catch (\Exception $e) {
            return $this->queryResult($e->getMessage());
        }
    }

    // find only trashed record
    public function findOnlyTrashedRecord($taskId)
    {
        return $this->model->onlyTrashed()->findOrFail($taskId);
    }

    // get all trash records
    public function getAllTrashed($userId)
    {
        try {
            $data = $this->model::select('*')->owner($userId)->onlyTrashed();

            return DataTables::of($data)->addIndexColumn()->toJson();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // permanently delete
    public function forceDeleteRecord($taskId)
    {
        try {
            $task = $this->findOnlyTrashedRecord($taskId);

            return $task->forceDelete();
        } catch (\Exception $e) {
            return $this->queryResult($e->getMessage());
        }
    }

    // restore trash record
    public function restoreDeletedRecord($taskId)
    {
        try {
            $task = $this->findOnlyTrashedRecord($taskId);

            return $task->restore();
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
