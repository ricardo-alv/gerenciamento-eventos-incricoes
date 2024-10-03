<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct(
        private Category $category

    ) {
       $this->middleware(['can:is-admin']);
    }

    public function index()
    {
        $categories = $this->category->latest()->paginate();

        return view('admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.categories.create');
    }

    public function store(StoreUpdateCategory $request)
    {
        $this->category->create($request->all());
        return redirect()->route('categories.index')
            ->with('success', 'Criada com sucesso.');
    }

    public function show(string $url)
    {
        if (!$category = $this->category->where('url', $url)->first()) {
            return redirect()->back();
        }

        return view('admin.pages.categories.show', compact('category'));
    }

    public function edit(string $url)
    {
        if (!$category = $this->category->where('url', $url)->first()) {
            return redirect()->route('categories.index');
        }

        return view('admin.pages.categories.edit', compact('category'));
    }

    public function update(StoreUpdateCategory $request, string $id)
    {
        if (!$category = $this->category->find($id)) {
            return redirect()->back();
        }

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Atualizada com sucesso.');
    }

    public function destroy(string $id)
    {
        if (!$category = $this->category->find($id)) {
            return redirect()->back();
        }

      
        if ($category->events()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Não é possível excluir a categoria, pois ela está vinculada a um ou mais eventos.');
        }      

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Excluída com sucesso.');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');
        $categories =  $this->category->searchCategory($filters['filter'] ?? '');

        return view('admin.pages.categories.index', compact('categories', 'filters'));
    }
}
