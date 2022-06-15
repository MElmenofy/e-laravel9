<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{

    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->paginate(PAGINATION_COUNT);
        return view('dashboard.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('dashboard.brands.create');
    }

    public function store(BrandRequest $request)
    {
        try {
            DB::beginTransaction();
            if (!$request->has('is_active')) {
                $request->request->add(['is_active' => 0]);
            } else {
                $request->request->add(['is_active' => 1]);
            }
            $fileName = '';
            if ($request->has('photo')) {
                $fileName = uploadImage('brands', $request->photo);
            }
            $brand = Brand::create($request->except('_token', 'photo'));
            $brand->name = $request->name;
            $brand->photo = $fileName;
            $brand->save();
            DB::commit();
            return redirect()->route('admin.brands')->with('success', __('Item created successfully'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.brands')->with('error', __('Something went wrong!'));
        }

    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->route('admin.brands')->with('error', __('Item not found'));
        } else {
            return view('dashboard.brands.edit', compact('brand'));
        }
    }

    public function update(BrandRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $brand = Brand::find($id);
            if (!$brand) {
                return redirect()->route('admin.brands')->with('error', __('Item not found'));
            } else {
                if($request->has('photo')){
                    $fileName = uploadImage('brands', $request->photo);
                    Brand::where('id', $id)->update(['photo' => $fileName]);
                }

                if (!$request->has('is_active')) {
                    $request->request->add(['is_active' => 0]);
                } else {
                    $request->request->add(['is_active' => 1]);
                }
                $brand->update($request->except('_token', 'photo', 'id'));
                $brand->name = $request->name;
                $brand->save();
                DB::commit();
                return redirect()->route('admin.brands')->with('success', __('Item updated successfully'));
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.brands')->with('error', __('Something went wrong!'));
        }
    }

    public function destroy($id){
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->route('admin.brands')->with('error', __('Item not found'));
        } else {
            $brand->delete();
            return redirect()->route('admin.brands')->with('success', __('Item deleted successfully'));
        }
    }


    }
