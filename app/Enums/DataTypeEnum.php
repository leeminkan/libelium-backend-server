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
 * Class DataTypeEnum
 * @package App\Enums
 *
 * @method static static DefaultLimitItemOnQuery()
 * @method static static DefaultOrderByColumn()
 * @method static static DescendingOrder()
 * @method static static AscendingOrder()
 */
final class DataTypeEnum extends Enum
{
    const Battery = 'battery';
    const Temperature = 'temperature';
}
