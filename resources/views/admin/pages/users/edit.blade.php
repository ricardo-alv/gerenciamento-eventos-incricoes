@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5>Editar a Categoria</h5>
            <div class="card">             
                <div class="card-body">
                    <form action="{{ route('users.update',$user->id) }}" class="form" method="POST">
                        @csrf
                        @method('PUT')

                        @include('admin.pages.users._partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




