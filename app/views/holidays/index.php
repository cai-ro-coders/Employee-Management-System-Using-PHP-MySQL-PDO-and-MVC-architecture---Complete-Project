<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div><h5 class="fw-bold mb-0">Company Holidays</h5><small class="text-muted">Manage official company holidays</small></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#holidayModal" data-mode="create"><i class="bi bi-plus-lg"></i> Add Holiday</button>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Holiday</th>
                    <th>Date(s)</th>
                    <th>Duration</th>
                    <th>Description</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($holidays)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No holidays added yet.</td></tr>
                <?php else: foreach ($holidays as $h):
                    $past = strtotime((string) $h['end_date']) < strtotime(date('Y-m-d'));
                    $single = $h['end_date'] === null || $h['end_date'] === $h['start_date'];
                    $days = $single ? 1 : ((int) ((strtotime((string) $h['end_date']) - strtotime((string) $h['start_date'])) / 86400) + 1);
                ?>
                    <tr class="<?= $past ? 'text-muted' : '' ?>">
                        <td><strong><?= e($h['event_name']) ?></strong></td>
                        <td><?= $single ? format_date($h['start_date']) : format_date($h['start_date']) . ' &ndash; ' . format_date($h['end_date']) ?></td>
                        <td><span class="badge <?= $past ? 'bg-secondary-subtle text-secondary' : 'bg-primary-subtle text-primary' ?>"><?= $days ?> day<?= $days > 1 ? 's' : '' ?></span></td>
                        <td class="text-truncate" style="max-width:240px"><?= e($h['description'] ?? '') ?></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary" data-edit data-id="<?= $h['id'] ?>" data-name="<?= e($h['event_name']) ?>" data-start="<?= e($h['start_date']) ?>" data-end="<?= e($h['end_date'] ?? '') ?>" data-desc="<?= e($h['description'] ?? '') ?>"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger" data-remove data-id="<?= $h['id'] ?>"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="holidayModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="holidayForm">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="holidayId">
                <div class="modal-header">
                    <h5 class="modal-title" id="holidayModalTitle">Add Holiday</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Holiday Name</label>
                        <input type="text" name="event_name" id="holidayName" class="form-control" required placeholder="e.g. New Year's Day">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="holidayStart" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" id="holidayEnd" class="form-control">
                            <small class="text-muted">Leave empty for a single day.</small>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="holidayDesc" class="form-control" rows="2" placeholder="Optional notes"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Holiday</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');

    $('#holidayModal').on('show.bs.modal', function(){
        if (!$(this).find('#holidayId').val()) {
            $('#holidayForm')[0].reset();
            $('#holidayModalTitle').text('Add Holiday');
        }
    });

    $(document).on('click', '[data-edit]', function(){
        var el = $(this);
        $('#holidayId').val(el.data('id'));
        $('#holidayName').val(el.data('name'));
        $('#holidayStart').val(el.data('start'));
        $('#holidayEnd').val(el.data('end'));
        $('#holidayDesc').val(el.data('desc'));
        $('#holidayModalTitle').text('Edit Holiday');
        new bootstrap.Modal(document.getElementById('holidayModal')).show();
    });

    $('#holidayForm').on('submit', function(e){
        e.preventDefault();
        const id = $('#holidayId').val();
        const url = id ? (EMS_BASE + '/holidays/update/' + id) : (EMS_BASE + '/holidays/store');
        $.ajax({
            url: url, method: 'POST', dataType: 'json', data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){ toast(r.message, 'success'); bootstrap.Modal.getInstance(document.getElementById('holidayModal')).hide(); setTimeout(function(){ location.reload(); }, 800); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(x){ toast('Error', 'error'); } }
        });
    });

    $(document).on('click', '[data-remove]', function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete holiday?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', confirmButtonText: 'Delete'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/holidays/delete/' + id, method: 'POST', dataType: 'json', data: { _token: csrf },
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
