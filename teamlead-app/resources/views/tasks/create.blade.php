@extends('layouts.app')

@section('title', 'Создать задачу')

@section('content')
    <h1>Создать задачу</h1>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Название задачи</label>
            <input type="text" class="form-control" name="title" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Описание</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Проект</label>
            <select name="project_id" class="form-select" required>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Статус</label>
            <select name="status" class="form-select" required>
                <option value="to_do">To Do</option>
                <option value="in_progress">In Progress</option>
                <option value="done">Done</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Создать задачу</button>
    </form>
@endsection
