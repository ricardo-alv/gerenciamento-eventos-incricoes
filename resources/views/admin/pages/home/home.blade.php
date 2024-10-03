@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12  row">

            <div class="d-flex justify-content-between">
                <h5 class="card-title text-secondary">Eventos</h5>
                <h6 class="card-title text-success">Olá {{ Auth::user()->name }}!</h6>
            </div>

            <div class="mt-3">
                <x-alert />
            </div>

            <form method="POST" action="{{ route('dashboard.search') }}" class="mb-4">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <select name="category" class="form-select">
                            <option value="" >Selecione uma Categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                 {{ (isset($filters['category']) && $filters['category'] == $category->id) ? 'selected' : '' }}
                                 >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="date"  value="{{ $filters['start_date'] ?? '' }}" name="start_date" class="form-control" placeholder="Data Inicial">
                    </div>
                    <div class="col-md-4">
                        <input type="date"  value="{{ $filters['end_date'] ?? '' }}"  name="end_date" class="form-control" placeholder="Data Final">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
            </form>

            <div class="col-md-12">
                <hr>
            </div>

            @forelse ($events as $event)
                <div class="col-md-4 mb-3 mt-4 p-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">{{ $event->name }}</h5>
                            <p class="card-text">
                                Início: {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }} <br>
                                Término: {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') }}
                            </p>
                            <p class="card-text text-primary">
                                Tota de Vagas: {{ $event->capacity }} <br>
                                Inscritos: {{ $event->registrations_count }} <br>
                                Vagas Restantes: {{ $event->capacity - $event->registrations_count }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent text-end p-3">
                            <div class="d-flex justify-content-between mb-3">
                                <small class="text-secondary">{{ $event->category->name }}</small>

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
            @empty
                <div class="col-md-12 border p-3 rounded mt-5 d-flex flex-column justify-content-center align-items-center">
                    <p class="text-center mb-2" style="font-size:18px">Nenhum evento disponível no momento.</p>
                    @can('is-admin')
                        <a href="{{ route('events.create') }}" class="btn btn-success"><i
                                class="fas fa-plus-square mr-2"></i>Cadastrar</a>
                    @endcan
                </div>
            @endforelse
        </div>
    </div>
    </div>
@endsection
