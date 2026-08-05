<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h5 class="fw-bold mb-0">Roles & Permissions</h5><small class="text-muted">Toggle access for each role (Super Admin is fixed)</small></div>
    <a href="<?= url('roles') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Roles</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="min-width:160px">Permission</th>
                    <?php foreach ($roles as $role): ?>
                        <th class="text-center"><?= e($role['name']) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($modules as $moduleName => $perms): ?>
                <tr class="table-light"><td colspan="<?= count($roles) + 1 ?>"><strong><i class="bi bi-folder me-1"></i><?= e(ucfirst($moduleName)) ?></strong></td></tr>
                <?php foreach ($perms as $perm): ?>
                    <tr>
                        <td>
                            <?= e($perm['action_name']) ?>
                            <small class="text-muted d-block"><?= e($perm['permission_key']) ?></small>
                        </td>
                        <?php foreach ($roles as $role): ?>
                            <?php
                            $checked = isset($rolePerms[$role['id']][$perm['permission_key']]) || strtolower($role['name']) === 'super admin';
                            $disabled = strtolower($role['name']) === 'super admin';
                            $checked = $disabled ? true : $checked;
                            ?>
                            <td class="text-center">
                                <input type="checkbox" class="perm-check form-check-input"
                                       data-role="<?= $role['id'] ?>" data-perm="<?= $perm['id'] ?>"
                                       <?= $checked ? 'checked' : '' ?> <?= $disabled ? 'disabled' : '' ?>>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    $('.perm-check').on('change', function(){
        var cb = $(this);
        $.ajax({
            url: EMS_BASE + '/roles/assign', method: 'POST', dataType: 'json',
            data: { _token: $('meta[name="csrf-token"]').attr('content'), role_id: cb.data('role'), permission_id: cb.data('perm'), checked: cb.prop('checked') },
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(r){ toast(r.message, 'success'); },
            error: function(xhr){ cb.prop('checked', !cb.prop('checked')); try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(x){ toast('Error', 'error'); } }
        });
    });
});
</script>
JS;
?>