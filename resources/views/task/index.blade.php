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
            <div class="p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Task Repository</h2>
            <p class="text-muted mb-0">
                Manage and track your academic progress with ease.
            </p>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <div class="row">

                <div class="col-md-3">
                    <label class="form-label">
                        Filter by Category
                    </label>

                    <select class="form-select">
                        <option>All Categories</option>
                        <option>Mathematics</option>
                        <option>Computer Science</option>
                        <option>History</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">
                        Filter by Status
                    </label>

                    <select class="form-select">
                        <option>All Statuses</option>
                        <option>Pending</option>
                        <option>In Progress</option>
                        <option>Completed</option>
                    </select>
                </div>

            </div>

        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th>TASK TITLE</th>
                        <th>CATEGORY</th>
                        <th>STATUS</th>
                        <th>DEADLINE</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>
                            <div class="fw-semibold">
                                Calculus III Assignment 4
                            </div>

                            <small class="text-muted">
                                Partial Derivatives & Integrals
                            </small>
                        </td>

                        <td>Mathematics</td>

                        <td>
                            <span class="badge bg-success-subtle text-success">
                                In Progress
                            </span>
                        </td>

                        <td>Oct 24, 2023</td>

                        <td class="text-center">

                            <a href="#" class="text-dark me-2">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="#" class="text-dark me-2">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="#" class="text-danger">
                                <i class="bi bi-trash"></i>
                            </a>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="fw-semibold">
                                React Hooks Deep Dive
                            </div>

                            <small class="text-muted">
                                Final Portfolio Project
                            </small>
                        </td>

                        <td>Computer Science</td>

                        <td>
                            <span class="badge bg-warning-subtle text-warning">
                                Pending
                            </span>
                        </td>

                        <td>Oct 28, 2023</td>

                        <td class="text-center">

                            <a href="#" class="text-dark me-2">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="#" class="text-dark me-2">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="#" class="text-danger">
                                <i class="bi bi-trash"></i>
                            </a>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="fw-semibold">
                                History of Modern Europe
                            </div>

                            <small class="text-muted">
                                Critical Essay
                            </small>
                        </td>

                        <td>History</td>

                        <td>
                            <span class="badge bg-primary-subtle text-primary">
                                Completed
                            </span>
                        </td>

                        <td>Oct 15, 2023</td>

                        <td class="text-center">

                            <a href="#" class="text-dark me-2">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="#" class="text-dark me-2">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="#" class="text-danger">
                                <i class="bi bi-trash"></i>
                            </a>

                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <div class="card-footer bg-white d-flex justify-content-between">

            <small class="text-muted">
                Showing 4 of 24 tasks
            </small>

            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled">
                        <a class="page-link">«</a>
                    </li>

                    <li class="page-item active">
                        <a class="page-link">1</a>
                    </li>

                    <li class="page-item">
                        <a class="page-link">2</a>
                    </li>

                    <li class="page-item">
                        <a class="page-link">3</a>
                    </li>

                    <li class="page-item">
                        <a class="page-link">»</a>
                    </li>
                </ul>
            </nav>

        </div>

    </div>


</div>
</div>

@endsection