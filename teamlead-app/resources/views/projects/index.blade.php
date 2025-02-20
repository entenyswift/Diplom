@extends('layouts.app')

@section('title', 'Проекты')

@section('content')
    <div class="container">
        <h1>Проекты</h1>

        <!-- Кнопка создания проекта (только для тимлидов) -->
        @if(auth()->user()->hasRole('teamlead') || auth()->user()->hasRole('admin'))
            <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Создать проект</a>
        @endif

        @if($projects->isEmpty())
            <p>У вас пока нет проектов.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Команда</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->team->name }}</td>
                        <td>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-info btn-sm">Просмотр</a>

                            @if(auth()->user()->id === $project->team->leader_id || auth()->user()->hasRole('admin'))
                                <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning btn-sm">Редактировать</a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Удалить проект?')">Удалить</button>
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
