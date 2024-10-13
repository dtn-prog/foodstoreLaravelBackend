<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;

class CatController extends Controller
{
    public function index()
    {
        $cats = Cat::all();
        return view('cats.index', compact('cats'));
    }

    public function create()
    {
        return view('cats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Cat::create($request->all());
        return redirect()->route('cats.index')->with('success', 'Category created successfully.');
    }

    public function show(Cat $cat)
    {
        return view('cats.show', compact('cat'));
    }

    public function edit(Cat $cat)
    {
        return view('cats.edit', compact('cat'));
    }

    public function update(Request $request, Cat $cat)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $cat->update($request->all());
        return redirect()->route('cats.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Cat $cat)
    {
        $cat->delete();
        return redirect()->route('cats.index')->with('success', 'Category deleted successfully.');
    }
}
