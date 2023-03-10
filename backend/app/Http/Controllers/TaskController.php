<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\TaskResource;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;

class TaskController extends Controller
{
    /**
     * index
     *
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return response([
            'messsage' => 'tasks fetched successfully',
            'tasks' => TaskResource::collection(Task::whereUserId($request->user()->id)->with('user')->get()),
        ], 200);
    }

    /**
     * store
     *
     * @param  StoreRequest  $request
     * @return Response
     */
    public function store(StoreRequest $request): Response
    {
        $newTask = Task::create([...$request->validated(), 'user_id' => $request->user()->id]);

        return $newTask ? response(['message' => 'task created successfully'], 200) : response(['message' => 'task colud not created'], 400);
    }

    /**
     * show
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id): Response
    {
        if($task = Task::find($id)) {
            return response(['message' => 'task fetched successfully', 'task' => $task], 200);
        } else {
            return response(['message' => 'task not found'], 404);
        }
    }

    /**
     * update
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateRequest $request, int $id): Response
    {
        $task = Task::find($id);

        if($task) {
            $updatedTask = $task->update($request->validated());
            return $updatedTask ? response(['message' => 'task updated successfully'], 200) : response(['message' => 'task colud not updated'], 400);
        } else {
            return response(['message' => 'task not found'], 404);
        }
    }

    /**
     * destroy
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        $task = Task::find($id);

        if($task) {
            $deletedTask = $task->delete();
            return $deletedTask ? response(['message' => 'task deleted successfully'], 200) : response(['message' => 'task colud not deleted'], 400);
        } else {
            return response(['message' => 'task not found'], 404);
        }
    }
        
    /**
     * complete
     *
     * @param  int $id
     * @return Response
     */
    public function complete(int $id): Response
    {
        $task = Task::find($id);

        if($task) {
            $message = !$task->completed ? 'task completed' : 'task not completed';
            $completedTask = $task->update(['completed' => !$task->completed]);
            return $completedTask ? response(['message' => $message], 200) : response(['message' => 'error occured'], 400);
        } else {
            return response(['message' => 'task not found'], 404);
        }
    }
}
