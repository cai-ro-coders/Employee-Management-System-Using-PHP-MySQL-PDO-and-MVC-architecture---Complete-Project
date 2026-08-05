<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div><h5 class="fw-bold mb-0">Notice Board</h5><small class="text-muted">Post and manage company announcements</small></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#noticeModal" data-mode="create"><i class="bi bi-plus-lg"></i> Post Notice</button>
</div>

<div class="row g-3">
    <?php if (empty($notices)): ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center text-muted py-5"><i class="bi bi-megaphone fs-2 d-block mb-2"></i>No notices posted yet.</div>
            </div>
        </div>
    <?php else: foreach ($notices as $n): ?>
        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0"><i class="bi bi-megaphone me-2 text-primary"></i><?= e($n['title']) ?></h6>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary" data-edit
                                data-id="<?= $n['id'] ?>"
                                data-title="<?= e($n['title']) ?>"
                                data-content="<?= e($n['content']) ?>"
                                data-target="<?= $n['target_role_id'] ?>"
                                title="Edit"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-outline-danger" data-remove data-id="<?= $n['id'] ?>" title="Delete"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    <p class="text-muted mb-3" style="white-space:pre-wrap"><?= e($n['content']) ?></p>
                    <div class="d-flex justify-content-between align-items-center small text-muted border-top pt-2">
                        <span><i class="bi bi-person me-1"></i><?= $n['posted_by'] ? e($n['first_name'] . ' ' . $n['last_name']) : 'System' ?></span>
                        <span>
                            <?php if ($n['target_role_name']): ?>
                                <span class="badge bg-primary-subtle text-primary"><?= e($n['target_role_name']) ?></span>
                            <?php endif; ?>
                            <span class="ms-1"><i class="bi bi-clock me-1"></i><?= time_ago($n['created_at']) ?></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="noticeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="noticeForm">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="noticeId">
                <div class="modal-header">
                    <h5 class="modal-title" id="noticeModalTitle">Post Notice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="noticeTitle" class="form-control" required placeholder="e.g. Office Renovation Notice">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" id="noticeContent" class="form-control" rows="4" required placeholder="Announcement details"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Target Role</label>
                        <select name="target_role_id" id="noticeTarget" class="form-select">
                            <option value="">Everyone</option>
                            <?php foreach ($roles as $r): ?>
                                <option value="<?= $r['id'] ?>"><?= e($r['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Leave as Everyone to show to all roles.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Notice</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');

    $('#noticeModal').on('hidden.bs.modal', function(){
        $('#noticeForm')[0].reset();
        $('#noticeModalTitle').text('Post Notice');
    });

    $(document).on('click', '[data-edit]', function(){
        var el = $(this);
        $('#noticeId').val(el.data('id'));
        $('#noticeTitle').val(el.data('title'));
        $('#noticeContent').val(el.data('content'));
        $('#noticeTarget').val(el.data('target') || '');
        $('#noticeModalTitle').text('Edit Notice');
        new bootstrap.Modal(document.getElementById('noticeModal')).show();
    });

    $('#noticeForm').on('submit', function(e){
        e.preventDefault();
        const id = $('#noticeId').val();
        const url = id ? (EMS_BASE + '/notices/update/' + id) : (EMS_BASE + '/notices/store');
        $.ajax({
            url: url, method: 'POST', dataType: 'json', data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){ toast(r.message, 'success'); bootstrap.Modal.getInstance(document.getElementById('noticeModal')).hide(); setTimeout(function(){ location.reload(); }, 800); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(x){ toast('Error', 'error'); } }
        });
    });

    $(document).on('click', '[data-remove]', function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete notice?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', confirmButtonText: 'Delete'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/notices/delete/' + id, method: 'POST', dataType: 'json', data: { _token: csrf },
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
