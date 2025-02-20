@extends('layouts.app')

@section('title', 'Создать проект')

@section('content')
    <h1>Создать проект</h1>

    <form method="POST" action="{{ route('projects.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Название проекта</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Описание</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Команда</label>
            <select name="team_id" class="form-select" required>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Создать проект</button>
    </form>
@endsection
