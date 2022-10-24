<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $top10SoldProducts = Product::join(
            'order_detail',
            'products.id',
            '=',
            'order_detail.product_id'
        )
            ->select(['products.product_name', DB::raw('count(*) as sold')])
            ->groupBy('order_detail.product_id')
            ->orderBy('sold', 'desc')
            ->take(10)
            ->get();

        $top10TheMostOrder = Orders::select([
            'name',
            DB::raw('count(invoice_id) as orders'),
        ])
            ->groupBy('name')
            ->orderBy('orders', 'desc')
            ->take(10)
            ->get();

        $topAgentGetTheMostCustomers = Orders::select([
            'agent_name',
            DB::raw('count(*) as customers'),
        ])
            ->groupBy('agent_name')
            ->orderBy('customers', 'desc')
            ->take(10)
            ->get();

        $customers = Customers::join('users', 'users.id', '=', 'customers.id')
            ->get()
            ->count();

        return view('dashboard', [
            'top10SoldProducts' => collect($top10SoldProducts),
            'top10TheMostOrder' => collect($top10TheMostOrder),
            'topAgentGetTheMostCustomers' => collect(
                $topAgentGetTheMostCustomers
            ),
            'totalCustomers' => $customers,
        ]);
    }

    public function getUser()
    {
        $user = collect(User::find(Auth::user()->id));
        $response['data'] = $user;
        return response()->json($response);
    }

    public function getCustomers()
    {
        $customers = Customers::with('orders')->join('users', 'users.id', '=', 'customers.id')
            ->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')
            ->select(['users.*', 'customers.address'])
            ->paginate(10);
        $response['data'] = $customers;
        return response()->json($response);
    }
}
