@extends('layouts.app')

@section('title', "Detalhes da Categoria {$category->name}")

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5>Detalhes da Categoria {{ $category->name }}</h5>
            <div class="card">             
                <div class="card-body">
                    
                    <div class="mt-3">
                        <x-alert />
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> <strong>Nome:</strong> {{ $category->name }}</li>
                        <li class="list-group-item"> <strong>URL:</strong> {{ $category->url }}</li>            
                        <li class="list-group-item"> <strong>Descrição:</strong> {{ $category->description }}</li>
                    </ul>            
        
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times mr-2"></i>
                            DELETAR A CATEGORIA
                         </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
