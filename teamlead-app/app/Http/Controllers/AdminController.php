<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use App\Models\Project;
use App\Models\Task;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::count();
        $teams = Team::count();
        $projects = Project::count();
        $tasks = Task::count();

        return view('admin.index', compact('users', 'teams', 'projects', 'tasks'));
    }

    public function users()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->back()->with('success', 'Роль пользователя обновлена.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Пользователь удален.');
    }
}
