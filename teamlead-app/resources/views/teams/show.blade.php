@extends('layouts.app')

@section('title', 'Команда: ' . $team->name)

@section('content')
    <div class="container">
        <h1>{{ $team->name }}</h1>
        <p><strong>Описание:</strong> {{ $team->description ?? 'Нет описания' }}</p>

        <h3>Участники команды</h3>

        <ul class="list-group">
            <!-- Тимлид всегда первый -->
            @foreach($team->users as $user)
                @if($user->id === $team->leader_id)
                    <li class="list-group-item bg-light">
                        <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a> ({{ $user->email }})
                        <span class="badge bg-primary">Тимлид</span>
                    </li>
                @endif
            @endforeach

            <!-- Разделитель -->
            <hr class="my-2">

            <!-- Остальные участники -->
            @foreach($team->users as $user)
                @if($user->id !== $team->leader_id)
                    <li class="list-group-item">
                        <a href="{{ route('users.show', $user) }}">{{ $user->name }}</a> ({{ $user->email }})
                        @if($user->hasRole('admin'))
                            <span class="badge bg-danger">Администратор</span>
                        @else
                            <span class="badge bg-secondary">Участник</span>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>

        <a href="{{ route('teams.index') }}" class="btn btn-secondary mt-3">Назад</a>
    </div>
@endsection
