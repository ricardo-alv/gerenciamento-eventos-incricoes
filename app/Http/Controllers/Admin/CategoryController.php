<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    private $repository;

    public function __construct(Category $category)
    {
        $this->repository = $category;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->repository->latest()->paginate();

        return view('admin.pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateCategory $request)
    {
        $this->repository->create($request->all());
        return redirect()->route('categories.index')
            ->with('message', 'Criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $url)
    {
        if (!$category = $this->repository->where('url', $url)->first()) {
            return redirect()->back();
        }

        return view('admin.pages.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $url)
    {
        if (!$category = $this->repository->where('url', $url)->first()) {
            return redirect()->route('categories.index');
        }

        return view('admin.pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateCategory $request, string $id)
    {
        if (!$category = $this->repository->find($id)) {
            return redirect()->back();
        }

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('message', 'Atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$category = $this->repository->find($id)) {
            return redirect()->back();
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('message', 'Excluída com sucesso.');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');
        $categories =  $this->repository->searchCategory($filters['filter'] ?? '');
        return view('admin.pages.categories.index', compact('categories', 'filters'));
    }
}
