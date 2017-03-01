<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * List of resource.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function search(Request $request)
    {
        return [
            'message' => 'Successfully fetched all tasks.',
            'data' => $request->user()->tasks
        ];
    }

    /**
     * Create a resource.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'title' => 'required|max:128',
            'done' => 'required|boolean',
        ]);

        $task = Task::create($request->only([
            'user_id', 'title', 'done'
        ]));

        return [
            'message' => 'Successfully created new task.',
            'data' => $task
        ];
    }

    /**
     * Update a resource.
     *
     * @param  integer  $id
     * @param  Request  $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:128',
            'done' => 'required|boolean',
        ]);

        $task = Task::where([
            'id' => $id,
            'user_id' => $request->user()->id
        ])->firstOrFail();

        $task->update($request->only([
            'title', 'done'
        ]));

        return [
            'message' => 'Successfully updated a task.',
            'data' => $task
        ];
    }

    /**
     * Delete a resource.
     *
     * @param  integer  $id
     * @param  Request  $request
     *
     * @return Response
     */
    public function delete($id, Request $request)
    {
        Task::where([
            'id' => $id,
            'user_id' => $request->user()->id
        ])->firstOrFail()->delete();

        return [
            'message' => 'Successfully deleted a task.'
        ];
    }
}
