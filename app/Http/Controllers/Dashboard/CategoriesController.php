<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.index' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $parents = Category::all();
         $category = new Category();
         return view('dashboard.categories.create' , compact('parents' , 'category'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$request->post() just from body (post)
        // $request->query() just from url (get)
        // $request->get() from post or get

        //PRG  POST REDIRECT GIT
        $request['slug'] = Str::slug($request->post('name'));
        $category = Category::create($request->all());
        return redirect()->route('dashboard.categories.index')
            ->with('success' , 'Add successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        // select * from categories where id != $id and (parent_id is Null or parent_id != $id)
        $parents = Category::where('id' , '<>' , $id)
                       ->where(function ($query) use ($id){
                       $query->whereNull('parent_id')
                             ->orWhere('parent_id' , '<>' , $id);
                   })->get(); // <> means !=
        return view('dashboard.categories.edit' , compact('category' , 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
         $category->update($request->all());
        return redirect()->route('dashboard.categories.index')
            ->with('success' , 'updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*
        $category = Category::findOrFail($id);
        $category->delete();
        */
        // previous code can be replacement with the following
        Category::destroy($id);
        return redirect()->route('dashboard.categories.index')
            ->with('success' , 'deleted successfully');

    }
}
