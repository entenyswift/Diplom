@extends('layouts.app')

@section('title', 'Команды')

@section('content')
    <div class="container">
        <h1>Команды</h1>

        <!-- Кнопка создания команды (только для тимлидов) -->
        @if(auth()->user()->hasRole('teamlead') || auth()->user()->hasRole('admin'))
            <a href="{{ route('teams.create') }}" class="btn btn-primary mb-3">Создать команду</a>
        @endif

        @if($teams->isEmpty())
            <p>У вас пока нет команд.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Тимлид</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                    <tr>
                        <td>{{ $team->name }}</td>
                        <td>{{ $team->leader->name }}</td>
                        <td>
                            <a href="{{ route('teams.show', $team) }}" class="btn btn-info btn-sm">Просмотр</a>

                            @if(auth()->user()->id === $team->leader_id || auth()->user()->hasRole('admin'))
                                <a href="{{ route('teams.edit', $team) }}" class="btn btn-warning btn-sm">Редактировать</a>
                                <form action="{{ route('teams.destroy', $team) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Удалить команду?')">Удалить</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
