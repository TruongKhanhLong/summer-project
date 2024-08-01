<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Str;
use App\Exceptions\InputException;
use App\Services\Base\ServiceBase;
use Illuminate\Support\Facades\Auth;
use App\Services\Base\TableBase;
use Illuminate\Http\Request;

class OrderTableService extends TableBase
{
    /**
     * Create new order
     *
     * @param array $data
     * @return mixed
     * @throws InputException
     */
    public function createOrder(Request $request)
    {
        $data = [
            'order_id' => $request->input('order_id'),
            'customer_name' => $request->input('customer_name'),
            'transport_type' => $request->input('transport_type'),
            'order_type' => $request->input('order_type'),
            'services' => $request->input('services'),
            'amount' => $request->input('amount'),
            'number_of_tons' => $request->input('number_of_tons'),
            'number_of_m3' => $request->input('number_of_m3'),
            'receive_order_address' => $request->input('receive_order_address'),
            'delivery_address' => $request->input('delivery_address'),
            'pakage_group' => $request->input('pakage_group'),
            'pakage_type' => $request->input('pakage_type'),
        ];
        $newOrder = Order::query()->create($data);
        if (!$newOrder) {
            throw new InputException("Can't create new order");
        }
        return $data;
    }
    public function updateOrder($order, $request)
    {
        $data = [
            'order_id' => $request->input('order_id'),
            'customer_name' => $request->input('customer_name'),
            'transport_type' => $request->input('transport_type'),
            'order_type' => $request->input('order_type'),
            'services' => $request->input('services'),
            'amount' => $request->input('amount'),
            'number_of_tons' => $request->input('number_of_tons'),
            'number_of_m3' => $request->input('number_of_m3'),
            'receive_order_address' => $request->input('receive_order_address'),
            'delivery_address' => $request->input('delivery_address'),
            'pakage_group' => $request->input('pakage_group'),
            'pakage_type' => $request->input('pakage_type'),
        ];

        $order->update($data);

        if (!$order) {
            throw new InputException('Order not found');
        }

        return $order;
        
        
    }
    public function deleteOrder(array $data)
    {
        return Order::query()->where('order_id', $data['order_id'])->delete();
    }
    protected $searchables = [
        'orders.order_id',
        'orders.customer_name',
    ];

    /**
     * @var string[]
     */
    protected $filterables = [
        'order_id' => 'orders.order_id',
        'customer_name' => 'orders.customer_name',

    ];

    /**
     * @var string[]
     */
    protected $orderables = [
        'order_id' => 'orders.order_id',
        'customer_name' => 'orders.customer_name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function makeNewQuery()
    {
        return Order::query()
            ->where('company_id', Auth::user()->company_id)
            ->selectRaw($this->getSelectRaw());
    }

    /**
     * Get Select Raw
     *
     * @return string
     */
    protected function getSelectRaw(): string
    {
        $fields = [
            'orders.order_id',
            'orders.booking_number',
            'orders.status',
            'orders.cut_off_time',
            'orders.order_date',
            'orders.customer_name',
        ];

        return implode(', ', $fields);
    }
}