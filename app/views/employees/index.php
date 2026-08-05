<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div><h5 class="fw-bold mb-0">All Employees</h5><small class="text-muted">Search, filter and manage employees</small></div>
    <div class="d-flex gap-2">
        <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Search name, code, designation..." style="min-width:220px">
        <select class="form-select form-select-sm" id="deptFilter">
            <option value="">All Departments</option>
            <?php foreach ($departments as $d): ?><option value="<?= $d['id'] ?>"><?= e($d['name']) ?></option><?php endforeach; ?>
        </select>
        <a href="<?= url('employees/create') ?>" class="btn btn-primary btn-sm"><i class="bi bi-person-plus"></i> Add Employee</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body" id="employeesGridWrap">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-3" id="employeesGrid"></div>
        <div class="text-center text-muted py-5 d-none" id="noEmployees"><i class="bi bi-people fs-2 d-block mb-2"></i>No employees found</div>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');
    const grid = $('#employeesGrid');
    const empty = $('#noEmployees');
    let searchTimer;

    function initials(d){
        return ((d.first_name || '?')[0] + (d.last_name || '?')[0]).toUpperCase();
    }

    function badge(s){
        return s === 'active'
            ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Active</span>'
            : '<span class="badge bg-secondary"><i class="bi bi-dash-circle me-1"></i>Inactive</span>';
    }

    function salary(s){
        return Number(s || 0).toLocaleString(undefined, { minimumFractionDigits: 2 });
    }

    function render(data){
        grid.empty();
        empty.addClass('d-none');
        if (!data.length) { empty.removeClass('d-none'); return; }
        $.each(data, function(i, d){
            var avatar = d.avatar
                ? '<img src="' + EMS_BASE + '/assets/uploads/' + d.avatar + '" class="emp-card-avatar" onerror="this.style.display=\'none\'">'
                : '';
            var card = $('<div class="col"><div class="card emp-card h-100 border-0 shadow-sm">' +
                '<div class="card-body d-flex flex-column">' +
                    '<div class="d-flex align-items-center mb-3">' +
                        '<div class="position-relative">' +
                            (avatar || '<div class="emp-card-avatar emp-card-initials">' + initials(d) + '</div>') +
                            '<span class="emp-card-status ' + (d.user_status === 'active' ? 'bg-success' : 'bg-secondary') + '"></span>' +
                        '</div>' +
                        '<div class="ms-3 text-truncate">' +
                            '<strong class="d-block text-truncate">' + d.first_name + ' ' + d.last_name + '</strong>' +
                            '<small class="text-muted text-truncate d-block">' + d.email + '</small>' +
                        '</div>' +
                    '</div>' +
                    '<div class="emp-card-meta">' +
                        '<div><i class="bi bi-tag"></i><span>' + d.employee_code + '</span></div>' +
                        '<div><i class="bi bi-diagram-3"></i><span>' + (d.department_name || '-') + '</span></div>' +
                        '<div><i class="bi bi-briefcase"></i><span>' + (d.designation || '-') + '</span></div>' +
                        '<div><i class="bi bi-calendar3"></i><span>Joined ' + (d.joining_date || '-') + '</span></div>' +
                    '</div>' +
                    '<div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top">' +
                        '<strong class="emp-card-salary">' + salary(d.salary) + '</strong>' +
                        badge(d.user_status) +
                    '</div>' +
                '</div>' +
                '<div class="card-footer bg-transparent d-flex gap-2">' +
                    '<a href="' + EMS_BASE + '/employees/show/' + d.id + '" class="btn btn-sm btn-outline-info flex-fill" title="View"><i class="bi bi-eye"></i></a>' +
                    '<a href="' + EMS_BASE + '/employees/edit/' + d.id + '" class="btn btn-sm btn-outline-primary flex-fill" title="Edit"><i class="bi bi-pencil"></i></a>' +
                    '<button class="btn btn-sm btn-outline-danger flex-fill btn-del" data-id="' + d.id + '" title="Delete"><i class="bi bi-trash"></i></button>' +
                '</div>' +
            '</div></div>');
            grid.append(card);
        });
    }

    function load(){
        $.getJSON(EMS_BASE + '/employees/table', {
            search: $('#searchInput').val(),
            department: $('#deptFilter').val()
        }, function(r){
            render(r.data || []);
        });
    }

    $('#deptFilter').on('change', load);
    $('#searchInput').on('keyup', function(){ clearTimeout(searchTimer); searchTimer = setTimeout(load, 300); });

    $(document).on('click', '.btn-del', function(){
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete employee?', icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc3545', confirmButtonText: 'Delete'
        }).then(function(result){
            if (result.isConfirmed) {
                $.ajax({
                    url: EMS_BASE + '/employees/delete/' + id, method: 'POST', dataType: 'json', data: { _token: csrf },
                    headers: { 'X-CSRF-TOKEN': csrf },
                    success: function(r){ toast(r.message, 'success'); load(); },
                    error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
                });
            }
        });
    });

    load();
});
</script>
JS;
?>
