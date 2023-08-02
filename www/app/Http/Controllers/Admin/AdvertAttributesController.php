<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdvertAttributes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdvertCategory;
use Illuminate\Validation\Rule;

class AdvertAttributesController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories_active = TRUE;
        $category = AdvertCategory::find(request('category'));
        $types = AdvertAttributes::typesList();
        return view('admin.attribute.create', compact('category', 'types', 'categories_active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validateAttributeRequest($request);

        $parent = AdvertCategory::find($validated['category']);
        $validated['variants'] = $this->prepareVariants($validated['variants']);
        $attributes = new AdvertAttributes($validated);
        $parent->attributes()->save($attributes);



         return redirect(route('categories.show', ['category' => $validated['category']]));
    }

    public function validateAttributeRequest(Request $request) {
        return $request->validate([
            'name' => 'required',
            'variants' => 'nullable',
            'type' => Rule::in(AdvertAttributes::typesArray()),
            'required' => 'nullable|integer',
            'sort' => 'integer|nullable',
            'category' => 'integer'
        ]);
    }

    public function prepareVariants($variants): array
    {
        return array_map('trim', explode(PHP_EOL, $variants));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdvertAttributes  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(AdvertAttributes $attribute)
    {
        $categories_active = TRUE;
        $category = AdvertCategory::find($attribute->advert_category_id);
        return view('admin.attribute.show', compact(['attribute', 'category', 'categories_active']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdvertAttributes  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(AdvertAttributes $attribute)
    {
        $category = AdvertCategory::find($attribute->advert_category_id);
        $categories_active = TRUE;
        $var = $this->convertVariantsToString($attribute['variants']);
        $types = AdvertAttributes::typesList();
        return view('admin.attribute.edit', compact(['attribute', 'category', 'types', 'var', 'categories_active']));  
    }

    public function convertVariantsToString($variants): string|null
    {
        if (!is_array($variants)) {
            return null;
        }
        return trim(implode(PHP_EOL, $variants));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdvertAttributes  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdvertAttributes $attribute)
    {
        $validated = $this->validateAttributeRequest($request);

        $validated['variants'] = $this->prepareVariants($validated['variants']);
        $attribute->update($validated);
        return redirect(route('categories.show', ['category' => $validated['category']]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdvertAttributes  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdvertAttributes $attribute)
    {
        $attribute->delete();
        return back()->with('info', __('admin.attdelete'));
   
    }
}
