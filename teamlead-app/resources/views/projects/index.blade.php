@extends('layouts.app')

@section('title', 'Проекты')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Проекты</h1>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">Создать проект</a>
    </div>

    <table class="table mt-4">
        <thead>
        <tr>
            <th>Название</th>
            <th>Описание</th>
            <th>Команда</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{ $project->name }}</td>
                <td>{{ $project->description }}</td>
                <td>{{ $project->team->name }}</td>
                <td>
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-info">Просмотр</a>
                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-warning">Редактировать</a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
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
