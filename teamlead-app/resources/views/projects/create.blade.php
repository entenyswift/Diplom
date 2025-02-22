@extends('layouts.app')

@section('title', 'Создать проект')

@section('content')
    <h1>Создать проект</h1>

    <form method="POST" action="{{ route('projects.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название проекта</label>
            <input type="text" name="name" id="name" class="form-control" required>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea name="description" id="description" class="form-control"></textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Если проект привязан к конкретной команде, можно добавить выбор команды -->
        <div class="mb-3">
            <label for="team_id" class="form-label">Команда</label>
            <select name="team_id" id="team_id" class="form-select" required>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('team_id')" class="mt-2" />
        </div>

        <button type="submit" class="btn btn-success">Создать проект</button>
    </form>
@endsection
