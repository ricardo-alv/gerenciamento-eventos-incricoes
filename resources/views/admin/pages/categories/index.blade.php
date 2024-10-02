@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Categorias <a href="{{ route('categories.create') }}" class="btn btn-success"><i
                            class="fas fa-plus-square mr-2"></i>NOVA</a></h1>
                @include('admin.includes.alerts')                  
                <div class="card">       
                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('categories.search') }}" method="POST" class="form form-inline">
                                @csrf
                                <div class="col-md-6 d-flex">
                                    <input type="text" name="filter" placeholder="Pesquisar nome, descrição..."  class="form-control me-2"
                                        value="{{ $filters['filter'] ?? '' }}">
                                    <button type="submit" class="btn btn-dark">Filtrar</button>
                                </div>                              
                            </form>
                        </div>           

                        <table class="table table-condensed mt-3">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th width="300">Ações</th>
                                </tr>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>
                                            {{-- <a href="{{ route('details.category.index', $category->url) }}" class="btn btn-primary mr-2">Detalhes</a> --}}
                                            <a href="{{ route('categories.edit', $category->url) }}"
                                                class="btn btn-info mr-2">Edit</a>
                                            <a href="{{ route('categories.show', $category->url) }}"
                                                class="btn btn-warning mr-2">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer">
                        @if (isset($filters))
                            {!! $categories->appends($filters)->links() !!}
                        @else
                            {!! $categories->links() !!}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
