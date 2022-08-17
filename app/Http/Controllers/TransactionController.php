<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $transactions = Transaction::where('user_id', Auth::user()->id)
        ->whereMonth('fech_transaction', '=', '08' )
        ->get();

        $total =0;

        for($i = 0; $i < sizeof($transactions); $i++){
            if(intval($transactions[$i]['type_transaction'])==false) {
                $transactions[$i]['amount'] *= -1;
            }
            $total += $transactions[$i]['amount']; 

        }

        

        return view('transactions.index', compact('transactions', 'total'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

        $request->validate([
            'type_transaction' => 'required',
            'desc_transaction' => 'string|max:80|nullable',
            'fech_transaction' => 'required|date_format:Y-m-d',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $transaction = new Transaction([
            'type_transaction' => $request->get('type_transaction'),
            'desc_transaction' => $request->get('desc_transaction'),
            'fech_transaction' => $request->get('fech_transaction'),
            'amount' => $request->get('amount'),
            'user_id' => Auth::user()->id
            //'user_id' => $request->get('user_id'),
        ]);
       
        
        $transaction->save();
        //return response()->json($transaction);
        return redirect()->route('transactions.index')->with(['success' => 'Transaccion guardada!!', 'id' => $transaction->identity], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $transaction = Transaction::find($id);
        return view('transactions.edit', compact('transaction'));
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
        //
        $request->validate([
            'type_transaction' => 'required',
            'desc_transaction' => 'string|max:80|nullable',
            'fech_transaction' => 'required|date_format:Y-m-d',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $transaction = Transaction::find($id);

            $transaction->type_transaction =  $request->get('type_transaction');
            $transaction->desc_transaction = $request->get('desc_transaction');
            $transaction->fech_transaction = $request->get('fech_transaction');
            $transaction->amount = $request->get('amount');
            $transaction->save();

            return redirect()->route('transactions.index')->with(['success' => 'Transaccion actualizada!!'], 200);
    


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with(['success' => 'Transaccion Eliminada!'], 200);
    }
}
