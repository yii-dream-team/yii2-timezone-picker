<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace yiidreamteam\widgets\timezone;

use yii\helpers\Html;
use yii\widgets\InputWidget;

class Picker extends InputWidget
{
    public $template = '{name} {offset}';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $timeZones = [];
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        foreach (\DateTimeZone::listIdentifiers(\DateTimeZone::ALL) as $timeZone) {
            $now->setTimezone(new \DateTimeZone($timeZone));
            $content = preg_replace_callback("/{\\w+}/", function ($matches) use ($timeZone, $now) {
                switch ($matches[0]) {
                    case '{name}':
                        return $timeZone;
                    case '{offset}':
                        return $now->format('P');
                    default:
                        return $matches[0];
                }
            }, $this->template);
            $timeZones[$timeZone] = $content;
        }

        echo Html::activeDropDownList($this->model, $this->attribute, $timeZones, $this->options);
    }
}