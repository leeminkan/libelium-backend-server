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
 * Class QueryEnum
 * @package App\Enums
 *
 * @method static static DefaultLimitItemOnQuery()
 * @method static static DefaultOrderByColumn()
 * @method static static DescendingOrder()
 * @method static static AscendingOrder()
 */
final class QueryEnum extends Enum
{
    const DefaultLimitItemOnQuery = 10;
    const DefaultOrderByColumn = 'created_at';
    const DescendingOrder = 'DESC';
    const AscendingOrder = 'ASC';
}
