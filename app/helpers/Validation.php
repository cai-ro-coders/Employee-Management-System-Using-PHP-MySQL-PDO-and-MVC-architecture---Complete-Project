<?php
declare(strict_types=1);

use App\Core\Security;
use App\Core\Session;

/**
 * Lightweight validation helper. Returns list of error messages.
 *
 * Usage:
 *   $v = new Validation($_POST, ['email' => 'required|email', 'name' => 'required|min:3|max:50']);
 *   if ($v->passes()) { ... } else { $v->errors(); }
 */
class Validation
{
    protected array $data;
    protected array $rules;
    protected array $messages = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->validate();
    }

    public function passes(): bool
    {
        return empty($this->messages);
    }

    public function fails(): bool
    {
        return !$this->passes();
    }

    public function errors(): array
    {
        return $this->messages;
    }

    public function errorsHtml(): string
    {
        $html = '<ul class="mb-0">';
        foreach ($this->messages as $message) {
            $html .= '<li>' . Security::e($message) . '</li>';
        }
        return $html . '</ul>';
    }

    protected function validate(): void
    {
        foreach ($this->rules as $field => $ruleString) {
            $value = $this->data[$field] ?? null;
            foreach (explode('|', $ruleString) as $rule) {
                $this->runRule($field, $value, $rule);
            }
        }
    }

    protected function runRule(string $field, $value, string $rule): void
    {
        $label = ucwords(str_replace('_', ' ', $field));

        if ($rule === 'required' && (trim((string) $value) === '' || $value === null)) {
            $this->messages[$field][] = "The {$label} field is required.";
            return;
        }

        if ($rule === 'email' && $value !== '' && $value !== null && !Security::isValidEmail((string) $value)) {
            $this->messages[$field][] = "The {$label} must be a valid email address.";
        }

        if ($rule === 'url' && $value !== '' && $value !== null && !Security::isValidUrl((string) $value)) {
            $this->messages[$field][] = "The {$label} must be a valid URL.";
        }

        if ($rule === 'numeric' && $value !== '' && $value !== null && !is_numeric($value)) {
            $this->messages[$field][] = "The {$label} must be a number.";
        }

        if ($rule === 'integer' && $value !== '' && $value !== null && filter_var($value, FILTER_VALIDATE_INT) === false) {
            $this->messages[$field][] = "The {$label} must be an integer.";
        }

        if ($rule === 'date' && $value !== '' && $value !== null && strtotime((string) $value) === false) {
            $this->messages[$field][] = "The {$label} must be a valid date.";
        }

        if (preg_match('/^min:(\d+)$/', $rule, $m) && mb_strlen((string) $value) < (int) $m[1]) {
            $this->messages[$field][] = "The {$label} must be at least {$m[1]} characters.";
        }

        if (preg_match('/^max:(\d+)$/', $rule, $m) && mb_strlen((string) $value) > (int) $m[1]) {
            $this->messages[$field][] = "The {$label} may not be greater than {$m[1]} characters.";
        }

        if (preg_match('/^same:(.+)$/', $rule, $m) && $value !== ($this->data[$m[1]] ?? null)) {
            $this->messages[$field][] = "The {$label} confirmation does not match.";
        }

        if (preg_match('/^unique:(.+)$/', $rule, $m)) {
            [$table, $column, $ignoreId] = array_pad(explode(',', $m[1], 3), 3, null);
            $params = [$column => $value];
            $where = $column . ' = :' . $column;
            if ($ignoreId !== null && $ignoreId !== '') {
                $where .= ' AND id != :ignore_id';
                $params['ignore_id'] = (int) $ignoreId;
            }
            $exists = \App\Core\Database::fetchColumn(
                "SELECT COUNT(*) FROM `{$table}` WHERE {$where}",
                $params,
                0
            );
            if ((int) $exists > 0) {
                $this->messages[$field][] = "The {$label} has already been taken.";
            }
        }
    }
}
