@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex">

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-grow-1">

            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Content -->
            <div class="container p-3">

    <div class="d-flex justify-content-between mb-3 ">
        <h2>Task List</h2>

        <a href="{{ route('task.create') }}"
            class="btn btn-primary">
            Tambah Task
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

    @forelse($tasks as $task)

    <tr>
        <td>{{ $task->judul_tugas }}</td>
        
        <td>{{ $task->status->nama_status ?? 'Tidak Ada Status' }}</td>
        
        <td>{{ $task->deadline }}</td>

        <td>
            <a href="{{ route('task.edit', $task->id) }}"
                class="btn btn-warning btn-sm">
                Edit
            </a>

            <form
                action="{{ route('task.destroy', $task->id) }}"
                method="POST"
                class="d-inline"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus task ini?')">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm">
                    Hapus
                </button>

            </form>
        </td>
    </tr>

    @empty

    <tr>
        <td colspan="4" class="text-center">
            Belum ada task
        </td>
    </tr>

    @endforelse

</tbody>

    </table>

</div>
</div>

@endsection