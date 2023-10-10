<?php

namespace Gandalflebleu\Rbac\Element;

enum UserStatus: string
{
    case Active = 'Active';
    case Retired = 'Retired';
    case Disabled = 'Disabled';

    public function getClass(): string
    {
        return match($this) {
            UserStatus::Active  => 'table-active',
            UserStatus::Retired => 'table-light',
            UserStatus::Disabled   => 'table-dark',
        };
    }
}