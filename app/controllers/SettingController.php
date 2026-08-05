<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;

class SettingController extends Controller
{
    public function index(): void
    {
        $this->requirePermission('settings.manage');

        $settings = [];
        foreach (Database::fetchAll('SELECT * FROM settings ORDER BY group_name, id') as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }

        $this->view('settings/index', [
            'title'    => 'Settings',
            'settings' => $settings,
        ]);
    }

    public function save(): void
    {
        $this->requirePermission('settings.manage');
        Request::unlessPost();
        if (!Request::validateCsrf()) {
            Session::flash('error', 'Invalid security token.');
            $this->redirectBack();
        }

        foreach (Request::all() as $key => $value) {
            if ($key === '_token' || $key === 'submit') {
                continue;
            }
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            $value = strip_tags((string) $value);
            Database::query(
                'INSERT INTO settings (setting_key, setting_value, group_name) VALUES (:k, :v, :g)
                 ON DUPLICATE KEY UPDATE setting_value = :v2',
                ['k' => $key, 'v' => $value, 'g' => 'company', 'v2' => $value]
            );
        }

        log_activity('update', 'settings', 'Updated system settings');
        Session::flash('success', 'Settings saved successfully.');
        $this->redirectBack();
    }
}