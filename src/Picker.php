<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace yiidreamteam\widgets\timezone;

use yii\bootstrap\Dropdown;
use yii\widgets\InputWidget;

class Picker extends InputWidget
{
    public function run()
    {
        $timeZones = [];
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        foreach (\DateTimeZone::listIdentifiers(\DateTimeZone::ALL) as $timeZone) {
            $now->setTimezone(new \DateTimeZone($timeZone));
            $timeZones[$timeZone] = $timeZone . ' ' . $now->format('P');
        }

        echo Dropdown::widget([
            'items' => $timeZones,
            'options' => $this->options,
        ]);
    }
}