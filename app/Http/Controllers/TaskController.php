<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    use ApiResponser;
    
    public function __construct()
    {
        
    }

    //
    public function index(Request $request)
    {
        $user = User::find($request->user_id);
        if (is_null($user))
        {
            return $this->errorResponse('', Response::HTTP_NOT_FOUND);
        }

        $user_id = null;
        if ($user->role === 'ROLE_USER')
        {
            $user_id = $request->user_id;
        }
        
        $tasks = Task::with('user')
                     ->with('company')
                     ->whereRaw('(? IS NULL OR user_id = ?)', [$user_id, $user_id])
                     ->whereBetween('scheduled_datetime',
                    [
                        $request->scheduled_datetime ." 00:00:00",
                        $request->scheduled_datetime ." 23:59:59"
                    ])->get();

        return response()->json($tasks, Response::HTTP_OK);
    }

    public function balance(Request $request)
    {
        $user = User::find($request->user_id);
        if (is_null($user))
        {
            return $this->errorResponse('', Response::HTTP_NOT_FOUND);
        }

        $user_id = null;
        if ($user->role === 'ROLE_USER')
        {
            $user_id = $request->user_id;
        }

        $balance = Task::with('user')
                        ->whereRaw('(? IS NULL OR user_id = ?)', [$user_id, $user_id])
                        ->whereBetween('scheduled_datetime',
                        [
                            $request->start_scheduled ." 00:00:00",
                            $request->end_scheduled ." 23:59:59"
                        ])->groupBy('user_id')
                        ->select('user_id', Task::raw('sum(value) as value'))
                        ->get();

        return response()->json($balance, Response::HTTP_OK);
    }

    public function show(int $id)
    {
        return response()->json(Task::find($id), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $rules = [
            'company_id' => 'required',
            'user_id' => 'required',
            'description' => 'required|max:255',
            'scheduled_datetime' => 'required',
            'value' => 'required'
        ];

        $this->validate($request, $rules);

        $created = Task::create($request->all());

        $result = Task::join('users', 'users.id', '=', 'tasks.user_id')
                        ->join('companies', 'companies.id', '=', 'tasks.company_id')
                        ->where('tasks.id', '=', $created->id)
                        ->select('tasks.id AS id', 'company_id', 'user_id', 'description',
                                'scheduled_datetime', 'value', 'users.name AS user_name',
                                'users.device_token AS device_token', 'companies.name as company_name')
                        ->first();

        return response()->json($result, Response::HTTP_CREATED);
    }

    public function update(int $id, Request $request)
    {
        $rules = [
            'company_id' => 'required',
            'user_id' => 'required',
            'description' => 'required|max:255',
            'scheduled_datetime' => 'required',
            'value' => 'required'
        ];

        $this->validate($request, $rules);

        $task = Task::find($id);
        if (is_null($task))
        {
            return $this->errorResponse('', Response::HTTP_NOT_FOUND);
        }
        $task->fill($request->all());
        $task->save();
        return response()->json($task, Response::HTTP_OK);
    }

    public function destroy(int $id)
    {
        $count = Task::destroy($id);
        if ($count === 0)
        {
            return $this->errorResponse('', Response::HTTP_NOT_FOUND);
        }
        return response()->json(true, Response::HTTP_OK);
    }
}