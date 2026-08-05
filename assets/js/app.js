/* EMS - global app JS */
(function () {
    'use strict';

    const $ = window.jQuery;
    const CSRF = $('meta[name="csrf-token"]').attr('content');
    const THEME_KEY = 'ems_theme';

    document.addEventListener('DOMContentLoaded', function () {
        applyTheme(localStorage.getItem(THEME_KEY) || 'light');
    });

    window.applyTheme = function (theme) {
        document.documentElement.setAttribute('data-theme', theme);
        document.documentElement.setAttribute('data-bs-theme', theme === 'dark' ? 'dark' : 'light');
        localStorage.setItem(THEME_KEY, theme);
        const icon = document.querySelector('[data-theme-toggle] i');
        if (icon) icon.className = theme === 'dark' ? 'bi bi-sun' : 'bi bi-moon-stars';
    };

    // Theme toggle
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-theme-toggle]');
        if (btn) {
            const cur = document.documentElement.getAttribute('data-theme');
            applyTheme(cur === 'dark' ? 'light' : 'dark');
        }

        // Sidebar toggle
        const sb = e.target.closest('[data-sidebar-toggle]');
        if (sb) {
            document.getElementById('sidebar').classList.toggle('open');
            document.querySelector('.sidebar-overlay').classList.toggle('show');
        }

        // Password visibility
        const pw = e.target.closest('[data-toggle-password]');
        if (pw) {
            const input = document.querySelector(pw.getAttribute('data-toggle-password'));
            const icon = pw.querySelector('i');
            if (input) {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                if (icon) icon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            }
        }

        // Global confirm-delete buttons
        const del = e.target.closest('[data-confirm]');
        if (del) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: del.getAttribute('data-message') || 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it'
            }).then(function (result) {
                if (result.isConfirmed) {
                    if (del.hasAttribute('data-form')) {
                        document.getElementById(del.getAttribute('data-form')).submit();
                    } else if (del.getAttribute('data-url')) {
                        ajaxDelete(del.getAttribute('data-url'));
                    } else {
                        window.location.href = del.href;
                    }
                }
            });
        }
    });

    // Mark all notifications read
    document.addEventListener('click', function (e) {
        const mr = e.target.closest('[data-nf-mark-read]');
        if (mr) {
            e.preventDefault();
            $.ajax({
                url: baseUrl('notifications/mark-read'),
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF },
                success: function () { window.location.reload(); }
            });
        }
    });

    // Global AJAX helper exposed to page scripts
    window.EMSAJAX = {
        post: function (url, data, onSuccess) {
            return $.ajax({
                url: url,
                method: 'POST',
                data: $.extend({ _token: CSRF }, data),
                headers: { 'X-CSRF-TOKEN': CSRF },
                dataType: 'json',
                success: onSuccess,
                error: function (xhr) {
                    try {
                        const r = JSON.parse(xhr.responseText);
                        toast(r.message || 'Request failed.', 'error');
                    } catch (ex) {
                        toast('Request failed.', 'error');
                    }
                }
            });
        },
        get: function (url, onSuccess) {
            return $.ajax({ url: url, method: 'GET', dataType: 'json', success: onSuccess });
        }
    };

    window.toast = function (message, type) {
        type = type || 'success';
        const colors = { success: 'text-bg-success', error: 'text-bg-danger', warning: 'text-bg-warning', info: 'text-bg-primary' };
        const el = document.createElement('div');
        el.className = 'toast ' + (colors[type] || colors.info);
        el.innerHTML = '<div class="toast-header"><strong class="me-auto">' + (type.charAt(0).toUpperCase() + type.slice(1)) + '</strong></div><div class="toast-body">' + (message || '') + '</div>';
        document.getElementById('toastContainer').appendChild(el);
        new bootstrap.Toast(el, { delay: 3500 }).show();
    };

    function ajaxDelete(url) {
        $.ajax({
            url: url, method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF }, data: { _token: CSRF },
            dataType: 'json',
            success: function (r) {
                toast(r.message || 'Deleted.', 'success');
                if (r.redirect) { location.href = r.redirect; } else { location.reload(); }
            },
            error: function (xhr) {
                try { toast(JSON.parse(xhr.responseText).message || 'Delete failed.', 'error'); }
                catch (ex) { toast('Delete failed.', 'error'); }
            }
        });
    }

    // Base URL from a data attribute set by layout
    function baseUrl(p) { return (window.EMS_BASE || '') + '/' + p.replace(/^\//, ''); }
})();