<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div><h5 class="fw-bold mb-0">Task Board</h5><small class="text-muted">Plan, assign and track team tasks</small></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal" data-mode="create"><i class="bi bi-plus-lg"></i> Add Task</button>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-secondary-subtle text-secondary"><i class="bi bi-list-task"></i></div>
                <div class="ms-3">
                    <div class="stat-label">To Do</div>
                    <div class="stat-value"><?= $stats['todo'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info-subtle text-info"><i class="bi bi-arrow-repeat"></i></div>
                <div class="ms-3">
                    <div class="stat-label">In Progress</div>
                    <div class="stat-value"><?= $stats['in_progress'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-check2-circle"></i></div>
                <div class="ms-3">
                    <div class="stat-label">Done</div>
                    <div class="stat-value"><?= $stats['done'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-danger-subtle text-danger"><i class="bi bi-alarm"></i></div>
                <div class="ms-3">
                    <div class="stat-label">Overdue</div>
                    <div class="stat-value"><?= $stats['overdue'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$priorityBadge = [
    'low'    => 'bg-secondary',
    'medium' => 'bg-info',
    'high'   => 'bg-warning text-dark',
    'urgent' => 'bg-danger',
];
$columns = [
    'todo'        => ['To Do', 'bi-list-task', 'border-secondary', 'bg-secondary-subtle text-secondary'],
    'in_progress' => ['In Progress', 'bi-arrow-repeat', 'border-info', 'bg-info-subtle text-info'],
    'done'        => ['Done', 'bi-check2-circle', 'border-success', 'bg-success-subtle text-success'],
];
$order = ['todo' => 0, 'in_progress' => 1, 'done' => 2];
$tasksByStatus = ['todo' => [], 'in_progress' => [], 'done' => []];
foreach ($tasks as $t) {
    $tasksByStatus[$t['status']][] = $t;
}
?>

<div class="row g-3">
    <?php foreach ($columns as $key => [$label, $icon, $border, $headerCls]): ?>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <strong><i class="bi <?= $icon ?> me-1 <?= $headerCls ?>"></i> <?= $label ?></strong>
                <span class="badge bg-secondary-subtle text-secondary"><?= count($tasksByStatus[$key]) ?></span>
            </div>
            <div class="card-body" style="min-height:260px">
                <?php if (empty($tasksByStatus[$key])): ?>
                    <div class="text-center text-muted py-5"><i class="bi bi-inbox fs-2 d-block mb-2"></i>No tasks</div>
                <?php else: foreach ($tasksByStatus[$key] as $t):
                    $overdue = $t['due_date'] !== null && strtotime((string) $t['due_date']) < strtotime(date('Y-m-d')) && $t['status'] !== 'done';
                    $isFirst = $order[$t['status']] === 0;
                    $isLast  = $order[$t['status']] === 2;
                ?>
                    <div class="card task-card mb-2">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="badge <?= $priorityBadge[$t['priority']] ?? 'bg-secondary' ?>"><?= e(ucfirst($t['priority'])) ?></span>
                                <?php if ($overdue): ?><span class="badge bg-danger">Overdue</span><?php endif; ?>
                            </div>
                            <strong class="d-block"><?= e($t['title']) ?></strong>
                            <?php if ($t['description']): ?>
                                <div class="small text-muted text-truncate" style="max-width:100%" title="<?= e($t['description']) ?>"><?= e($t['description']) ?></div>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between align-items-center mt-2 small text-muted">
                                <span><i class="bi bi-person me-1"></i><?= $t['assigned_to'] ? e($t['assignee_first_name'] . ' ' . $t['assignee_last_name']) : 'Unassigned' ?></span>
                                <?php if ($t['due_date']): ?>
                                    <span class="<?= $overdue ? 'text-danger fw-semibold' : '' ?>"><i class="bi bi-calendar-event me-1"></i><?= format_date($t['due_date']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="btn-group btn-group-sm">
                                    <?php if (!$isFirst): ?>
                                        <button class="btn btn-outline-secondary" data-move data-id="<?= $t['id'] ?>" data-status="<?= array_keys($columns)[$order[$t['status']] - 1] ?>" title="Move to previous column"><i class="bi bi-arrow-left"></i></button>
                                    <?php endif; ?>
                                    <?php if (!$isLast): ?>
                                        <button class="btn btn-outline-secondary" data-move data-id="<?= $t['id'] ?>" data-status="<?= array_keys($columns)[$order[$t['status']] + 1] ?>" title="Move to next column"><i class="bi bi-arrow-right"></i></button>
                                    <?php endif; ?>
                                </div>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" data-edit
                                        data-id="<?= $t['id'] ?>"
                                        data-title="<?= e($t['title']) ?>"
                                        data-description="<?= e($t['description'] ?? '') ?>"
                                        data-assignee="<?= $t['assigned_to'] ?>"
                                        data-due="<?= e($t['due_date'] ?? '') ?>"
                                        data-priority="<?= e($t['priority']) ?>"
                                        data-status="<?= e($t['status']) ?>"
                                        title="Edit"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-outline-danger" data-remove data-id="<?= $t['id'] ?>" title="Delete"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="taskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="taskForm">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="taskId">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalTitle">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="taskTitle" class="form-control" required placeholder="e.g. Design sprint">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="taskDescription" class="form-control" rows="2" placeholder="Optional details"></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Assignee</label>
                            <select name="assigned_to" id="taskAssignee" class="form-select">
                                <option value="">Unassigned</option>
                                <?php foreach ($employees as $emp): ?>
                                    <option value="<?= $emp['id'] ?>"><?= e($emp['first_name'] . ' ' . $emp['last_name']) ?> (<?= e($emp['employee_code']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" id="taskDue" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Priority</label>
                            <select name="priority" id="taskPriority" class="form-select">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="status" id="taskStatus" class="form-select">
                                <option value="todo">To Do</option>
                                <option value="in_progress">In Progress</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');

    $('#taskModal').on('show.bs.modal', function(){
        if (!$(this).find('#taskId').val()) {
            $('#taskForm')[0].reset();
            $('#taskModalTitle').text('Add Task');
        }
    });

    $(document).on('click', '[data-edit]', function(){
        var el = $(this);
        $('#taskId').val(el.data('id'));
        $('#taskTitle').val(el.data('title'));
        $('#taskDescription').val(el.data('description'));
        $('#taskAssignee').val(el.data('assignee') || '');
        $('#taskDue').val(el.data('due'));
        $('#taskPriority').val(el.data('priority'));
        $('#taskStatus').val(el.data('status'));
        $('#taskModalTitle').text('Edit Task');
        new bootstrap.Modal(document.getElementById('taskModal')).show();
    });

    $('#taskForm').on('submit', function(e){
        e.preventDefault();
        const id = $('#taskId').val();
        const url = id ? (EMS_BASE + '/tasks/update/' + id) : (EMS_BASE + '/tasks/store');
        $.ajax({
            url: url, method: 'POST', dataType: 'json', data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){ toast(r.message, 'success'); bootstrap.Modal.getInstance(document.getElementById('taskModal')).hide(); setTimeout(function(){ location.reload(); }, 800); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(x){ toast('Error', 'error'); } }
        });
    });

    $(document).on('click', '[data-move]', function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
        $.ajax({
            url: EMS_BASE + '/tasks/status/' + id, method: 'POST', dataType: 'json', data: { _token: csrf, status: status },
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){ toast(r.message, 'success'); setTimeout(function(){ location.reload(); }, 800); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
        });
    });

    $(document).on('click', '[data-remove]', function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete task?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', confirmButtonText: 'Delete'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/tasks/delete/' + id, method: 'POST', dataType: 'json', data: { _token: csrf },
                    headers: { 'X-CSRF-TOKEN': csrf },
                    success: function(r){ toast(r.message, 'success'); setTimeout(function(){ location.reload(); }, 800); },
                    error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
                });
            }
        });
    });
});
</script>
JS;
?>
