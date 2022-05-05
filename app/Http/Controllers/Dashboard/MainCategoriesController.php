<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::parent()->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(MainCategoryRequest $request)
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
                    return redirect()->route('admin.maincategories')->with('success', __('Category Added Successfully'));
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with('error', __('Failed'));
        }
    }

    public function edit($id)
    {
        $category = Category::orderBy('id', 'DESC')->find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'هذا القسم غير موجود');
        } else {
            return view('dashboard.categories.edit', compact('category'));
        }
    }

    public function update($id, MainCategoryRequest $request)
    {
        try {
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }
            $category = Category::find($id);
            if (!$category) {
                return redirect()->route('admin.maincategories')->with('error', 'هذا القسم غير موجود');
            } else {
                $category->update($request->all());
                $category->name = $request->name;
                $category->save();
                return redirect()->route('admin.maincategories')->with('success', __('Item Updated Successfully'));
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.maincategories')->with('error', __('Failed'));
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->route('admin.maincategories')->with('error', 'هذا القسم غير موجود');
            } else {
                $category->delete();
                return redirect()->route('admin.maincategories')->with('success', __('Item Deleted Successfully'));
            }
        }catch (\Exception $e){
        }
    }
}
