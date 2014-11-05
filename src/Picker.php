<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace yiidreamteam\widgets\timezone;

use yii\helpers\Html;
use yii\widgets\InputWidget;

class Picker extends InputWidget
{

    const SORT_NAME   = 0;
    const SORT_OFFSET = 1;

    public $template = '{name} {offset}';

    public $sortBy = 0;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $timeZones = [];
        $timeZonesOutput = [];
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        foreach (\DateTimeZone::listIdentifiers(\DateTimeZone::ALL) as $timeZone) {
            $now->setTimezone(new \DateTimeZone($timeZone));
            $timeZones[] = [$now->format('P'), $timeZone];
        }

        if($this->sortBy == static::SORT_OFFSET)
            array_multisort($timeZones);
        
        foreach ($timeZones as $timeZone) {
            $content = preg_replace_callback("/{\\w+}/", function ($matches) use ($timeZone) {
                switch ($matches[0]) {
                    case '{name}':
                        return $timeZone[1];
                    case '{offset}':
                        return $timeZone[0];
                    default:
                        return $matches[0];
                }
            }, $this->template);
            $timeZonesOutput[$timeZone[1]] = $content;
        }

        echo Html::activeDropDownList($this->model, $this->attribute, $timeZonesOutput, $this->options);
    }
}