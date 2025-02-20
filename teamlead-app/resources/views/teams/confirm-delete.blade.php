@extends('layouts.app')

@section('title', 'Удаление команды')

@section('content')
    <div class="container">
        <h1>Удаление команды</h1>
        <p>Вы уверены, что хотите удалить команду <strong>{{ $team->name }}</strong>? Это действие нельзя отменить.</p>

        <form action="{{ route('teams.destroy', $team) }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">Удалить</button>
            <a href="{{ route('teams.show', $team) }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
