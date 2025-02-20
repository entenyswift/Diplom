@extends('layouts.app')

@section('title', 'Создать команду')

@section('content')
    <h1>Создать команду</h1>

    <form method="POST" action="{{ route('teams.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Название команды</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <button type="submit" class="btn btn-success">Создать</button>
    </form>
@endsection
