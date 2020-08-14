<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class TaskService implements TaskServiceInterface
{
    private $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepositoryInterface)
    {
        $this->taskRepository = $taskRepositoryInterface;
    }

    // get record
    public function getRecordById($taskId)
    {
        return $this->taskRepository->getById($taskId);
    }

    // get all records by user ID
    public function getRecordsByUserId()
    {
        if (Auth::check()) {
            return $this->taskRepository->getAllByUserId(Auth::user()->id);
        } else {
            return redirect()->route('login');
        }
    }

    // delete record
    public function deleteRecord($taskId)
    {
        $task = $this->taskRepository->getById($taskId);

        return $this->taskRepository->delete($task);
    }

    // create a record
    public function storeRecord($request)
    {
        try {
            $request = array_merge($request, ['user_id' => Auth::user()->id]);
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        return $this->taskRepository->ajaxStore($request);
    }

    // get all trash records
    public function getAllTrashed()
    {
        try {
            $userId = Auth::user()->id;

            return $this->taskRepository->getAllTrashed($userId);
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }

    // permanently delete
    public function forceDelete($taskId)
    {
        return $this->taskRepository->forceDeleteRecord($taskId);
    }

    // restore trash record
    public function restoreTrash($taskId)
    {
        return $this->taskRepository->restoreDeletedRecord($taskId);
    }
}
