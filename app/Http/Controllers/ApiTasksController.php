<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
//
class ApiTasksController extends Controller
{
    /**************************************
     *
     **************************************/
    public function __construct(){
        $this->TBL_LIMIT = 500;
    }
    /**************************************
     *
     **************************************/
    public function get_tasks()
    {   
        $reply = Redis::command('zrevrange', ["sorted_tasks", 0, -1 ]);
        $reply_tasks = Redis::command('mget', [$reply]);
        $tasks_items = [];
        foreach($reply_tasks as $reply_task ){
            $row = json_decode ( $reply_task , true);
//            print_r( $row);
            $tasks_items[] = $row;
        }
        return response()->json($tasks_items);
    }

    /**************************************
     *
     **************************************/  
    public function create_task(Request $request){
        $key_head  = "task:";
        $reply= Redis::command('INCR', ["idx-task"]);
        $key = $key_head . $reply;
        Redis::command('ZADD', ["sorted_tasks", $reply, $key]);
        $item = [
            "id"=> $key, "title"=>request('title'), "content"=> request('content')
        ] ;
        $json = json_encode($item);
        //print_r($reply);
        Redis::set($key , $json);

        $ret = ['title' => request('title'),'content' => request('content')];
        return response()->json($ret);
    }
    /**************************************
     *
     **************************************/
    public function get_item(Request $request)
    {
        $task = Redis::get(request('id'));
        $task = json_decode ( $task , true);
        return response()->json($task );
    }
    /**************************************
     *
     **************************************/
    public function update_post(Request $request){
        $key = request('id');
        $item = [
            "id"=> $key, "title"=>request('title'), "content"=> request('content')
        ] ;     
        $json = json_encode($item);
        Redis::set($key , $json);           
        return response()->json($item);
    }
    /**************************************
     *
     **************************************/
    public function delete_task(Request $request){
        Redis::command('zrem', ["sorted_tasks", request('id') ]);
        Redis::command('del', [ request('id') ]);
        $ret = ['id'=> request('id') ];
        return response()->json($ret);
    }
    /**************************************
     *
     **************************************/
    public function test_tasks()
    {   
//exit();
    }

}
