@extends('layouts.app')

@section('title', 'Cadastrar Nova Categoria')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5>Cadastrar Novo Evento</h5>
            <div class="card">             
                <div class="card-body">
                    <form action="{{ route('users.store') }}" class="form" method="POST">
                        @csrf

                        @include('admin.pages.users._partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




