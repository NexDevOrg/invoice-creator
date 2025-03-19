<?php

namespace NexDev\InvoiceCreator\Traits;

use BadMethodCallException;
use InvalidArgumentException;

trait HasDynamicAttributes
{
    /** @var array<string, mixed> */
    private array $attributes = [];

    /** @var array<string> */
    private array $allowedAttributes = [];

    /** @var array<string> */
    private array $requiredAttributes = [];

    /**
     * @param array<int, mixed> $arguments
     */
    public function __call(string $method, array $arguments): mixed
    {
        if (str_starts_with($method, 'set')) {
            $key = lcfirst(substr($method, 3));

            if (! in_array($key, $this->getAllowedAttributes(), true)) {
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
        foreach ($this->getRequiredAttributes() as $required) {
            if (empty($this->attributes[$required])) {
                throw new InvalidArgumentException("Missing required field: {$required}");
            }
        }

        if (isset($this->attributes['email']) && ! filter_var($this->attributes['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format.');
        }
    }

    /** @return array<string> */
    protected function getAllowedAttributes(): array
    {
        return $this->allowedAttributes;
    }

    /** @return array<string> */
    protected function getRequiredAttributes(): array
    {
        return $this->requiredAttributes;
    }

    /** @param array<string> $attributes */
    protected function setAllowedAttributes(array $attributes): void
    {
        $this->allowedAttributes = $attributes;
    }

    /** @param array<string> $attributes */
    protected function setRequiredAttributes(array $attributes): void
    {
        $this->requiredAttributes = $attributes;
    }
}
