<?php

namespace App\Http\Controllers;
use App\Models\PurchaseInvoiceModel;
use App\Models\SaleInvoiceModel;
use App\Sale;
use Carbon\Carbon;
use App\SoldProduct;
use App\Transaction;
use App\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
//    function __construct()
//    {
//        $this->middleware('permission:purchase-invoice-edit', ['only' => ['add_credit_purchase', 'store_credit_purchase']]);
//    }
    public function index()
    {
        $auth = Auth::user();
        $totalSales = SaleInvoiceModel::where('company_id', $auth->company_id)->sum('si_amount_pay');
        $totalPurchase = PurchaseInvoiceModel::where('company_id', $auth->company_id)->sum('pi_amount_pay');

        // Monthly Sales Data
        $monthlySalesData = SaleInvoiceModel::where('company_id', $auth->company_id)
            ->selectRaw('MONTH(si_created_at) as month, SUM(si_amount_pay) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlySales = [
            'labels' => $monthlySalesData->pluck('month')->map(function ($month) {
                return date('F', mktime(0, 0, 0, $month, 1));
            })->toArray(),
            'values' => $monthlySalesData->pluck('total')->toArray()
        ];

        // Daily Sales Data
        $dailySalesData = SaleInvoiceModel::where('company_id', $auth->company_id)
            ->selectRaw('DATE(si_created_at) as date, SUM(si_amount_pay) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dailySales = [
            'labels' => $dailySalesData->pluck('date')->toArray(),
            'values' => $dailySalesData->pluck('total')->toArray()
        ];

        return view('dashboard', compact('totalSales', 'totalPurchase', 'monthlySales', 'dailySales'));
    }


    public function getMethodBalance()
    {
        $methods = PaymentMethod::all();
        $monthlyBalanceByMethod = [];
        $monthlyBalance = 0;

        foreach ($methods as $method) {
            $balance = Transaction::findByPaymentMethodId($method->id)->thisMonth()->sum('amount');
            $monthlyBalance += (float) $balance;
            $monthlyBalanceByMethod[$method->name] = $balance;
        }
        return collect(compact('monthlyBalanceByMethod', 'monthlyBalance'));
    }

    public function getAnnualSales()
    {
        $sales = [];
        foreach(range(1, 12) as $i) {
            $monthlySalesCount = Sale::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $i)->count();

            array_push($sales, $monthlySalesCount);
        }
        return "[" . implode(',', $sales) . "]";
    }

    public function getAnnualClients()
    {
        $clients = [];
        foreach(range(1, 12) as $i) {
            $monthclients = Sale::selectRaw('count(distinct client_id) as total')
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', $i)
                ->first();

            array_push($clients, $monthclients->total);
        }
        return "[" . implode(',', $clients) . "]";
    }

    public function getAnnualProducts()
    {
        $products = [];
        foreach(range(1, 12) as $i) {
            $monthproducts = SoldProduct::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $i)->sum('qty');

            array_push($products, $monthproducts);
        }
        return "[" . implode(',', $products) . "]";
    }

    public function getMonthlyTransactions()
    {
        $actualmonth = Carbon::now();

        $lastmonths = [];
        $lastincomes = '';
        $lastexpenses = '';
        $semesterincomes = 0;
        $semesterexpenses = 0;

        foreach (range(1, 6) as $i) {
            array_push($lastmonths, $actualmonth->shortMonthName);

            $incomes = Transaction::where('type', 'income')
                ->whereYear('created_at', $actualmonth->year)
                ->WhereMonth('created_at', $actualmonth->month)
                ->sum('amount');

            $semesterincomes += $incomes;
            $lastincomes = round($incomes).','.$lastincomes;

            $expenses = abs(Transaction::whereIn('type', ['expense', 'payment'])
                ->whereYear('created_at', $actualmonth->year)
                ->WhereMonth('created_at', $actualmonth->month)
                ->sum('amount'));

            $semesterexpenses += $expenses;
            $lastexpenses = round($expenses).','.$lastexpenses;

            $actualmonth->subMonth(1);
        }

        $lastincomes = '['.$lastincomes.']';
        $lastexpenses = '['.$lastexpenses.']';

        return collect(compact('lastmonths', 'lastincomes', 'lastexpenses', 'semesterincomes', 'semesterexpenses'));
    }
}
