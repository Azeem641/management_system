<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{
    /**
     * function to create new tasks
     * saves task in tasks table of mysql database
     * 
     * @param $request
     * @return json 
     */
    public function createTask(TaskRequet $request)
    {
        $response = ['error' => 'false', 'message' => 'Task created successfully'];
        $task = DB::table('tasks')->insert([
            'name' => $request->name,
            'priority' => $request->priority,
            'project_id' =>$request->project_id,
            'created_at' => Carbon::now(),
        ]);
        if($task){
            $response = response()->json([$response], 200);
        } else{
            $response = response()->json(['error' => 'true', 'message' => 'Something went wrong', 422]);
        }
        return $response;
    }


    /**
     * function to update tasks
     * updates task in tasks table of mysql database
     * 
     * @param $request
     * @return json 
     */
    public function updateTask(Request $request){
        $response = ['error' => 'false', 'message' => 'Task updated successfully'];
        $is_updated = DB::table('tasks')->where('id', $request->id)->update([
            'name' => $request->name,
            'priority' => $request->priority,
            'project_id' =>$request->project_id,
            'updated_at' => Carbon::now(),
        ]);
        if($is_updated){
            $response = response()->json([$response], 200);
        } else{
            $response = response()->json(['error' => 'true', 'message' => 'Something went wrong', 422]);
        }
        return $response;
    }

    /**
     * function to delete task permanently
     * deletes task from tasks table of mysql database
     * 
     * @param $request
     * @return json 
     */
    public function deleteTask(Request $request){
        $response = ['error' => 'false', 'message' => 'Task deleted successfully'];
        $is_deleted = DB::table('tasks')->where('id', $request->id)->delete();
        if($is_deleted){
            $response = response()->json([$response], 200);
        } else{
            $response = response()->json(['error' => 'true', 'message' => 'Something went wrong', 422]);
        }
        return $response;
    }

    /**
     * function to get all tasks data from tasks table
     * also performs search filter by name
     * 
     * @param $request
     * @return json 
     */
    public function listAllTasks(Request $request){
        $response = ['error' => 'false', 'message' => 'Tasks listing', 'data', []];
        $tasks = DB::table('tasks')->select('id', 'name', 'priority', 'project_id', 'created_at');
        $this->filterByName($request, $tasks);
        $data = $tasks->get();
        $response['data'] = $data;
        return response()->json([$response], 200);
    }

    /**
     * function to performs search filter by name
     * 
     * @param $request, $tasks
     */
    private function filterByName($request, $tasks){
        if(isset($request->name)){
            $tasks->where('name', $request->name);
        }
    }

    /**
     * function to get all tasks against project from tasks table
     * 
     * @param $request
     * @return json 
     */
    public function projectTasks(Request $request){
        $response = ['error' => 'false', 'message' => 'Tasks listing', 'data', []];
        $tasks = DB::table('tasks')->select('id', 'name', 'priority', 'created_at')->where('project_id', $request->project_id)->get();
        $response['data'] = $tasks;
        return response()->json([$response], 200);
    }
}
