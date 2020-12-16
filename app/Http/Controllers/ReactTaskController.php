<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Task;

//
class ReactTaskController extends Controller
{
    /**************************************
     *
     **************************************/
    public function index()
    {
        return view('react/tasks/index');
    }    
    /**************************************
     *
     **************************************/
    public function create()
    {
        return view('react/tasks/create');
    }
    /**************************************
     *
     **************************************/
    public function show($id)
    {
        return view('react/tasks/show')->with('task_id', $id );
    }
    /**************************************
     *
     **************************************/
    public function edit($id)
    {
        return view('react/tasks/edit')->with('task_id', $id);
    }    


}
