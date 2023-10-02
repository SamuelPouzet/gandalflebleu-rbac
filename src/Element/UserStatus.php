<?php

namespace Gandalflebleu\Rbac\Element;

enum UserStatus: int
{
    case Active = 1;
    case Retired = 2;
    case Disabled = 0;
}