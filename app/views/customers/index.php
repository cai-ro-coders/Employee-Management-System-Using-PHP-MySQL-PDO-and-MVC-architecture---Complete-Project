<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div><h5 class="fw-bold mb-0">Customers</h5><small class="text-muted">Manage your customer base</small></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal"><i class="bi bi-plus-lg"></i> Add Customer</button>
</div>

<div class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" id="custSearch" class="form-control" placeholder="Search customers..."></div>
    <div class="col-md-3"><select id="custStatus" class="form-select"><option value="">All statuses</option><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
    <div class="col-md-2"><select id="custType" class="form-select"><option value="">All types</option><option value="individual">Individual</option><option value="business">Business</option></select></div>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="customersTable">
            <thead>
                <tr><th>Customer</th><th>Company</th><th>Contact</th><th>Type</th><th>Status</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="customerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form id="customerForm" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="custId">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalTitle">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">First Name</label><input name="first_name" id="c_first_name" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Last Name</label><input name="last_name" id="c_last_name" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Company</label><input name="company" id="c_company" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" id="c_email" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" id="c_phone" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Mobile</label><input name="mobile" id="c_mobile" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Website</label><input name="website" id="c_website" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Industry</label><input name="industry" id="c_industry" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">Type</label><select name="customer_type" id="c_type" class="form-select"><option value="individual">Individual</option><option value="business">Business</option></select></div>
                        <div class="col-md-4"><label class="form-label">Status</label><select name="status" id="c_status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
                        <div class="col-md-4"><label class="form-label">Postal Code</label><input name="postal_code" id="c_postal" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Address</label><input name="address" id="c_address" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">City</label><input name="city" id="c_city" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">State</label><input name="state" id="c_state" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">Country</label><input name="country" id="c_country" class="form-control"></div>
                        <div class="col-12"><label class="form-label">Notes</label><textarea name="notes" id="c_notes" class="form-control" rows="2"></textarea></div>
                        <div class="col-12"><label class="form-label">Profile Image</label><input type="file" name="profile_image" class="form-control" accept="image/*"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $scripts[] = <<<'JS'
<script>
$(function(){
    const csrf = $('meta[name="csrf-token"]').attr('content');
    const table = $('#customersTable').DataTable({
        processing: true,
        ajax: { url: EMS_BASE + '/customers/table', data: function(d){ d.search = $('#custSearch').val(); d.status = $('#custStatus').val(); d.type = $('#custType').val(); } },
        columns: [
            { data: null, render: function(d){ return '<strong>' + d.first_name + ' ' + d.last_name + '</strong>'; } },
            { data: 'company' },
            { data: null, render: function(d){ return '<div>' + (d.email||'') + '</div><small class="text-muted">' + (d.phone||'') + '</small>'; } },
            { data: 'customer_type', render: function(t){ return t === 'business' ? '<span class="badge bg-info">Business</span>' : '<span class="badge bg-secondary">Individual</span>'; } },
            { data: 'status', render: function(s){ return s === 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; } },
            { data: null, orderable: false, render: function(d){
                return '<button class="btn btn-sm btn-outline-primary btn-edit" data-id="' + d.id + '"><i class="bi bi-pencil"></i></button> ' +
                       '<button class="btn btn-sm btn-outline-danger btn-del" data-id="' + d.id + '"><i class="bi bi-trash"></i></button>';
            } }
        ]
    });

    $('#custSearch, #custStatus, #custType').on('input change', function(){ table.ajax.reload(); });

    // Reset modal on open
    $('#customerModal').on('show.bs.modal', function(){ $('#customerForm')[0].reset(); $('#custId').val(''); $('#customerModalTitle').text('Add Customer'); });

    $(document).on('click', '.btn-edit', function(){
        var id = $(this).data('id');
        $.ajax({ url: EMS_BASE + '/customers/table', data: {}, success: function(r){
            var row = r.data.find(function(x){ return x.id == id; });
            if (!row) return;
            $('#custId').val(row.id); $('#custFirst_name').val(row.first_name); $('#custLast_name').val(row.last_name); // no-op
            $('#c_first_name').val(row.first_name); $('#c_last_name').val(row.last_name); $('#c_company').val(row.company);
            $('#c_email').val(row.email); $('#c_phone').val(row.phone); $('#c_mobile').val(row.mobile);
            $('#c_website').val(row.website); $('#c_industry').val(row.industry); $('#c_type').val(row.customer_type);
            $('#c_status').val(row.status); $('#c_address').val(row.address); $('#c_city').val(row.city);
            $('#c_state').val(row.state); $('#c_country').val(row.country); $('#c_postal').val(row.postal_code);
            $('#c_notes').val(row.notes); $('#customerModalTitle').text('Edit Customer');
            new bootstrap.Modal(document.getElementById('customerModal')).show();
        }});
    });

    $('#customerForm').on('submit', function(e){
        e.preventDefault();
        var fd = new FormData(this); fd.append('_token', csrf);
        var id = $('#custId').val();
        var url = id ? (EMS_BASE + '/customers/update/' + id) : (EMS_BASE + '/customers/store');
        $.ajax({
            url: url, method: 'POST', data: fd, processData: false, contentType: false, dataType: 'json',
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(r){ toast(r.message, 'success'); bootstrap.Modal.getInstance(document.getElementById('customerModal')).hide(); table.ajax.reload(); },
            error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } }
        });
    });

    $(document).on('click', '.btn-del', function(){
        var id = $(this).data('id');
        Swal.fire({ title: 'Delete customer?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', confirmButtonText: 'Delete' })
        .then(function(result){
            if (result.isConfirmed) {
                $.ajax({ url: EMS_BASE + '/customers/delete/' + id, method: 'POST', dataType: 'json', data: { _token: csrf }, headers: { 'X-CSRF-TOKEN': csrf },
                    success: function(r){ toast(r.message, 'success'); table.ajax.reload(); },
                    error: function(xhr){ try { toast(JSON.parse(xhr.responseText).message, 'error'); } catch(e){ toast('Error', 'error'); } } });
            }
        });
    });
});
</script>
JS;
?>