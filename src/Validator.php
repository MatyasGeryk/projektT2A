<?php
declare(strict_types=1);

class Validator
{
    private array $errors = [];
    
    public function required(string $field, string $value, string $message = ''): self
    {
        if ($this->hasError($field)) {
            return $this;
        }
        
        if (trim($value) === '') {
            $this->errors[$field] = $message ?: "Pole {$field} je povinné.";
        }
        
        return $this;
    }
    
    public function email(string $field, string $value, string $message = ''): self
    {
        if ($this->hasError($field) || trim($value) === '') {
            return $this;
        }
        
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?: "Neplatný formát e-mailu.";
        }
        
        return $this;
    }
    
    public function minLength(string $field, string $value, int $min, string $message = ''): self
    {
        if ($this->hasError($field) || trim($value) === '') {
            return $this;
        }
        
        if (mb_strlen($value) < $min) {
            $this->errors[$field] = $message ?: "Pole {$field} musí mít alespoň {$min} znaků.";
        }
        
        return $this;
    }
    
    public function maxLength(string $field, string $value, int $max, string $message = ''): self
    {
        if ($this->hasError($field) || trim($value) === '') {
            return $this;
        }
        
        if (mb_strlen($value) > $max) {
            $this->errors[$field] = $message ?: "Pole {$field} nesmí mít více než {$max} znaků.";
        }
        
        return $this;
    }
    
    public function pattern(string $field, string $value, string $regex, string $message = ''): self
    {
        if ($this->hasError($field) || trim($value) === '') {
            return $this;
        }
        
        if (!preg_match($regex, $value)) {
            $this->errors[$field] = $message ?: "Pole {$field} má neplatný formát.";
        }
        
        return $this;
    }
    
    public function in(string $field, string $value, array $allowed, string $message = ''): self
    {
        if ($this->hasError($field) || trim($value) === '') {
            return $this;
        }
        
        if (!in_array($value, $allowed, true)) {
            $this->errors[$field] = $message ?: "Vybraná hodnota pro pole {$field} není povolena.";
        }
        
        return $this;
    }
    
    public function isValid(): bool
    {
        return count($this->errors) === 0;
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    public function getError(string $field): ?string
    {
        return $this->errors[$field] ?? null;
    }
    
    public function hasError(string $field): bool
    {
        return isset($this->errors[$field]);
    }
}
?>
