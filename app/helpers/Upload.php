<?php
declare(strict_types=1);

use App\Core\Config;

/**
 * File upload helper with secure handling.
 */
class Upload
{
    public static function store(array $file, string $subdir = '', ?array $allowed = null, ?int $maxSize = null): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $tmpPath        = $file['tmp_name'];
        $originalName   = basename($file['name']);
        $extension      = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $size           = (int) $file['size'];

        $allowed    = $allowed ?? Config::get('uploads.allowed', []);
        $maxSize    = $maxSize ?? (int) Config::get('uploads.max_size', 5242880);
        $basePath   = rtrim(Config::get('uploads.path', UPLOAD_PATH), '/');

        if (!in_array($extension, $allowed, true)) {
            throw new RuntimeException("File type .{$extension} is not allowed.");
        }
        if ($size > $maxSize) {
            throw new RuntimeException('File exceeds the maximum upload size.');
        }

        // Validate real image for image extensions
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            $info = @getimagesize($tmpPath);
            if ($info === false) {
                throw new RuntimeException('Uploaded file is not a valid image.');
            }
        }

        $dir = $basePath . ($subdir !== '' ? '/' . trim($subdir, '/') : '');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $newName = date('YmdHis') . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
        $target  = $dir . '/' . $newName;

        if (!move_uploaded_file($tmpPath, $target)) {
            throw new \RuntimeException('Failed to move uploaded file.');
        }

        return ($subdir !== '' ? trim($subdir, '/') . '/' : '') . $newName;
    }

    public static function delete(?string $path): void
    {
        if ($path) {
            $full = Config::get('uploads.path', UPLOAD_PATH) . '/' . $path;
            if (is_file($full)) {
                @unlink($full);
            }
        }
    }
}