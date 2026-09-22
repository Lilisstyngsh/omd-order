<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\NgType;
use App\Models\Product;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = RepairOrder::with(['area', 'product', 'result'])->where('user_id', $request->user()->id)->latest('order_date')->latest()->paginate(10);
        return view('user.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('user.orders.create', [
            'areas' => Area::where('is_active', true)->orderBy('category')->orderBy('name')->get(),
            'products' => Product::where('is_active', true)->orderBy('name')->get(),
            'ngTypes' => NgType::where('is_active', true)->orderBy('code')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'area_id' => ['required', 'exists:areas,id'],
            'product_id' => ['required', 'exists:products,id'],
            'model' => ['nullable', 'string', 'max:100'],
            'ng_type_id' => ['required', 'exists:ng_types,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['order_number'] = 'RO-' . now()->format('ymd') . '-' . Str::upper(Str::random(5));
        $data['order_date'] = now()->toDateString();
        $data['status'] = 'submitted';

        $order = RepairOrder::create($data);

        return redirect()->route('user.orders.show', $order)->with('success', 'Order repair berhasil dikirim ke OMD.');
    }

    public function show(Request $request, RepairOrder $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        $order->load(['area', 'product', 'ngType', 'result', 'confirmation', 'omdVerifier']);
        return view('user.orders.show', compact('order'));
    }

    public function confirm(Request $request, RepairOrder $order)
    {
        abort_unless($order->user_id === $request->user()->id, 403);
        abort_unless($order->status === 'completed', 422, 'Order belum siap dikonfirmasi.');
        $order->update(['status' => 'confirmed']);
        $order->confirmation()->updateOrCreate([], ['confirmed_by_user_id' => $request->user()->id, 'confirmed_at' => now()]);
        return back()->with('success', 'Order berhasil dikonfirmasi oleh user.');
    }
}
