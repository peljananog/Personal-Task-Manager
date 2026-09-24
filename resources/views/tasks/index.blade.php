<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Task Manager</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
            min-height: 100vh;
        }

        .header-title {
            color: #0f172a;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .card-custom {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .form-label {
            color: #334155;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .form-control-custom, .form-select-custom {
            background-color: #f8fafc !important;
            border: 1px solid #cbd5e1 !important;
            color: #0f172a !important;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.95rem;
        }

        .form-control-custom:focus, .form-select-custom:focus {
            background-color: #ffffff !important;
            border-color: #2563eb !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
        }

        .btn-primary-custom {
            background-color: #2563eb;
            border: none;
            color: #ffffff;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.65rem 1.25rem;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            background-color: #1d4ed8;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .table-custom {
            color: #334155;
            margin-bottom: 0;
        }

        .table-custom thead {
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            color: #475569;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table-custom tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.15s ease;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            font-weight: 600;
        }

        .badge-progress {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
            font-weight: 600;
        }

        .badge-completed {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-weight: 600;
        }

        .modal-custom {
            background-color: #ffffff;
            border-radius: 16px;
            border: none;
        }

        .text-dark-title {
            color: #0f172a !important;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 920px;">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="header-title display-6"><i class="fa-solid fa-square-check text-primary me-2"></i>Personal Task Manager</h1>
            <p class="text-secondary mb-0">Stay organized and manage your daily tasks efficiently</p>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10 text-success fw-medium mb-4 rounded-3" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card: Add New Task -->
        <div class="card card-custom mb-4">
            <div class="card-body p-4">
                <h5 class="text-dark-title mb-3"><i class="fa-solid fa-plus-circle me-2 text-primary"></i>Add New Task</h5>
                <form action="/tasks" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">Task Name *</label>
                            <input type="text" name="task_name" class="form-control form-control-custom" placeholder="What needs to be done?" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-control form-control-custom">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select form-select-custom">
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description (Optional)</label>
                            <textarea name="description" class="form-control form-control-custom" placeholder="Add additional details or notes..." rows="2"></textarea>
                        </div>
                        <div class="col-md-12 text-end mt-3">
                            <button type="submit" class="btn btn-primary-custom"><i class="fa-solid fa-plus me-2"></i>Add Task</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Card: Task List Table -->
        <div class="card card-custom">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-dark-title m-0"><i class="fa-solid fa-list-ul me-2 text-primary"></i>Your Tasks</h5>
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-semibold">Total: {{ count($tasks) }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Task Details</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                                <tr>
                                    <td style="max-width: 250px;">
                                        <div class="fw-bold text-dark fs-6">{{ $task->task_name }}</div>
                                        @if($task->description)
                                            <div class="text-muted small mt-1 text-truncate">{{ $task->description }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->due_date)
                                            <span class="small fw-medium text-secondary"><i class="fa-regular fa-calendar me-1"></i>{{ $task->due_date }}</span>
                                        @else
                                            <span class="text-muted small">No Due Date</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->status == 'Completed')
                                            <span class="badge badge-completed px-3 py-2 rounded-pill"><i class="fa-solid fa-check me-1"></i>Completed</span>
                                        @elseif($task->status == 'In Progress')
                                            <span class="badge badge-progress px-3 py-2 rounded-pill"><i class="fa-solid fa-spinner me-1"></i>In Progress</span>
                                        @else
                                            <span class="badge badge-pending px-3 py-2 rounded-pill"><i class="fa-regular fa-clock me-1"></i>Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            <!-- View Button -->
                                            <button type="button" class="btn btn-sm btn-outline-info text-dark fw-medium rounded-2 px-2" data-bs-toggle="modal" data-bs-target="#viewTaskModal{{ $task->id }}">
                                                <i class="fa-solid fa-eye me-1"></i>View
                                            </button>

                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-medium rounded-2 px-2" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">
                                                <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                                            </button>

                                            <!-- Delete Form -->
                                            <form action="/tasks/{{ $task->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger fw-medium rounded-2 px-2">
                                                    <i class="fa-solid fa-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>

                                        <!-- View Modal -->
                                        <div class="modal fade text-start" id="viewTaskModal{{ $task->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content modal-custom p-2 shadow">
                                                    <div class="modal-header border-bottom pb-3">
                                                        <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-eye me-2 text-info"></i>Task Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body py-3">
                                                        <div class="mb-3">
                                                            <label class="text-secondary small fw-semibold">Task Name</label>
                                                            <div class="fs-5 fw-bold text-dark">{{ $task->task_name }}</div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="text-secondary small fw-semibold">Description</label>
                                                            <div class="bg-light p-3 rounded-3 border text-dark">{{ $task->description ? $task->description : 'No description provided.' }}</div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-6">
                                                                <label class="text-secondary small fw-semibold">Due Date</label>
                                                                <div class="fw-medium text-dark"><i class="fa-regular fa-calendar me-1 text-primary"></i>{{ $task->due_date ? $task->due_date : 'N/A' }}</div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="text-secondary small fw-semibold">Status</label>
                                                                <div>
                                                                    @if($task->status == 'Completed')
                                                                        <span class="badge badge-completed px-3 py-2 rounded-pill"><i class="fa-solid fa-check me-1"></i>Completed</span>
                                                                    @elseif($task->status == 'In Progress')
                                                                        <span class="badge badge-progress px-3 py-2 rounded-pill"><i class="fa-solid fa-spinner me-1"></i>In Progress</span>
                                                                    @else
                                                                        <span class="badge badge-pending px-3 py-2 rounded-pill"><i class="fa-regular fa-clock me-1"></i>Pending</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-top pt-3">
                                                        <button type="button" class="btn btn-secondary px-4 rounded-2 fw-medium" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End View Modal -->

                                        <!-- Edit Modal -->
                                        <div class="modal fade text-start" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content modal-custom p-2 shadow">
                                                    <div class="modal-header border-bottom pb-3">
                                                        <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i>Edit Task</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="/tasks/{{ $task->id }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body py-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Task Name *</label>
                                                                <input type="text" name="task_name" class="form-control form-control-custom" value="{{ $task->task_name }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Description</label>
                                                                <textarea name="description" class="form-control form-control-custom" rows="3">{{ $task->description }}</textarea>
                                                            </div>
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Due Date</label>
                                                                    <input type="date" name="due_date" class="form-control form-control-custom" value="{{ $task->due_date }}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Status</label>
                                                                    <select name="status" class="form-select form-select-custom">
                                                                        <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                        <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                                        <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top pt-3">
                                                            <button type="button" class="btn btn-light border px-3 rounded-2 fw-medium" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary-custom px-4">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Edit Modal -->

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="fa-solid fa-folder-open display-6 mb-3 d-block text-secondary opacity-50"></i>
                                        No tasks found. Add your first task above!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>