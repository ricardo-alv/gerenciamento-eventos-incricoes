@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Eventos</h1>
                <div class="mt-3">
                    <x-alert />
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('registrations.search') }}" method="POST" class="form form-inline">
                                @csrf
                                <div class="col-md-6 d-flex">
                                    <input type="text" name="filter" placeholder="Pesquisar nome, descrição..."
                                        class="form-control me-2" value="{{ $filters['filter'] ?? '' }}">
                                    <button type="submit" class="btn btn-dark">Filtrar</button>
                                </div>
                            </form>
                        </div>

                        <table class="table table-condensed mt-3">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Capacidade</th>
                                    <th>Categoria</th>
                                    <th width="300">Ações</th>
                                </tr>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr>
                                        <td>{{ $event->name }}</td>
                                        <td>{{ $event->description }}</td>
                                        <td>{{ $event->capacity }}</td>
                                        <td>{{ $event->category->name }}</td>
                                        <td>                                      
                                            <a href="{{ route('registrations.show', $event->url) }}"
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
                            {!! $events->appends($filters)->links() !!}
                        @else
                            {!! $events->links() !!}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
