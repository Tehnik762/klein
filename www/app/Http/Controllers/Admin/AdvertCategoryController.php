<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdvertCategory;
use Illuminate\Http\Request;

class AdvertCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $categories_active = TRUE;
        $categories = AdvertCategory::whereIsRoot()->defaultOrder()->get();
        return view('admin.category.index', compact('categories', 'categories_active'));
    }
    /**
     * Show the next level category inside the root
     *
     * @return \Illuminate\Http\Response
     */
    public function inside($id) {
        $categories_active = TRUE;
        $categories = AdvertCategory::where('parent_id', $id)->defaultOrder()->get();
        $main = AdvertCategory::whereId($id)->first();
        return view('admin.category.index', compact('categories', 'categories_active', 'main'));
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories_active = TRUE;
        $id = $request->id;
        $all = AdvertCategory::all();
        return view('admin.category.create', compact('id', 'categories_active', 'all'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:advert_categories',
            'parent_id' => 'nullable',
        ]);

        $cat = new AdvertCategory();
        $cat->register($validated['name'], $validated['parent_id'] ?? '');
         return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdvertCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(AdvertCategory $category)
    {
        $categories_active = TRUE;
        $attributes = $category->allAttributes();
        return view('admin.category.show', compact('category', 'categories_active', 'attributes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdvertCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(AdvertCategory $category)
    {

        $categories_active = TRUE;
        $all = AdvertCategory::all();
        return view('admin.category.edit', compact('category', 'categories_active', 'all'));
  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdvertCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdvertCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|unique:advert_categories,id,'.$category->id,
            'parent_id' => 'nullable',
            'slug' => 'required|unique:advert_categories,id,'.$category->id,
        ]);
        $category->update($validated);
        
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdvertCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdvertCategory $category)
    {
        $category->delete();
        return redirect(route('categories.index'))->with('info', __('admin.catdelete'));
    }

    public function first(AdvertCategory $category) {
        if ($first = $category->siblings()->defaultOrder()->first()) {
            $category->insertBeforeNode($first);
        }
        return back();
    }


    public function up(AdvertCategory $category) {
        $category->up();
        return back();
    }


    public function down(AdvertCategory $category) {
        $category->down();
        return back();
    }


    public function last(AdvertCategory $category) {
        if ($last = $category->siblings()->defaultOrder('desc')->first()) {
            $category->insertAfterNode($last);
        }
        return back();
    }
}
