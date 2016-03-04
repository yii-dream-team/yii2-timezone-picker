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

    /**
     * DateTimeZone Constants for better access.
     */
    const AFRICA        = \DateTimeZone::AFRICA;
    const AMERICA       = \DateTimeZone::AMERICA;
    const ANTARCTICA    = \DateTimeZone::ANTARCTICA;
    const ARCTIC        = \DateTimeZone::ARCTIC;
    const ASIA          = \DateTimeZone::ASIA;
    const ATLANTIC      = \DateTimeZone::ATLANTIC;
    const AUSTRALIA     = \DateTimeZone::AUSTRALIA;
    const EUROPE        = \DateTimeZone::EUROPE;
    const INDIAN        = \DateTimeZone::INDIAN;
    const PACIFIC       = \DateTimeZone::PACIFIC;
    const UTC           = \DateTimeZone::UTC;
    const ALL           = \DateTimeZone::ALL;
    const ALL_WITH_BC   = \DateTimeZone::ALL_WITH_BC;
    const PER_COUNTRY   = \DateTimeZone::PER_COUNTRY;


    public $template = '{name} {offset}';

    public $sortBy = 0;
    
    /** @var string|null  */
    public $selection = null;

    /**
     * One of DateTimeZone class constants
     * Choosing DateTimeZones to obtain.
     * @var null | integer
     */
    public $what = self::ALL;

    /**
     * A two-letter ISO 3166-1 compatible country code.
     * This option is only used when $what is set to DateTimeZone::PER_COUNTRY
     * @var string
     */
    public $country = 'US';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $timeZones = [];
        $timeZonesOutput = [];
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        foreach (\DateTimeZone::listIdentifiers($this->what, $this->country) as $timeZone) {
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

        if($this->hasModel()){
            echo Html::activeDropDownList($this->model, $this->attribute, $timeZonesOutput, $this->options);
        }else{
            echo Html::dropDownList($this->name, $this->selection, $timeZonesOutput, $this->options);
        }
    }
}
