<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\Http\Requests\UpdateOrderStatusRequest;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer'])
            ->withCount('orderItems')              
            ->withSum('orderItems as total_qty', 'quantity')  
            ->orderBy('id', 'desc')  
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('admin.orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            foreach ($data['products'] as $p) {
                $product = Product::findOrFail($p['product_id']);
                if ($p['quantity'] > $product->stock_quantity) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['stock' => "Insufficient stock for product: {$product->name}"]);
                }
            }

            $total = 0;
            foreach ($data['products'] as $p) {
                $lineTotal = $p['quantity'] * $p['price'];
                $total += $lineTotal;
            }

            $order = Order::create([
                'customer_id' => $data['customer_id'],
                'total_amount' => $total,
                'order_date' => $data['order_date'] ? Carbon::parse($data['order_date']) : Carbon::today(),
                'status' => 'Pending',
            ]);

            foreach ($data['products'] as $p) {
                $product = Product::lockForUpdate()->findOrFail($p['product_id']);
                if ($p['quantity'] > $product->stock_quantity) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['stock' => "Insufficient stock for product: {$product->name}"]);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $p['quantity'],
                    'price' => $p['price'],
                ]);

                $product->decrement('stock_quantity', $p['quantity']);
            }

            DB::commit();
            return redirect()->route('admin.orders.index', $order->id)->with('success', 'Order created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
