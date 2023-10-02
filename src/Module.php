<?php

namespace Gandalflebleu\Rbac;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/Config/rbac.config.php';
        return $config;
    }
}