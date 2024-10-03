@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Usuários <a href="{{ route('users.create') }}" class="btn btn-success"><i
                            class="fas fa-plus-square mr-2"></i>NOVO</a></h1>
               
                <div class="mt-3">
                    <x-alert />
                </div>

                <div class="card">
                    <div class="card-body">                      
                        <table class="table table-condensed mt-3">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>    
                                    <th>Role</th>                             
                                    <th width="300">Ações</th>
                                </tr>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>      
                                        <td>
                                            @if ($user->admin())
                                                Admin
                                            @elseif ($user->participant())
                                                Participante
                                            @else
                                                Master
                                            @endif
                                        </td>                     
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-info mr-2">Edit</a>
                                            <a href="{{ route('users.show', $user->id) }}"
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
                            {!! $users->appends($filters)->links() !!}
                        @else
                            {!! $users->links() !!}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
