<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\POST;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Str;
class PostController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = POST::all('id','title','body');
        return $this->success([           
            'data' => $post
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title'=>'required|max:255',
            'body'=>'required|max:5000'            
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->error(
                'validation fails',
                400,
                $validator->errors()
            );
           
        }
        try {
            \DB::beginTransaction();          
            
       
        $post = new Post;
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = auth()->id();        
        $post->slug = Str::slug($request->title);        
        $post->save();       
        \DB::commit();
        return $this->success(
            'data stored',
        );       
        } catch (\Exception $e) {
            
            \DB::rollback();
            \Log::emergency("File: ".$e->getFile().'Line: '.$e->getLine().'Message: '.$e->getMessage());
            return $this->error(
                'somthing went wrong',
                400,
            );      
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\POST  $pOST
     * @return \Illuminate\Http\Response
     */
    public function show(POST $pOST)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\POST  $pOST
     * @return \Illuminate\Http\Response
     */
    public function edit(POST $pOST)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\POST  $pOST
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, POST $pOST)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\POST  $pOST
     * @return \Illuminate\Http\Response
     */
    public function destroy(POST $pOST)
    {
        //
    }
}
