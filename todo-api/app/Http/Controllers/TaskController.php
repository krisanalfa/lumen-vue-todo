<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * List of resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Successfully fetched all tasks.',
            'data' => $request->user()->tasks,
        ]);
    }

    /**
     * Create a resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $this->validate($request, [
            'title' => ['required', 'max:128'],
            'done' => ['required', 'boolean'],
        ]);

        $task = Task::create($request->only([
            'title',
            'done'
        ]) + [
            'user_id' => $request->user()->getKey()
        ]);

        return new JsonResponse([
            'message' => 'Successfully created new task.',
            'data' => $task,
        ]);
    }

    /**
     * Update a resource.
     *
     * @param int     $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $this->validate($request, [
            'title' => ['required', 'max:128'],
            'done' => ['required', 'boolean'],
        ]);

        $task = Task::where([
            'id' => $id,
            'user_id' => $request->user()->getKey(),
        ])->firstOrFail();

        $task->update($request->only([
            'title',
            'done'
        ]));

        return new JsonResponse([
            'message' => 'Successfully updated a task.',
            'data' => $task,
        ]);
    }

    /**
     * Delete a resource.
     *
     * @param int     $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id, Request $request): JsonResponse
    {
        Task::where([
            'id' => $id,
            'user_id' => $request->user()->id,
        ])->firstOrFail()->delete();

        return new JsonResponse([
            'message' => 'Successfully deleted a task.',
        ]);
    }
}
