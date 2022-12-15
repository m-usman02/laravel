<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Str;
use Storage;
use App\Jobs\SendPostMail;
use App\Models\User;
use App\Jobs\SendPostMail as Job;
use App\Events\PostCreatedEvent;
use Mail;
use App\Mail\PostMail;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function sendEmail()
     {       
        $users = User::all();
        $post = Post::latest()->first(); 
           
        foreach ($users as $key => $user) {
            dispatch(new Job($post,$user));          
        }
        return 'success';
     }

     public function sendEmailByListerner()
     {       
        $users = User::where('id','!=',auth()->id())->get();
        $post = Post::where('id',auth()->id())->latest()->first(); 
           
        foreach ($users as $key => $user) {
            Mail::to($user->email)->send(new PostMail($post));      
        }
        return 'success';
     }
    public function index()
    {
        if (request()->ajax()) {
            $data = Post::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('status',function($row){
                      return ($row->status == 1 ? 'Open' : 'Closed');
                    })
                    ->addColumn('edit', function($row){   
                        $btn = "<a href=".route('post.edit',$row->id)." class='btn btn-primary'>Edit</a>";  
                        return $btn;
                 })
                    ->addColumn('remove', function($row){  
                          $btn = "<a href='javascript:void(0)' class='btn btn-danger delete-post' data-id=".$row->id.">Delete</i></a>";    
                           return $btn;
                    })
                    ->rawColumns(['remove','edit'])
                    ->make(true);
        }
        return view('post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {      
        
        try {
            \DB::beginTransaction();           
            $fileNameToStore = null;
        if($request->hasFile('image')){
               $file = $request->file('image');              
               //file name to store
               $fileNameToStore = 'image'.time().rand(1,10).'.'.$file->getClientOriginalExtension();
               //upload image
               $file->storeAs('public', $fileNameToStore);
              
        }
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->id();  
        $post->image = $fileNameToStore;
        $post->slug = Str::slug($request->title);        
        $post->save();
        event(new PostCreatedEvent());   
        \DB::commit();
     
        return redirect()->route('post.index')->with('message', 'Post Created Successfully!');        
        } catch (\Exception $e) {            
            \DB::rollback();
            \Log::emergency("File: ".$e->getFile().'Line: '.$e->getLine().'Message: '.$e->getMessage());
            return back()->with('message', 'Something went wrong!');           
        }
        
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {   
       
        try {
            \DB::beginTransaction();           
            $fileNameToStore = $post->image;
            if($request->hasFile('image')){
                   $file = $request->file('image');              
                   $fileNameToStore = 'image'.time().rand(1,10).'.'.$file->getClientOriginalExtension();
                   //upload image
                   $file->storeAs('public', $fileNameToStore);
                  
                   if (file_exists(Storage::path('public/'.$post->avatar))) {                
                     Storage::delete('public/'.$post->avatar);               
                   }
            }
     
        $post->title = $request->title;
        $post->body = $request->body;   
        $post->image = $fileNameToStore;
        $post->slug = Str::slug($request->title);        
        $post->save();       
        \DB::commit();
        return redirect()->route('post.index')->with('message', 'Post Updated Successfully!');
        
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::emergency("File: ".$e->getFile().'Line: '.$e->getLine().'Message: '.$e->getMessage());
            return back()->with('message', 'Something went wrong!');           
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $success = false;
        try {
            \DB::beginTransaction();           
            $post->delete();
            \DB::commit();
            $success = true;
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::emergency("File: ".$e->getFile().'Line: '.$e->getLine().'Message: '.$e->getMessage());
            $success = false;            
        }
        return response()->json(['success'=>$success]);
    }
}
