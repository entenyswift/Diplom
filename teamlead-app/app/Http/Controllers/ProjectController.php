<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('team')->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $teams = Team::all();
        return view('projects.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_id' => 'required|exists:teams,id',
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')->with('success', 'Проект создан!');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $teams = Team::all();
        return view('projects.edit', compact('project', 'teams'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_id' => 'required|exists:teams,id',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Проект обновлен!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Проект удален!');
    }
}
