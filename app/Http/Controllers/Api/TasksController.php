<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth, Log;

use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::user()->id)->get();
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'finished' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        try {
            $task = new Task;
            $task->title = $request->title;
            $task->user_id = Auth::user()->id;
            $task->description = $request->description;
            $task->finished = $request->finished;
            $task->save();

            return response()->json($task);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Unable to create new task'], 400);
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
        try {
            $task = Task::where('user_id', Auth::user()->id)->where('id', $id)->first();
            if(!$task) {
                return response(['error' => 'Task not found']);
            }
            return response()->json($task);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Unable to find task'], 400);
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'finished' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        try {
            $task = Task::where('user_id', Auth::user()->id)->where('id', $id)->first();
            if(!$task) {
                return response(['error' => 'Task not found']);
            }
            $task->title = $request->title;
            $task->description = $request->description;
            $task->finished = $request->finished;
            $task->save();

            return response()->json($task);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Unable to update task'], 400);
        }
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
            $task = Task::where('user_id', Auth::user()->id)->where('id', $id)->first();
            if(!$task) {
                return response(['error' => 'Task not found']);
            }

            $task->delete();
            return response()->json(['sucess' => 'Task deleted sucesfull']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Unable to delete task'], 400);
        }
    }
}
