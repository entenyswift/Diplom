@extends('layouts.app')

@section('title', 'Задачи')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Задачи</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Создать задачу</a>
    </div>

    <table class="table mt-4">
        <thead>
        <tr>
            <th>Название</th>
            <th>Описание</th>
            <th>Статус</th>
            <th>Проект</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>
                    @if($task->status === 'to_do')
                        <span class="badge bg-secondary">To Do</span>
                    @elseif($task->status === 'in_progress')
                        <span class="badge bg-warning">In Progress</span>
                    @else
                        <span class="badge bg-success">Done</span>
                    @endif
                </td>
                <td>{{ $task->project->name }}</td>
                <td>
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-info">Просмотр</a>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Редактировать</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
