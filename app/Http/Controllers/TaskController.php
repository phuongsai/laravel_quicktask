<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Services\TaskServiceInterface;

class TaskController extends Controller
{
    private $taskService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskServiceInterface $taskServiceInterface)
    {
        $this->taskService = $taskServiceInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->taskService->getRecordsByUserId();
        }

        return view('tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        try {
            $result = $this->taskService->storeRecord($request->all());
            if ($result) {
                return $this->jsonMsgResult(false, trans('messages.task.success'), 201);
            }

            return $this->jsonMsgResult($result['msgError'], false, 500);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = [];
        try {
            $data = $this->taskService->getRecordById($id);
            $result['data'] = $data;
            $result['statusCode'] = 200;

            return response()->json($result, $result['statusCode']);
        } catch (\Exception $e) {
            $result['statusCode'] = 200;
            $result['errors'] = $e->getMessage();
            return response()->json($result, $result['statusCode']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = $this->taskService->deleteRecord($id);
            if (isset($result['msgError'])) {
                return $this->jsonMsgResult($result['msgError'], false, 500);
            }

            return $this->jsonMsgResult(false, trans('messages.task.success_delete'), 200);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    /**
     * Display a listing of the resource (Soft Delete).
     *
     * @return \Illuminate\Http\Response
     */
    public function getTrashRecords()
    {
        try {
            return $this->taskService->getAllTrashed();
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($taskId)
    {
        try {
            $result = $this->taskService->forceDelete($taskId);
            if (isset($result['msgError'])) {
                return $this->jsonMsgResult($result['msgError'], false, 500);
            }

            return $this->jsonMsgResult(false, trans('messages.task.success_delete'), 200);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function restoreTrash($taskId)
    {
        try {
            $result = $this->taskService->restoreTrash($taskId);
            if (isset($result['msgError'])) {
                return $this->jsonMsgResult($result['msgError'], false, 500);
            }

            return $this->jsonMsgResult(false, trans('messages.task.success_restore'), 200);
        } catch (\Exception $e) {
            return $this->jsonMsgResult($e->getMessage(), false, 500);
        }
    }

    /**
     * Display exception errors of request.
    */
    private function jsonMsgResult($errors, $success, $statusCode)
    {
        $result = [
            'errors' => $errors,
            'success' => $success,
            'statusCode' => $statusCode,
        ];

        return response()->json($result, $result['statusCode']);
    }
}
