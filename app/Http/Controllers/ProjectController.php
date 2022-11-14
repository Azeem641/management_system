<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * function to return all projects
     * gets all projects with id and name
     * 
     * @param $request
     * @return collection 
     */
    public function getAllProducts(Request $request){
        return DB::table('projects')->select('id', 'name', 'created_at')->get();
    }
}
