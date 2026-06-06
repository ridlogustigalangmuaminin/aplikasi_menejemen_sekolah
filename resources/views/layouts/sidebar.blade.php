<div class="bg-light border-end vh-100 d-flex flex-column"
     style="width:250px;">

    <!-- Atas -->
    <div class="p-3">
        <h3 class="fw-bold text-success">EduTask</h3>
        <small class="text-muted">Student Portal</small>

        <div class="mt-4 ">
            <a href="{{ route('dashboard') }}"
                class="btn {{ request()->routeIs('dashboard') ? 'btn-success' : 'btn-light' }} w-100 text-start mb-2 me-1 fs-6 d-flex align-items-center gap-1">
                    <i class="bi bi-grid "></i>
                    Dashboard
                </a>

            <a href="{{ route('task.index') }}"
               class="btn {{ request()->routeIs('task.*') ? 'btn-success' : 'btn-light' }} w-100 text-start mb-2">
                <i class="bi bi-journal-text"></i> Tugas
            </a>

            <a href="{{ route('categories.index') }}"
               class="btn {{ request()->routeIs('categories.*') ? 'btn-success' : 'btn-light' }} w-100 text-start mb-2">
                <i class="bi bi-folder"></i> Categories
            </a>

            <a href="{{ route('profile.index') }}"
               class="btn {{ request()->routeIs('profile.index') ? 'btn-success' : 'btn-light' }} w-100 text-start mb-2">
                <i class="bi bi-person"></i> Profile
            </a>
        </div>

        <button class="btn btn-success w-100 mt-3">
            + New Task
        </button>
    </div>

    <!-- Bawah -->
    <div class="mt-auto p-3 border-top bg-white">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="btn btn-outline-danger w-100 rounded-3">
                <i class="bi bi-box-arrow-left"></i>
                Logout
            </button>
        </form>
    </div>

</div>