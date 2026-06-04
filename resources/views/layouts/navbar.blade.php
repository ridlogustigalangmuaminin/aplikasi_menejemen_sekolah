<nav class="navbar navbar-light bg-white border-bottom px-4">

    <form class="d-flex w-50">
        <input
            class="form-control"
            type="search"
            placeholder="Search tasks..."
        >
    </form>

    <div class="d-flex align-items-center gap-3">

        <i class="bi bi-bell"></i>
        <i class="bi bi-question-circle"></i>

        @auth
        <div class="d-flex align-items-center">

            <img
                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama) }}"
                class="rounded-circle"
                width="40"
            >

            <div class="ms-2">
                <small class="fw-bold d-block">
                    {{ auth()->user()->nama }}
                </small>

                <small class="text-muted">
                    {{ auth()->user()->jurusan ?? 'User' }}
                </small>
            </div>

        </div>
        @endauth

    </div>

</nav>