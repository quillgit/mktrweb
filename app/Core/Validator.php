<?php
/**
 * Small rule-based validator.
 *
 * Rules: required, string, int, min:n, max:n, in:a,b,c, email, url, date,
 * slug, nullable, confirmed.
 *
 * Messages come from resources/lang, because the public forms are bilingual —
 * an English visitor filing a grievance should not be told "wajib diisi".
 */

namespace Mktr\Core;

class Validator
{
    /** @var array */
    private $data;
    /** @var array<string,string[]> */
    private $errors = [];
    /** @var array<string,string> */
    private $labels;

    public function __construct(array $data, array $labels = [])
    {
        $this->data   = $data;
        $this->labels = $labels;
    }

    /**
     * @param array<string,string> $rules field => 'required|max:255'
     */
    public function validate(array $rules): bool
    {
        foreach ($rules as $field => $ruleString) {
            $rulesList = explode('|', $ruleString);
            $value     = isset($this->data[$field]) ? $this->data[$field] : null;
            $nullable  = in_array('nullable', $rulesList, true);

            if ($nullable && ($value === null || $value === '')) {
                continue;
            }

            foreach ($rulesList as $rule) {
                if ($rule === 'nullable') {
                    continue;
                }

                $parameter = '';
                if (strpos($rule, ':') !== false) {
                    list($rule, $parameter) = explode(':', $rule, 2);
                }

                $this->applyRule($field, $value, $rule, $parameter);
            }
        }

        return $this->errors === [];
    }

    /**
     * @param mixed $value
     */
    private function applyRule(string $field, $value, string $rule, string $parameter): void
    {
        $label = isset($this->labels[$field]) ? $this->labels[$field] : str_replace('_', ' ', $field);

        switch ($rule) {
            case 'required':
                if ($value === null || (is_string($value) && trim($value) === '') || $value === []) {
                    $this->add($field, Lang::get('validation.required', ['field' => $label]));
                }
                break;

            case 'string':
                if ($value !== null && !is_string($value)) {
                    $this->add($field, Lang::get('validation.string', ['field' => $label]));
                }
                break;

            case 'int':
                if ($value !== null && filter_var($value, FILTER_VALIDATE_INT) === false) {
                    $this->add($field, Lang::get('validation.int', ['field' => $label]));
                }
                break;

            case 'min':
                if (is_string($value) && mb_strlen($value) < (int) $parameter) {
                    $this->add($field, Lang::get('validation.min', ['field' => $label, 'n' => (int) $parameter]));
                }
                break;

            case 'max':
                if (is_string($value) && mb_strlen($value) > (int) $parameter) {
                    $this->add($field, Lang::get('validation.max', ['field' => $label, 'n' => (int) $parameter]));
                }
                break;

            case 'in':
                $allowed = explode(',', $parameter);
                if (!in_array((string) $value, $allowed, true)) {
                    $this->add($field, Lang::get('validation.in', ['field' => $label]));
                }
                break;

            case 'email':
                if (filter_var((string) $value, FILTER_VALIDATE_EMAIL) === false) {
                    $this->add($field, Lang::get('validation.email', ['field' => $label]));
                }
                break;

            case 'url':
                if (filter_var((string) $value, FILTER_VALIDATE_URL) === false) {
                    $this->add($field, Lang::get('validation.url', ['field' => $label]));
                }
                break;

            case 'slug':
                if (preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', (string) $value) !== 1) {
                    $this->add($field, Lang::get('validation.slug', ['field' => $label]));
                }
                break;

            case 'date':
                if (strtotime((string) $value) === false) {
                    $this->add($field, Lang::get('validation.date', ['field' => $label]));
                }
                break;

            case 'confirmed':
                $other = isset($this->data[$field . '_confirmation']) ? $this->data[$field . '_confirmation'] : null;
                if ($value !== $other) {
                    $this->add($field, Lang::get('validation.confirmed', ['field' => $label]));
                }
                break;
        }
    }

    public function add(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function fails(): bool
    {
        return $this->errors !== [];
    }

    public function firstErrors(): array
    {
        $flat = [];
        foreach ($this->errors as $field => $messages) {
            $flat[$field] = $messages[0];
        }

        return $flat;
    }
}
