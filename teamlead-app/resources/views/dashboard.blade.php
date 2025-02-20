@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <div class="container">
        <h1 class="mb-4">Личный кабинет</h1>

        <div class="row">
            <!-- Блок статистики -->
            <div class="col-md-3">
                <h4>Статистика задач</h4>
                <ul class="list-group">
                    <li class="list-group-item">Всего: {{ $statistics['total'] }}</li>
                    <li class="list-group-item">To Do: {{ $statistics['to_do'] }}</li>
                    <li class="list-group-item">В работе: {{ $statistics['in_progress'] }}</li>
                    <li class="list-group-item">Приостановлено: {{ $statistics['paused'] }}</li>
                    <li class="list-group-item">Выполнено: {{ $statistics['done'] }}</li>
                </ul>
            </div>

            <!-- Kanban-доска -->
            <div class="col-md-9">
                <h4>Доска Kanban</h4>
                <div class="row" id="kanban-board">
                    @foreach ($columns as $status => $title)
                        <div class="col-md-3">
                            <h5>{{ $title }}</h5>
                            <div class="kanban-column border p-2" data-status="{{ $status }}" style="min-height: 300px;">
                                @foreach ($tasks->where('status', $status) as $task)
                                    <div class="card mb-2 task-card" data-id="{{ $task->id }}">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1">{{ $task->title }}</h6>
                                            <p class="card-text small">{{ $task->description }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Подключаем SortableJS через CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
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
                            method: 'POST',
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
                                }
                            })
                            .catch(error => console.error('Ошибка:', error));
                    }
                });
            });
        });
    </script>
@endsection
