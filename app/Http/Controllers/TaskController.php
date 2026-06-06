<?php

namespace App\Http\Controllers;

use App\Models\Tugas as Task;
use App\Models\KategoriTugas as Kategori;
use App\Models\StatusTugas;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Kategori::all();
        $statuses = StatusTugas::all();
        
        return view('task.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'status' => 'required',
        'kategori_id' => 'required',
        'deadline' => 'nullable|date'
    ]);

    Task::create([
        'user_id' => auth()->id(),
        'judul_tugas' => $request->title,
        'deskripsi' => $request->description,
        'status_id' => $request->status,
        'kategori_id' => $request->kategori_id,
        'deadline' => $request->deadline,
    ]);

    return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
        abort(403);
    }

    $statuses = StatusTugas::all();
    $categories = Kategori::all();

    return view('task.edit', compact('task', 'statuses', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'judul_tugas' => 'required',
        'deskripsi' => 'nullable',
        'status_id' => 'required',
        'kategori_id' => 'required',
        'deadline' => 'nullable|date'
    ]);

    $task->judul_tugas = $request->judul_tugas; 
    $task->deskripsi   = $request->deskripsi;   
    $task->status_id   = $request->status_id;   
    $task->deadline    = $request->deadline;
    $task->save();

    return redirect()
        ->route('task.index')
        ->with('success', 'Task berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
        abort(403);
    }

    $task->delete();

    return redirect()
        ->route('task.index')
        ->with('success', 'Task berhasil dihapus');
    }
}
