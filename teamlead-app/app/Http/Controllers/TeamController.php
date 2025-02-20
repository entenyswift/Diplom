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
        $teams = Team::with('leader', 'users')->get();
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

        $team->users()->attach(Auth::id()); // Тимлид автоматически добавляется в команду

        return redirect()->route('teams.index')->with('success', 'Команда создана!');
    }

    public function show(Team $team)
    {
        return view('teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team->update(['name' => $request->name]);

        return redirect()->route('teams.index')->with('success', 'Команда обновлена!');
    }

    public function destroy(Team $team)
    {
        $this->authorize('delete', $team);

        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Команда удалена!');
    }
}
