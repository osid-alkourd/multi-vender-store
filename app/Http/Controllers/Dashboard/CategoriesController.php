<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


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
      
        $data = $request->except('image');
        $data['slug'] = Str::slug($request->post('name'));
        $data['image'] = $this->uploadFile($request);
        $category = Category::create($data);
        //PRG  POST REDIRECT GIT
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
        $old_file = $category->image; // if this category has file or image will return the path for this file
         $data = $request->except('image');
         $new_image = $this->uploadFile($request);
         if($new_image){
            $data['image'] = $new_image;
         }
         $category->update($data);
        if($old_file && isset($data['image'])){
            Storage::disk('public')->delete($old_file);
        }
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

      //  Category::destroy($id);


        $category = Category::findOrFail($id);
        $category->delete();
        if($category->image){
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.index')
            ->with('success' , 'deleted successfully');

    }

    public function uploadFile(Request $request){
        if(!$request->file('image')) // uploadedFile Object
             return;

        $file = $request->file('image');
        // Now to store file and return path
        $path = $file->store('uploads/categories', [ // the file will store inside storage/app/public/uploads/categories
                'disk' => 'public'
                ]);
        return $path;
    }


    //$request->post() just from body (post)
    // $request->query() just from url (get)
    // $request->get() from post or get
}
