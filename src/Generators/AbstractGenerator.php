<?php

namespace Based\TypeScript\Generators;

use Based\TypeScript\Contracts\Generator;
use ReflectionClass;

abstract class AbstractGenerator implements Generator
{
    protected ReflectionClass $reflection;

    public function generate(ReflectionClass $reflection): ?string
    {
        $this->reflection = $reflection;
        $this->boot();

        if (empty(trim($definition = $this->getDefinition()))) {
            return "    export type {$this->tsClassName()} = {}" . PHP_EOL;
        }

        return <<<TS
            export type {$this->tsClassName()} = {
                $definition
            }

        TS;
    }

    protected function boot(): void
    {
        //
    }

    protected function tsClassName(): string
    {
        return str_replace('\\', '.', $this->reflection->getShortName());
    }
}
