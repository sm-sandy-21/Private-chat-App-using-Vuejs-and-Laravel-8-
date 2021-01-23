<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageEvent;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users= User::latest()->where('id','!=',auth()->user()->id)->get();

        if(\Request::ajax()){
            return response()->json($users);
        }
        return abort(404);
    }
    public function user_message($id=null)
    {
        if(!\Request::ajax()){
            return abort(404);
        }
        $user= User::findOrFail($id);
        $messages = $this->message_by_user_id($id);
        
            return response()->json([
                'messages'=>$messages,
                'user'=>$user
            ]);
     
    }
    public function send_message(Request $request)
    {
        if(!\Request::ajax()){
            return abort(404);
        }
        $messages = Message::create([
            'message'=>$request->message,
            'from'=>auth()->user()->id,
            'to'=>$request->user_id,
            'type'=>0
        ]); 
        $messages = Message::create([
            'message'=>$request->message,
            'from'=>auth()->user()->id,
            'to'=>$request->user_id,
            'type'=>1
        ]); 
        
        return response()->json($messages,201);  
    }
    public function delete_single_message($id)
    {
        if(!\Request::ajax()){
            return abort(404);
        }
       $deleteMessage = Message::findOrFail($id)->delete();
      
        return response()->json($deleteMessage,201);  
    }
    public function delete_all_message($id)
    {
        if(!\Request::ajax()){
            return abort(404);
        }

        $messages = $this->message_by_user_id($id);

        foreach ($messages as $value) {
             Message::findOrFail($value->id)->delete();
        }
        return response()->json('Delete All Message',201);  
       
     
    }
    public function message_by_user_id($id){
       
        $messages = Message::where(function($q) use($id){
            $q->where('from',auth()->user()->id);
            $q->where('to',$id);
            $q->where('type',0);
        })->orWhere(function($q) use($id){
           $q->where('from',$id);
           $q->where('to',auth()->user()->id);
           $q->where('type',1);
        })->with('user')
        ->get(); 
        return $messages;

    } 
    


}
