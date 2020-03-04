<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * 状态码枚举
 * Class ReturnCode
 * @package App\Enums
 */
final class ReturnCode extends Enum
{
    //成功
    const SUCCESS = 0;
    //失败
    const FAIL = 1;
    //错误
    const ERROR = 2;
}
