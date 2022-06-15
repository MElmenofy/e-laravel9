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
        $categories = Category::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::select('id', 'parent_id')->get();
        return view('dashboard.categories.create', compact('categories'));
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
            // if user choose main category then  we will set parent_id to null
            if ($request->type == 1) {
                $request->request->add(['parent_id' => null]);
            }
            // if user choose child category then  we will add parent_id

            $category = Category::create($request->except('_token'));
            $category->name = $request->name;
            $category->save();
            DB::commit();
            return redirect()->route('admin.maincategories')->with('success', __('Item created successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with('error', __('Something went wrong'));
        }
    }

    public function edit($id)
    {
        $category = Category::orderBy('id', 'DESC')->find($id);
        if (!$category) {
            return redirect()->back()->with('error', __('Item not found'));
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
                return redirect()->route('admin.maincategories')->with('error', __('Item not found'));
            } else {
                $category->update($request->all());
                $category->name = $request->name;
                $category->save();
                return redirect()->route('admin.maincategories')->with('success', __('Item Updated Successfully'));
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.maincategories')->with('error', __('Something went wrong'));
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->route('admin.maincategories')->with('error', __('Item not found'));
            } else {
                $category->delete();
                return redirect()->route('admin.maincategories')->with('success', __('Item deleted successfully'));
            }
        } catch (\Exception $e) {
        }
    }
}
