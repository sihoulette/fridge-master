<?php

namespace App\Rules\Order;

use App\Models\Location\LocationRoom;
use App\Services\Location\LocationService;
use Illuminate\Contracts\Validation\InvokableRule;

/**
 * Class OrderCalcRule
 *
 * @package App\Rules\Order
 */
class OrderCalcRule implements InvokableRule
{
    /**
     * @var int $location
     */
    protected int $location = 0;

    /**
     * @var float $temperature
     */
    protected float $temperature = 0.00;

    /**
     * @var float $volume
     */
    protected float $volume = 0.00;

    /**
     * @param int   $location
     * @param float $temperature
     */
    public function __construct(int $location = 0, float $temperature = 0.00)
    {
        $this->location = $location;
        $this->temperature = $temperature;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed  $value
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     *
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        switch ($attribute) {
            case 'temperature' :
                $this->temperature = (float)$value;
                if ($error = $this->invalidTemperature()) {
                    $fail($error);
                }
                break;
            case 'volume' :
                $this->volume = (float)$value;
                if ($error = $this->invalidVolume()) {
                    $fail($error);
                }
                break;
        }
    }

    /**
     * Temperature validation
     *
     * @return string Error message if invalid
     * @author sihoullete
     */
    protected function invalidTemperature(): string
    {
        $validValues = [];
        $roomsState = LocationService::roomsState($this->location);
        $roomsState->each(static function ($roomStat) use (&$validValues) {
            $endValidRange = min($roomStat->temperature + LocationRoom::TEMPERATURE_OFFSET, 0);
            $startValidRange = min($roomStat->temperature - LocationRoom::TEMPERATURE_OFFSET, 0);
            $validValues = array_merge($validValues, range($startValidRange, $endValidRange));
        });

        $message = '';
        if (!in_array($notValid = $this->temperature, $validValues)) {
            $maybeRange = [];
            asort($validValues, SORT_NUMERIC);
            foreach ($validValues as $value) {
                if ($value < $notValid) {
                    $maybeRange['first'] = $value;
                } else {
                    $maybeRange['second'] = $value;
                    break;
                }
            }

            $nearest = $maybeRange['first'] ?? $maybeRange['second'];
            $message = 'The set temperature not exists! Nearest valid value ' . $nearest;
        }

        return $message;
    }

    /**
     * Free volume space validation
     *
     * @return string Error message if invalid
     * @author sihoullete
     */
    protected function invalidVolume(): string
    {
        $roomVolumes = [];
        $needTemp = $this->temperature;
        $roomsState = LocationService::roomsState($this->location);
        $roomsState->each(static function ($roomStat) use ($needTemp, &$roomVolumes) {
            $endTempRange = min($roomStat->temperature + LocationRoom::TEMPERATURE_OFFSET, 0);
            $startTempRange = min($roomStat->temperature - LocationRoom::TEMPERATURE_OFFSET, 0);
            if (in_array($needTemp, range($startTempRange, $endTempRange)) && $roomStat->free_volume > 0) {
                $roomVolumes[] = $roomStat->free_volume;
            }
        });

        $message = '';
        if ($freeVolume = array_sum($roomVolumes)) {
            if ($this->volume > $freeVolume) {
                $message = 'Not enough space! Maximum available value ' . $freeVolume;
            }
        } else {
            $message = 'There is no space for a given temperature';
        }

        return $message;
    }
}
