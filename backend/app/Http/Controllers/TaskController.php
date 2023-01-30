<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        //
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
