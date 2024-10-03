@extends('layouts.app')

@section('title', "Detalhes do evento {$user->name}")

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5>Detalhes do Evento {{ $user->name }}</h5>
            <div class="card">             
                <div class="card-body">
                 
                    <div class="mt-3">
                        <x-alert />
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> <strong>Nome:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"> <strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item"> <strong>Role:</strong>  
                        @if ($user->participant())
                            Admin
                        @elseif ($user->participant())
                            Participante
                        @else
                            Master
                        @endif
                       </li>           
                    </ul>            
        
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times mr-2"></i>
                            DELETAR O USUÁRIO
                         </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
