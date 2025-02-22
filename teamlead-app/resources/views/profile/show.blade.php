@extends('layouts.app')

@section('title', 'Мой профиль')

@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.kanban-column').forEach(function(column) {
                new Sortable(column, {
                    group: 'kanban',
                    animation: 150,
                    onEnd: function (evt) {
                        let taskId = evt.item.getAttribute('data-id');
                        let newStatus = evt.to.getAttribute('data-status');

                        fetch(`/tasks/${taskId}/update-status`, {
                            method: 'PATCH', // Laravel требует PATCH/PUT
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ status: newStatus })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (!data.success) {
                                    alert('Ошибка обновления статуса задачи');
                                    location.reload(); // Перезагрузка в случае ошибки
                                }
                            })
                            .catch(error => console.error('Ошибка:', error));
                    }
                });
            });
        });
    </script>
    <div class="container">
        <h1>Профиль: {{ $user->name }}</h1>
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

        <h3>Мои команды:</h3>
        @if($user->teams->isEmpty())
            <p>Вы не состоите ни в одной команде.</p>
        @else
            <ul>
                @foreach($user->teams as $team)
                    <li><a href="{{ route('teams.show', $team) }}">{{ $team->name }}</a></li>
                @endforeach
            </ul>
        @endif

        <h3>Мои проекты:</h3>
        @if($user->projects->isEmpty())
            <p>Вы не участвуете в проектах.</p>
        @else
            <ul>
                @foreach($user->projects as $project)
                    <li><a href="{{ route('projects.show', $project) }}">{{ $project->name }}</a></li>
                @endforeach
            </ul>
        @endif
    </div>

@endsection
