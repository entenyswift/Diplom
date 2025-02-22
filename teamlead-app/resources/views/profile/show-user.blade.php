@extends('layouts.app')

@section('title', 'Профиль пользователя')

@section('content')
    <div class="container">
        <h1>Профиль пользователя: {{ $user->name }}</h1>
        <p><strong>Email:</strong> {{ $user->email }}</p>

        <h3>Статус:</h3>
        <p>
            @if($user->hasRole('admin'))
                <span class="badge bg-danger">Администратор</span>
            @elseif($user->hasRole('teamlead'))
                <span class="badge bg-primary">Тимлид</span>
            @else
                <span class="badge bg-secondary">Участник</span>
            @endif
        </p>

        <h3>Команды пользователя:</h3>
        @if($user->teams->isEmpty())
            <p>Пользователь не состоит ни в одной команде.</p>
        @else
            <ul>
                @foreach($user->teams as $team)
                    <li><a href="{{ route('teams.show', $team) }}">{{ $team->name }}</a></li>
                @endforeach
            </ul>
        @endif

        <h3>Проекты пользователя:</h3>
        @if($user->projects->isEmpty())
            <p>Пользователь не участвует в проектах.</p>
        @else
            <ul>
                @foreach($user->projects as $project)
                    <li><a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a></li>
                @endforeach
            </ul>
        @endif

        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Назад</a>
    </div>
@endsection
