<?php

namespace App\Http\Requests\Order;

use App\Models\Order\Order;
use App\Rules\Order\OrderCalcRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

/**
 * Class OrderCalcRequest
 *
 * @package App\Http\Requests\Order
 */
class OrderCalcRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'location_id' => 'required|integer|exists:location,id',
            'beginning_at' => 'required|date_format:Y-m-d H:i:s|after:'
                . Carbon::now()->format('Y-m-d H:i:s'),
            'ending_at' => 'required|date_format:Y-m-d H:i:s|after:beginning_at|before_or_equal:'
                . Carbon::now()->addDays(Order::DAYS_RANGE)->format('Y-m-d H:i:s'),
            'temperature' => ['required', 'integer', 'min:-50', 'max:0', new OrderCalcRule((int)$this->get('location_id'))],
            'volume' => ['required', 'integer', 'min:1', new OrderCalcRule((int)$this->get('location_id'), (float)$this->get('temperature', 0))],
        ];
    }
}
