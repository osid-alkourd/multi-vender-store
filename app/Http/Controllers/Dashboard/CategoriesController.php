<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
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
        $request = request();
        // select child.* , parent.name as parent_name 
        // from categories  as child
        // LEFT JOIN categoires as parent child.parent_id = parent.id
        $categories = Category::leftJoin('categories as parents', 'categories.parent_id', '=', 'parents.id')
                              ->select([
                                    'categories.*',
                                    'parents.name as parent_name'
                                ])
                              ->selectRaw('(SELECT COUNT(*) FROM products WHERE products.category_id = categories.id) as products_count')
                              //->groupBy('categories.id')
                              ->filter($request->query())->paginate(3);
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
        $request->validate(Category::rules(), [
            'required' => 'This field (:attribute) is required ' , // custom validation message
            'name.unique' => 'This name is already exists !' ,
        ]);
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
    public function show(Category $category)
    {
      $category_products = Product::where('category_id' , '=' , $category->id)
                         ->leftJoin('stores' , 'products.store_id' , '=' , 'stores.id')
                         ->select('products.*' , 'stores.name as store_name')
                         ->get();
      return view('dashboard.categories.show' , compact('category_products'));
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
    public function update(CategoryRequest $request, $id)
    {
        //$request->validate(Category::rules($id));
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
    public function destroy(Category $category)
    {

      //  Category::destroy($id);

        $category->delete();
        
        // if($category->image){
        //     Storage::disk('public')->delete($category->image);
        // }

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

    public function trash(){
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)  {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.trash')
            ->with('succes', 'Category restored!');
    }


    public function forceDelete($id){
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

       if($category->image){
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')
            ->with('succes', 'Category deleted forever!');
    }

    //$request->post() just from body (post)
    // $request->query() just from url (get)
    // $request->get() from post or get
}
