<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Auth;
use Session;
use Modules\Blog\Entities\Category;

class CategoryController extends Controller
{

    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            $categories = Category::latest()->paginate(12);    
            
            return view('admin::pages.managecategories',compact('categories'));
        } else {
            abort('401');
        }
    }

    public function store(Request $request)
    {

        if (Auth::check() && Auth::user()->role == 'admin') {
            try{
                $category = new Category; 
                $category->category = $request->input('category');
                $category->save(); 
                Session::flash('response', 'Category item added successfully!');
            }
            catch(\Exception $e){
                if ($e->getCode() == '23000') {
                    Session::flash('failed', 'Category name already exists!');
                } else {
                    Session::flash('failed', 'Failed to add category at this time, please try again later!');
                }                
            }
            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function update(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {

            try{
                $category = Category::find($request->input('catId')); 
                $category->category = $request->input('category');
                $category->save(); 
                Session::flash('response', 'Category item updated successfully!');
            }
            catch(\Exception $e){
                if ($e->getCode() == '23000') {
                    Session::flash('failed', 'Category name already exists!');
                } else {
                    Session::flash('failed', 'Failed to update category at this time, please try again later!');
                }                
            }
            return redirect()->back();
        } else {
            abort('401');
        }
    }

    public function destroy(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            try{
                $id = $request->input('catId');
                $category = Category::find($id);
                $category->delete();
                Session::flash('response', 'Category item deleted successfully!');
            }
            catch(\Exception $e){
                Session::flash('failed', 'Failed to delete category at this time, please try again later!');         
            }
            
            return redirect()->back();
        } else {
            abort('401');
        }
    }
}
