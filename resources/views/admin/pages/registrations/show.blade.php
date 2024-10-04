@extends('layouts.app')

@section('title', "Detalhes do evento {$event->name}")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h5>Detalhes do Evento {{ $event->name }}</h5>
                <div class="card">
                    <div class="card-body">

                        <div class="mt-3">
                            <x-alert />
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Nome:</strong> <span style="color:grey">{{ $event->name }}</span></li>
                            <li class="list-group-item"><strong>Localização:</strong> <span style="color:grey">{{ $event->location }}</span></li>
                            <li class="list-group-item"><strong>Data e Hora de Início:</strong> <span style="color:grey">{{ $event->start_date }}</span></li>
                            <li class="list-group-item"><strong>Data e Hora de Término:</strong> <span style="color:grey">{{ $event->end_date }}</span></li>
                            <li class="list-group-item"><strong>Capacidade:</strong> <span style="color:grey">{{ $event->capacity }}</span></li>
                            <li class="list-group-item"><strong>Categoria:</strong> <span style="color:grey">{{ $event->category->name }}</span></li>
                        </ul>
                        

                        @if ($event->registrations->isNotEmpty())
                            <!-- Se o usuário estiver inscrito -->
                            <form action="{{ route('dashboard.destroy', $event->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Cancelar Inscrição</button>
                            </form>
                        @else
                            <!-- Se o usuário não estiver inscrito -->
                            @if ($event->capacity - $event->registrations_count != 0)
                                <form action="{{ route('dashboard.update', $event->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Participar</button>
                                </form>
                            @else
                                <button type="submit" class="btn btn-secondary" disabled>Encerrado</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
