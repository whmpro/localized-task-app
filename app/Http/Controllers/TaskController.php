<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // $timestamp = '2014-02-06 16:34:00';
        // $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'Asia/Karachi');
        // $date->setTimezone('UTC');
        // return $date;
        //return Task::all()->first()->deadline->timezone;
        $ip     = $_SERVER['REMOTE_ADDR']; // means we got user's IP address 
        
        $json   = file_get_contents( 'http://ip-api.com/json/' . $ip); // this one service we gonna use to obtain timezone by IP
        // maybe it's good to add some checks (if/else you've got an answer and if json could be decoded, etc.)
        $ipData = json_decode( $json, true);
        //
        return view('tasks.index')->with([
            'tasks' =>  Task::latest()->get(),
            'u_timezone' => $ipData['timezone']
        ]);
    }

    public function store()
    {

        $validatedData = $this->validate(request(), [
            'title' => 'required|max:255',
            'deadline' => 'required|date',
        ]);
        //return $validatedData['deadline'];
        $task = new Task;
        $task->title = $validatedData['title'];
        $task->deadline = $validatedData['deadline'];
        $task->save();
        return ['success' => true];
    }
}
