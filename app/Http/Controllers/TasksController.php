<?php
//タスク

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use MongoDB\Client;

//
class TasksController extends Controller
{
    /**************************************
     *
     **************************************/
    public function test1(){
        $client = new Client("mongodb://mongo:27017");
        $collection = $client->db1->books;
        $result = $collection->find();

        foreach ($result as $entry) {
            var_dump("#id=". $entry["_id"]);
            var_dump("#title=". $entry["title"]);
        }        
        exit();
    }

}
