<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskAssigned;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Notification;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $query = Task::with(['assignee', 'creator'])
            ->where('created_by', Auth::guard('api')->id()); // eager load

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assignee
        if ($request->filled('assignee')) {
            $query->where('assigned_user_id', $request->assignee);
        }

        // Search by title or description using FULLTEXT
        if ($request->filled('q')) {
            $q = $request->q;

            // Make sure your DB supports fulltext (MySQL >= 5.6, InnoDB/ MyISAM)
            $query->whereRaw(
                "MATCH(title, description) AGAINST(? IN BOOLEAN MODE)",
                [$q . '*'] // '*' enables partial matches
            );
        }

        // Pagination (default 10 per page)
        $tasks = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json($tasks);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function myTasks(Request $request)
    {
        $user = Auth::guard('api')->user();

        $query = Task::with(['assignee', 'creator'])
            ->where('assigned_user_id', $user->id);

        // Pagination
        $tasks = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json($tasks);
    }


    /**
     * @param StoreTaskRequest $request
     * @return mixed
     */

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::guard('api')->id();



        $data['created_by'] = Auth::guard('api')->id();

        $task = Task::create($data);
        $notification = Notification::create([
            'user_id' => $data['assigned_user_id'],
            'title'   => "New Task Assigned",
            'message' => "You have been assigned the task: {$task->title}",
        ]);

        // Broadcast notification
        broadcast(new TaskAssigned($notification));

        return response()->json($task, 201);
    }


    /**
     * @param $id
     * @return \Illuminate\Database\Concerns\TValue|\Illuminate\Database\Eloquent\Collection|null
     */
    public function show($id)
    {
        return Task::with('user')->findOrFail($id);
    }


    /**
     * @param UpdateTaskRequest $request
     * @param $id
     * @return mixed
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->validated());

        return response()->json($task);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        Task::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
