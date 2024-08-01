<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string',
            'transport_type' => 'required|string',
            'order_type' => 'required|string',
            'services' => 'required|string',
            'order_id' => 'required|string',
            'amount' => 'required|integer',
            'status' =>  Rule::in(OrderStatus::values()),
            'number_of_tons' => 'required|integer',
            'number_of_m3' => 'required|integer',
            'receive_order_address' => 'required|string',
            'delivery_address' => 'required|string',
            'pakage_group' => 'required|string',
            'pakage_type' => 'required|string',
        ];
    }
}