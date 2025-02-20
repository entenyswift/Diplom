<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Получаем все команды, в которых пользователь является участником
        $teams = Team::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->get();

        return view('teams.index', compact('teams'));
    }


    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team = Team::create([
            'name' => $request->name,
            'leader_id' => Auth::id(),
        ]);

        // Автоматически добавляем тимлида в команду
        $team->users()->attach(Auth::id());

        return redirect()->route('teams.index')->with('success', 'Команда создана!');
    }

    public function show(Team $team)
    {
        $user = auth()->user()->load('teams');

        // Тимлид команды или участник может просматривать команду
        if ($user->id === $team->leader_id || $user->teams->contains($team)) {
            return view('teams.show', compact('team'));
        }

        abort(403, 'У вас нет доступа к этой команде.');
    }


    public function edit(Team $team)
    {
        if (auth()->user()->id !== $team->leader_id) {
            abort(403, 'Только тимлид может редактировать команду.');
        }

        return view('teams.edit', compact('team'));
    }


    public function update(Request $request, Team $team)
    {
        if (auth()->user()->id !== $team->leader_id) {
            abort(403, 'Только тимлид может редактировать команду.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Логирование перед обновлением (проверяем, приходят ли данные)
        \Log::info('Обновление команды:', $request->all());

        // Обновляем название и описание
        $team->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('teams.show', $team)->with('success', 'Команда обновлена!');
    }



    public function destroy(Team $team)
    {
        if (auth()->user()->id !== $team->leader_id) {
            abort(403, 'Только тимлид может удалить команду.');
        }

        return view('teams.confirm-delete', compact('team'));
    }


    // Метод для добавления участника в команду
    public function addMember(Request $request, Team $team)
    {
        // Проверяем, что вызывающий метод является лидером команды
        if (Auth::id() !== $team->leader_id) {
            abort(403, 'Только тимлид может добавлять участников.');
        }

        $request->validate([
            'user_identifier' => 'required|string',
        ]);

        // Поиск пользователя по email или имени
        $user = User::where('email', $request->user_identifier)
            ->orWhere('name', $request->user_identifier)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Пользователь не найден.');
        }

        if ($team->users->contains($user->id)) {
            return redirect()->back()->with('error', 'Пользователь уже состоит в команде.');
        }

        $team->users()->attach($user->id);

        return redirect()->route('teams.show', $team)->with('success', 'Участник добавлен!');
    }

    // Метод для удаления участника из команды
    public function removeMember(Request $request, Team $team)
    {
        // Проверяем, что вызывающий метод является лидером команды
        if (Auth::id() !== $team->leader_id) {
            abort(403, 'Только тимлид может удалять участников.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Лидер не может удалить самого себя
        if ($team->leader_id == $request->user_id) {
            return redirect()->back()->with('error', 'Нельзя удалить тимлида из команды.');
        }

        $team->users()->detach($request->user_id);

        return redirect()->route('teams.show', $team)->with('success', 'Участник удален!');
    }
}
