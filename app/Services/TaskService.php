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
}
