<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Requests\TagsRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{

    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')->paginate(PAGINATION_COUNT);
        return view('dashboard.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('dashboard.tags.create');
    }

    public function store(TagsRequest $request)
    {
        try {
            DB::beginTransaction();
            $tag = Tag::create(['slug' => $request->slug]);
            $tag->name = $request->name;
            $tag->save();
            DB::commit();
            return redirect()->route('admin.tags')->with('success', __('Item created successfully'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.tags')->with('error', __('Something went wrong!'));
        }

    }

    public function edit($id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return redirect()->route('admin.tags')->with('error', __('Item not found'));
        } else {
            return view('dashboard.tags.edit', compact('tag'));
        }
    }

    public function update(TagsRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $tag = Tag::find($id);
            if (!$tag) {
                return redirect()->route('admin.tags')->with('error', __('Item not found'));
            } else {
                $tag->update($request->except('_token', 'id'));
                $tag->name = $request->name;
                $tag->save();
                DB::commit();
                return redirect()->route('admin.tags')->with('success', __('Item updated successfully'));
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('admin.tags')->with('error', __('Something went wrong!'));
        }
    }

    public function destroy($id){
        $tag = Tag::find($id);
        if (!$tag) {
            return redirect()->route('admin.tags')->with('error', __('Item not found'));
        } else {
            $tag->delete();
            return redirect()->route('admin.tags')->with('success', __('Item deleted successfully'));
        }
    }


    }
