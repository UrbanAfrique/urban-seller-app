<?php

namespace App\Http\Controllers;

use App\Enum\RouteTypeEnum;
use App\Enum\TransactionTypeEnum;
use App\Models\PayoutMethod;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Traits\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BalanceController extends Controller
{
    use General;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->getProxyData();
        $vendor = $data['vendor'];

        $data['pageTitle'] = trans('general.balance');
        $data['balance'] = Transaction::where(['vendor_id' => $vendor->id, 'status' => 1])->sum('amount');
        $data['balance_sum'] = Transaction::where('amount', '>', 0)->where(['vendor_id' => $vendor->id, 'status' => 1])->sum('amount');
        $data['transactions'] = Transaction::where('vendor_id', $vendor->id)->orderBy('id', 'DESC')->get();

        // return view('proxy.balance', $data);
        return response(view('proxy.balance', $data))->header('Content-Type', 'application/liquid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendor  = Vendor::find($request->input('vendor_id'));
        $amount = $request->input('amount');
        // $balance  = Transaction::where('vendor_id', $vendor->id)->sum('amount');
        $balance  = Transaction::where(['vendor_id' => $vendor->id, 'status' => 1])->sum('amount');

        if ($amount > $balance) {
            return response()->json(['success' => false, 'message' => 'Requested amount is more than balance.']);
        }
        Transaction::create([
            'seller_id' => $request->input('seller_id'),
            'vendor_id' => $request->input('vendor_id'),
            'amount' => -$amount,
            'type' => TransactionTypeEnum::WITHDRAWAL,
            'detail' => 'pending'
        ]);
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function addPayout(Request $request)
    {
        PayoutMethod::updateOrCreate([
            'seller_id' => $request->input('seller_id'),
            'vendor_id' => $request->input('vendor_id')
        ], [
            'type' => $request->input('payout_type'),
            'account' => $request->input('account'),
            'account_title' => $request->input('account_title'),
            'swiftcode' => $request->input('swiftcode'),
            'address' => $request->input('address'),
        ]);
        return response()->json(['success' => true]);
    }

    public function withdraws(Request $request)
    {
        $data = [
            'pageTitle' => 'Withdraw Requests',
            'routeType' => RouteTypeEnum::WITHDRAWS
        ];
        $data['transactions'] = Transaction::whereHas('vendor')
            ->where('type', TransactionTypeEnum::WITHDRAWAL)
            ->orderBy('id', 'DESC')
            ->paginate(10)
            ->appends($request->query());

        return view('app.vendors.withdraws', $data);
    }

    public function resetPayout(Request $request)
    {
        $vendor  = Vendor::find($request->input('vendor_id'));
        $vendor->payout()->delete();
        return response()->json(['success' => true]);
    }
}
