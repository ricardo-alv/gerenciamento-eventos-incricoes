@extends('layouts.app')

@section('title', 'Editar a Categoria')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5>Editar a Categoria</h5>
            <div class="card">             
                <div class="card-body">
                    <form action="{{ route('categories.update',$category->id) }}" class="form" method="POST">
                        @csrf
                        @method('PUT')

                        @include('admin.pages.categories._partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




