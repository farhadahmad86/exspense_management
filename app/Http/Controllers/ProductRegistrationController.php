<?php

namespace App\Http\Controllers;

use App\Models\ProductsModel;
use App\Models\StockModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-registration-list', ['only' => ['index','show']]);
        $this->middleware('permission:product-registration-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-registration-edit', ['only' => ['edit','update']]);
    }



    public function index(Request $request)
    {
        $auth = Auth::user();
        $ar = json_decode($request->array);
        $product_name = $request->part_name;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $pagination_number = empty($ar) ? 30 : 100000000;
        $datas = ProductsModel::all();
        $datas = DB::table('products')
            ->leftJoin('users', 'users.id','=', 'products.par_user_id')
            ->where('products.company_id', $auth->company_id);
        // ->get();
        // dd($datas);
        // ->orderBy('par_id','Desc');


        $query = $datas;

        if (isset($request->part_name)) {
//            dd($request->part_name);
            $query->where('products.par_id', '=', $request->part_name );
        }

        if (isset($request->from_date)) {
            $query->whereDate('products.par_created_at', '>=', $request->from_date);
        }
        if (isset($request->to_date)) {
            $query->whereDate('products.par_created_at', '<=', $request->to_date);
        }

        if ((!empty($from_date)) && (!empty($to_date))) {
            $query->whereDate('products.par_created_at', '>=', $request->from_date)
                ->whereDate('products.par_created_at', '<=', $request->to_date);
        }

        $products_title = ProductsModel::where('company_id', $auth->company_id)->get();

        // $query = $query->get();
        $query = $query->orderBy('par_id', 'DESC')->paginate($pagination_number);
        // dd($query);

        return view('product_registration/product_registration_list', compact('products_title', 'product_name',  'from_date', 'to_date','query'))->with('pageTitle', 'Product Registration List');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product_registration/add_product_registration')->with('pageTitle', 'Create Product Registration');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use( $request ) {
            // $this->validation($request);

            $this->validation($request);

            $auth = Auth::user();
            $products = new ProductsModel();
            $products->par_name = $request->product_name;
            $products->par_purchase_price = $request->purchase_price;
            $products->par_bottom_price = $request->bottom_price;
            $products->par_sale_price = $request->retail_price;
//            $products->par_total_qty = $request->qty;
            $products->par_total_qty = 0;
            $products->par_status = "Created";
            $products->par_ip_address = $this->get_ip();
            $products->par_browser_info = $this->getBrwsrInfo();
            $products->par_user_id = $auth->id;
            $products->company_id = $auth->company_id;
            $products->save();


//        add stock data
            $stock = new StockModel();
            $stock->sto_par_id = $products->par_id;
            $stock->sto_user_id = $auth->id;
            $stock->company_id = $auth->company_id;
            $stock->sto_type = "Created";
            $stock->sto_type_id = $products->par_id;
            $stock->sto_in = 0;
            $stock->sto_total = 0;
            $stock->save();

        });


        return redirect()->back()->with('success','Successfully Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auth = Auth::user();
        $product = ProductsModel::where('par_id','=',$id)->where('company_id', $auth->company_id)->first();
        return view('product_registration/edit_product_registration',compact('product'))->with('pageTitle', 'Edit Product Registration');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::transaction(function () use( $request ,$id) {
            $auth = Auth::user();
            $product = ProductsModel::where('par_id', '=', $id)->first();
            $product->par_name = $request->part_name;
            $product->par_purchase_price = $request->purchase_price;
            $product->par_bottom_price = $request->bottom_price;
            $product->par_sale_price = $request->retail_price;
            $product->par_ip_address = $this->get_ip();
            $product->par_browser_info = $this->getBrwsrInfo();
            $product->par_user_id = $auth->id;
            $product->company_id = $auth->company_id;
            $product->save();
        });
        return redirect()->route('product_registration.index')->with('success', 'Successfully Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validation($request)
    {
        $auth = Auth::user();
        $this->validate($request, [
            'product_name' => [
                'required',
                Rule::unique('products', 'par_name')->where(function ($query) use ($auth) {
                    return $query->where('company_id', $auth->company_id);
                }),
            ],
            'purchase_price' => 'required',
//            'bottom_price' => 'required',
            'retail_price' => 'required',
        ]);
        // return $this->validate($request,[
        //     'part_name' => ['required', 'string','unique:products,par_name'],

        // ]);

    }
}
