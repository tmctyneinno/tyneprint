<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->category = new Category;
    }
    public function index()
    {

        
        return view('manage.category.index')
            ->with('category', Category::latest()->get())
            ->with('bheading', 'Category')
            ->with('breadcrumb', 'Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.category.create')
            ->with('bheading', 'Category')
            ->with('breadcrumb', 'Index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
        ]);
        if ($validate->fails()) {
            \Session::flash('alert', 'error');
            \Session::flash('message', 'The fields with * are required');

            return redirect()->back()->withErrors($validate)->withInput($request->all())
                ->with('bheading', 'Category')
                ->with('breadcrumb', 'Index');
        }

        if ($request->file('image')) {
            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $FileName = \pathinfo($name, PATHINFO_FILENAME);
            $ext = $file->getClientOriginalExtension();
            $time = md5(time());
            $fileName = $time . '.' . $ext;
            //$image->move('images/category/', $fileName);
            $ff = Image::read($request->file('image')->getRealPath())->resize(849, 227)->save('images/category/' . $fileName);
        }
        //  dd($fileName);
        $data = [
            'name' => $request->name,
            'image' => $fileName,
        ];
        $category =  $this->category->create($data);
        if ($category) {
            \Session::flash('alert', 'success');
            \Session::flash('message', 'Category Added Successfully');
            return redirect()->back()
                ->with('bheading', 'Category')
                ->with('breadcrumb', 'Index');
        }
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
        $id =  decrypt($id);
        return view('manage.category.edit')
            ->with('bheading', 'Category')
            ->with('category',  Category::where('id', $id)->first())
            ->with('breadcrumb', 'Edit Catogry');
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
        $id = decrypt($id);
        $category = category::where('id', $id)->first();
        $category->name = $request->name;
        if($request->file('image')){
            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $FileName = \pathinfo($name, PATHINFO_FILENAME);
            $ext = $file->getClientOriginalExtension();
            $time = md5(time());
            $fileName = $time.'.'.$ext;
            // $file->move('images/category/', $fileName);
           Image::make($request->file('image'))->resize(849, 227)->save('images/category/' . $fileName);
            $category->image = $fileName;
        }else{
            $category->image =  $category->image;  
        }
        if($category->save()){
            \Session::flash('alert', 'success');
            \Session::flash('message', 'Category Added Successfully');
            return redirect()->back()
                ->with('bheading', 'Category')
                ->with('breadcrumb', 'Index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
