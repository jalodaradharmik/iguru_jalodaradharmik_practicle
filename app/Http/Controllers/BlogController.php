<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Blog;
use Validator;
use App;
use GoogleTranslate;

class BlogController extends BaseController
{
    public function list()
    {
        $Blogs = Blog::paginate(10);
    
        return $this->sendResponse($Blogs, GoogleTranslate::trans('Blogs retrieved successfully.', app()->getLocale()));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError(GoogleTranslate::trans($validator->errors()->first(), app()->getLocale()));       
        }
   
        $Blog = Blog::create([
            "name" => $request->name,
            "description" => $request->description,
        ]);
   
        return $this->sendResponse($Blog, GoogleTranslate::trans('Blog created successfully.', app()->getLocale()));
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError(GoogleTranslate::trans($validator->errors()->first(), app()->getLocale()));       
        }

        $Blog = Blog::where("id", $request->id)->first();
  
        if (is_null($Blog)) {
            return $this->sendError(GoogleTranslate::trans('Blog not found.', app()->getLocale()));
        }
   
        return $this->sendResponse($Blog, GoogleTranslate::trans('Blog retrieved successfully.', app()->getLocale()));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
   
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError(GoogleTranslate::trans($validator->errors()->first(), app()->getLocale()));       
        }
   
        Blog::where("id", $request->id)->update([
            "name" => $request->name,
            "description" => $request->description,
        ]);
   
        return $this->sendResponse([], GoogleTranslate::trans('Blog updated successfully.', app()->getLocale()));
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError(GoogleTranslate::trans($validator->errors()->first(), app()->getLocale()));       
        }

        Blog::where("id", $request->id)->delete();
   
        return $this->sendResponse([], GoogleTranslate::trans('Blog deleted successfully.', app()->getLocale()));
    }
}
