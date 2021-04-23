<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //
    protected $status = 'Failed';

    protected $message = 'Some technical issues occured';

    protected $response = 500;

    protected $result = array();

    public function allTodos()
    {
        $id = Auth::guard('api')->user()->id;
        $tasks = Task::where('userid', $id)->orderBy('created_at','DESC')->get();
        foreach ($tasks as $key => $value) {
            $this->result += array(

                $key=> array(
                    'id'    => $value->id,
                    'title' => $value->title,
                    'completed' => $value->completed==1?1:0,
                ));
        }

        return $this->sendResponse(true);
    }

    public function createTodo()
    {
        $id = Auth::guard('api')->user()->id;
        $data = ['userid'=>$id,'title'=>request('title')];
        $tasks = Task::create($data);
        return $this->sendResponse(true);
    }

    public function toggleTodo($id)
    {
        $u_id = Auth::guard('api')->user()->id;
        Task::find($id)->toggleCompleted($u_id)->save();
        return $this->sendResponse(true);
    }

    public function deleteTodo($id)
    {
        $u_id = Auth::guard('api')->user()->id;
        Task::where('userid',$u_id)->where('id',$id)->delete();
        return $this->sendResponse(true);
    }

    protected function sendResponse($status = false)
    {
        if($status)
        {
            $this->status = 'Success';
            $this->message = 'Successfull';
            $this->response = 200;
        }
        return response()->json(['status' =>$this->status,'message' => $this->message, 'data'=> $this->result], $this->response);
    }
}
