<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        // Получаем задачи через связь "многие ко многим" (убедись, что в модели User определён метод tasks())
        $tasks = auth()->user()->tasks()->with('project')->get();

        // Статистика по статусам
        $statistics = [
            'total'       => $tasks->count(),
            'to_do'       => $tasks->where('status', 'to_do')->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'paused'      => $tasks->where('status', 'paused')->count(),
            'done'        => $tasks->where('status', 'done')->count(),
        ];

        // Определяем колонки доски
        $columns = [
            'to_do'       => 'To Do',
            'in_progress' => 'В работе',
            'paused'      => 'Приостановлено',
            'done'        => 'Выполнено'
        ];

        return view('dashboard', compact('tasks', 'statistics', 'columns'));
    }

    public function updateStatus(Request $request, $taskId)
    {
        $request->validate([
            'status' => 'required|in:to_do,in_progress,paused,done',
        ]);

        $task = auth()->user()->tasks()->findOrFail($taskId);
        $task->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

}
