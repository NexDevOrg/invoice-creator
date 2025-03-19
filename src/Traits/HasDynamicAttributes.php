<?php

namespace NexDev\InvoiceCreator\Traits;

use BadMethodCallException;
use InvalidArgumentException;

trait HasDynamicAttributes
{
    /** @var array<string, mixed> */
    protected array $attributes = [];

    /** @var array<string> */
    protected array $allowedAttributes = [];

    /** @var array<string> */
    protected array $requiredAttributes = [];

    /**
     * @param array<int, mixed> $arguments
     */
    public function __call(string $method, array $arguments): mixed
    {
        if (str_starts_with($method, 'set')) {
            $key = lcfirst(substr($method, 3));

            if (! in_array($key, $this->allowedAttributes, true)) {
                throw new InvalidArgumentException("Property '{$key}' is not allowed.");
            }

            if (! empty($arguments[0])) {
                $this->attributes[$key] = $arguments[0];
            }

            return $this;
        }

        if (str_starts_with($method, 'get')) {
            $key = lcfirst(substr($method, 3));

            return $this->attributes[$key] ?? null;
        }

        throw new BadMethodCallException("Method {$method} does not exist.");
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return $this->attributes;
    }

    public function validate(): void
    {
        foreach ($this->requiredAttributes as $required) {
            if (empty($this->attributes[$required])) {
                throw new InvalidArgumentException("Missing required field: {$required}");
            }
        }

        if (isset($this->attributes['email']) && ! filter_var($this->attributes['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format.');
        }
    }
}
