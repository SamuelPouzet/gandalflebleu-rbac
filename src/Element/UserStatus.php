<?php

namespace Gandalflebleu\Rbac\Element;

enum UserStatus
{
    case Active;
    case Retired;
    case Disabled;
}