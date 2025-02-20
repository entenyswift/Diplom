@extends('layouts.app')

@section('title', 'Мои команды')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1>Мои команды</h1>
    <a href="{{ route('teams.create') }}" class="btn btn-primary">Создать команду</a>
</div>

<table class="table mt-4">
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
            <a href="{{ route('teams.show', $team) }}" class="btn btn-sm btn-info">Просмотр</a>
            @if(auth()->user()->id === $team->leader_id)
            <a href="{{ route('teams.edit', $team) }}" class="btn btn-sm btn-warning">Редактировать</a>
            <form action="{{ route('teams.destroy', $team) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
            </form>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection
