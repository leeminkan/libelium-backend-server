<?php
/**
 * Created by PhpStorm
 * User: khanh
 * Date: 9/23/19
 * Time: 5:15 PM
 */

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class SensorKeyEnum
 * @package App\Enums
 *
 */
final class SensorKeyEnum extends Enum
{
    const Pin = 'pin';
    const Temperature = 'temperature';
}
