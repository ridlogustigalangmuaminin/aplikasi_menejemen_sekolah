<div class="bg-light border-end vh-100 p-3" style="width:250px;">

    <h3 class="fw-bold text-success">EduTask</h3>
    <small class="text-muted">Student Portal</small>

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn {{ request()->routeIs('dashboard') ? 'btn-success' : 'btn-light' }} w-100 text-start mb-2">
            <i class="bi bi-grid"></i> Dashboard
        </a>
        
        <a href="{{ route('task.index') }}" class="btn {{ request()->routeIs('task.*') ? 'btn-success' : 'btn-light' }} w-100 text-start mb-2">
            <i class="bi bi-journal-text"></i> Tasks
        </a>

        <a href="{{ route('categories.index') }}" class="btn {{ request()->routeIs('categories.*') ? 'btn-success' : 'btn-light' }} w-100 text-start mb-2">
            <i class="bi bi-folder"></i> Categories
        </a>

        <a href="#" class="btn {{ request()->routeIs('profile') ? 'btn-success' : 'btn-light' }} w-100 text-start mb-2">
            <i class="bi bi-person"></i> Profile
        </a>
    </div>

    <button class="btn btn-success w-100 mt-4">
        + New Task
    </button>

    <div class="position-absolute bottom-0 start-0 p-3" style="width: 250px;">
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-sm w-75 mb-2">
        Logout
    </button>
</form>
    </div>

</div>