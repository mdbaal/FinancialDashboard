<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use function PHPUnit\TestFixture\func;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('categories',['categories'=>Category::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $successful = false;
        Category::findOr($request->input('name'),function() use ($request, &$successful){
            Category::create(['name'=>$request->input('name')]);

            $successful = true;
        });

        if($successful)
            return redirect(route('categories.index'))->with('success','Created new category successfully.');
        else
            return redirect(route('categories.index'))->with('error','Category already exists');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Won't use
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit',['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if($request->input('name') !== $category->name && $category->name !== "None") {
            $category->name = $request->input('name');
            $category->save();

            // TODO: Somehow update all the transactions->category value

            return redirect(route('categories.index'))->with('success','Updated category successfully.');
        }

        return redirect()->back()->with('error','Nothing changed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category->name === "None")
            return redirect(route('categories.index'))->with('error',"Can't delete the 'None' category.");

        $category->transactions()->update(['category'=>'None']);
        $category->delete();

        return redirect(route('categories.index'))->with('success','Deleted category successfully.');
    }



}
