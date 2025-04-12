<?php $__env->startSection('content'); ?>
<style>
    .admin-table .avatar {
        width: 38px;
        height: 38px;
        background-color: #e7f5f2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #007872;
    }

    .admin-table td {
        vertical-align: middle;
    }

    .badge-status {
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
    }

    .badge-active {
        background-color: #45d16a;
        color: white;
    }

    .badge-inactive {
        background-color: #ff6b6b;
        color: white;
    }

    .btn-add-admin {
        background-color: #007872;
        color: white;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 10px;
    }

    .modal-content {
        border-radius: 16px;
    }

    .admin-row {
        background-color: #f6fdf9;
    }

    .admin-row:not(:last-child) {
        border-bottom: 1px solid #e1f2ec;
    }

    .table-no-border td, .table-no-border th {
        border: none !important;
    }
</style>

<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Admin User Management</h4>
        <button class="btn btn-add-admin" data-bs-toggle="modal" data-bs-target="#addAdminModal">Add Admin</button>
    </div>

    <div class="table-responsive">
        <table class="table table-no-border admin-table">
            <thead class="text-muted small">
                <tr>
                    <th>Admin</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Role</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="admin-row">
                    <td class="d-flex align-items-center gap-3">
                        <div class="avatar"><i class="bi bi-person"></i></div>
                        <div>
                            <div class="fw-semibold"><?php echo e($admin->name); ?></div>
                            <div class="text-muted small"><?php echo e($admin->email); ?></div>
                        </div>
                    </td>
                    <td>
                        <span class="badge-status <?php echo e($admin->status === 'Active' ? 'badge-active' : 'badge-inactive'); ?>">
                            <?php echo e($admin->status); ?>

                        </span>
                    </td>
                    <td><?php echo e($admin->created_at->format('m/d/Y')); ?></td>
                    <td><?php echo e(ucfirst($admin->role)); ?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn border-0" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#">Deactivate</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Admin Modal -->
<div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h5 class="fw-bold text-teal">New Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="<?php echo e(route('admin.user-management.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-add-admin">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\University\SDTP\Airscape\resources\views/admin/partials/user-management.blade.php ENDPATH**/ ?>