@extends('layouts.app')

@section('title', 'Редактировать команду')

@section('content')
    <div class="container">
        <h1>Редактировать команду</h1>

        <form action="{{ route('teams.update', $team) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label class="form-label">Название</label>
                <input type="text" name="name" value="{{ $team->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control">{{ $team->description }}</textarea>
            </div>

            <!-- Форма для добавления участников -->
            <div class="mb-3">
                <label class="form-label">Добавить участников (email)</label>
                <input type="text" name="user_identifiers[]" class="form-control"
                       placeholder="Введите email или имя участников, разделяя запятыми">
            </div>

            <button type="submit" class="btn btn-success">Сохранить изменения</button>
            <a href="{{ route('teams.show', $team) }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
@endsection
