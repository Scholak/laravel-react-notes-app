<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        //
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
        //
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
        //
    }

    /**
     * destroy
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        //
    }
        
    /**
     * complete
     *
     * @param  int $id
     * @return Response
     */
    public function complete(int $id): Response
    {
        
    }
}
