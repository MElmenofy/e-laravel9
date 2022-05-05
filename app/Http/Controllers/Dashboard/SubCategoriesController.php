<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::child()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.subcategories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::parent()->orderBy('id', 'DESC')->get();
        return view('dashboard.subcategories.create', compact('categories'));
    }

    public function store(SubCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
                if (!$request->has('is_active')) {
                    $request->request->add(['is_active' => 0]);
                } else {
                    $request->request->add(['is_active' => 1]);
                }
                $category = Category::create($request->except('_token'));
                    $category->name = $request->name;
                    $category->save();
            DB::commit();
                    return redirect()->route('admin.subcategories')->with('success', __('Category Added Successfully'));
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.subcategories')->with('error', __('Failed'));
        }
    }

    public function edit($id)
    {
        $category = Category::orderBy('id', 'DESC')->find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'هذا القسم غير موجود');
        } else {
            $categories = Category::parent()->orderBy('id', 'DESC')->get();
            return view('dashboard.subcategories.edit', compact('category', 'categories'));
        }
    }

    public function update($id, SubCategoryRequest $request)
    {
        try {
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }
            $category = Category::find($id);
            if (!$category) {
                return redirect()->route('admin.subcategories')->with('error', 'هذا القسم غير موجود');
            } else {
                $category->update($request->all());
                $category->name = $request->name;
                $category->save();
                return redirect()->route('admin.subcategories')->with('success', __('Item Updated Successfully'));
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.subcategories')->with('error', __('Failed'));
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->route('admin.subcategories')->with('error', 'هذا القسم غير موجود');
            } else {
                $category->delete();
                return redirect()->route('admin.subcategories')->with('success', __('Item Deleted Successfully'));
            }
        }catch (\Exception $e){
        }
    }
}
