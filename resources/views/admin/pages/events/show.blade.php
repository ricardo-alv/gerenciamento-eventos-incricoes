@extends('layouts.app')

@section('title', "Detalhes do evento {$event->name}")

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5>Detalhes do Evento {{ $event->name }}</h5>
            <div class="card">             
                <div class="card-body">
                    @include('admin.includes.alerts')
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> <strong>Nome:</strong> {{ $event->name }}</li>
                        <li class="list-group-item"> <strong>Capacidade:</strong> {{ $event->capacity }}</li>
                        <li class="list-group-item"> <strong>URL:</strong> {{ $event->url }}</li>            
                        <li class="list-group-item"> <strong>Descrição:</strong> {{ $event->description }}</li>
                    </ul>            
        
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times mr-2"></i>
                            DELETAR O EVENTO
                         </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
