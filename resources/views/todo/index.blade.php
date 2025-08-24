@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">✅ ToDo List</h1>

    <form action="{{ route('todo.store') }}" method="POST" class="mb-4 flex gap-2">
        @csrf
        <input type="text" name="title" placeholder="Новая задача" class="border p-2 rounded w-full" required>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Добавить</button>
    </form>

    <ul class="list-disc pl-6">
        @foreach ($tasks as $task)
            <li class="mb-2 flex justify-between items-center">
            <span class="{{ $task['completed'] ? 'line-through text-gray-500' : '' }}">
                {{ $task['title'] }}
            </span>
                <div class="flex gap-2">
                    @if(!$task['completed'])
                        <form action="{{ route('todo.complete', $task['id']) }}" method="POST">
                            @csrf
                            <button class="bg-green-500 text-white px-3 py-1 rounded">✔</button>
                        </form>
                        <form action="{{ route('todo.update', $task['id']) }}" method="POST" class="flex gap-1">
                            @csrf
                            <input type="text" name="title" value="{{ $task['title'] }}" class="border p-1 rounded">
                            <button class="bg-yellow-500 text-white px-3 py-1 rounded">💾</button>
                        </form>
                    @endif
                    <form action="{{ route('todo.destroy', $task['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded">🗑</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
