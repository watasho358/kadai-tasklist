<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Task;    // 追加

class TasksController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            //dd($tasks);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            $data += $this->counts($user);
            return view('tasks.index', $data);
        }else {
            return view('tasks.index');
        }
    }

    public function create()
    {
        $task = new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    public function store(Request $request)
    {
        
     $this->validate($request, [
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:191',
        ]);
        
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        
        return redirect('/');
    }

    public function show($id)
     {
         $task = Task::find($id);
         if (\Auth::check()){
            $user = \Auth::user();
            
            //dd($task);
            
            if( $user->id == $task->user_id ){
                 return view('tasks.show',[
                  'task' => $task
                ]);               
            }else{
            return redirect('/');
        }   
        }
    }

    public function edit($id)
    {
        $task = Task::find($id);

        if (\Auth::check()){
            $user = \Auth::user();
            if( $user->id == $task->user_id ){
                return view('tasks.edit',[
                    'task' => $task
                ]);
            }else{
            return redirect('/');
        }   
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:191',
        ]);
        
        $task = Task::find($id);
        $task->status = $request->status;  //追加
        $task->content = $request->content;
        $task->save();

         return redirect('/');
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        
        $user = \Auth::user();
        //dd($task);
        
        if (\Auth::user()->id == $task->user_id) {
            $task->delete();
        }else{
            return redirect('/');
        }   
            return redirect('/');
    }
}