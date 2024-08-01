<?php

namespace App\Http\Controllers;
use App\Services\OrderTableService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Order\CreateOrderRequest;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        [$search, $orders, $filters, $perPage] = $this->getTableParams($request);
        $data = OrderTableService::getInstance()->data($search, $orders, $filters, $perPage);

        return $this->sendSuccessResponse($data);
    }

    public function store(CreateOrderRequest $request)
    {
        try {
            $order = Order::create($request->all());
            return response()->json($order, 201);
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    public function show($id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->update($request->all());
        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->json(null, 204);
    }
}