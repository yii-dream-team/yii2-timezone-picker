<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace yiidreamteam\widgets\timezone;

class Validator extends \yii\validators\Validator
{
    public function validateValue($value)
    {
        $list = \DateTimeZone::listIdentifiers();
        if (!in_array($value, $list))
            return ['Invalid timezone value', []];
    }
}