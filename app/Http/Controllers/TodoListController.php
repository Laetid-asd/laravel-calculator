<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class TodoListController extends Controller
{
    private const CACHE_KEY = 'todo_list';

    private function getTasks()
    {
        return Cache::get(self::CACHE_KEY, []);
    }

    private function saveTasks($tasks)
    {
        Cache::put(self::CACHE_KEY, $tasks, now()->addHours(24));
    }

    # ---------------- WEB ----------------
    public function index()
    {
        $tasks = $this->getTasks();
        return view('todo.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $tasks = $this->getTasks();
        $tasks[] = ['id' => uniqid(), 'title' => $request->title, 'completed' => false];
        $this->saveTasks($tasks);
        return redirect()->route('todo.index');
    }

    public function update(Request $request, $id)
    {
        $tasks = $this->getTasks();
        foreach ($tasks as &$task) {
            if ($task['id'] === $id && !$task['completed']) {
                $task['title'] = $request->title;
            }
        }
        $this->saveTasks($tasks);
        return redirect()->route('todo.index');
    }

    public function complete($id)
    {
        $tasks = $this->getTasks();
        foreach ($tasks as &$task) {
            if ($task['id'] === $id) {
                $task['completed'] = true;
            }
        }
        $this->saveTasks($tasks);
        return redirect()->route('todo.index');
    }

    public function destroy($id)
    {
        $tasks = array_filter($this->getTasks(), fn($t) => $t['id'] !== $id);
        $this->saveTasks($tasks);
        return redirect()->route('todo.index');
    }

    # ---------------- API ----------------
    public function apiIndex() { return response()->json($this->getTasks()); }

    public function apiStore(Request $request)
    {
        $tasks = $this->getTasks();
        $task = ['id' => uniqid(), 'title' => $request->title, 'completed' => false];
        $tasks[] = $task;
        $this->saveTasks($tasks);
        return response()->json($task);
    }

    public function apiUpdate(Request $request, $id)
    {
        $tasks = $this->getTasks();
        foreach ($tasks as &$task) {
            if ($task['id'] === $id && !$task['completed']) {
                $task['title'] = $request->title;
            }
        }
        $this->saveTasks($tasks);
        return response()->json($tasks);
    }

    public function apiComplete($id)
    {
        $tasks = $this->getTasks();
        foreach ($tasks as &$task) {
            if ($task['id'] === $id) {
                $task['completed'] = true;
            }
        }
        $this->saveTasks($tasks);
        return response()->json($tasks);
    }

    public function apiDestroy($id)
    {
        $tasks = array_filter($this->getTasks(), fn($t) => $t['id'] !== $id);
        $this->saveTasks($tasks);
        return response()->json(['status' => 'deleted']);
    }
}
