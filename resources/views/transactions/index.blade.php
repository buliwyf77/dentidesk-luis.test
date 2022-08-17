@extends('layouts.app')

@section('content')
<div class="container">
<div class="col-sm-12">
    @if(session()->get('success'))
        <div class="alert alert-success">
        {{ session()->get('success') }}  
        </div>
    @endif
</div>

<div class="row justify-content-center">
   <div class="col-md-12 my-3">
            <div class="card">
                <div class="card-header">{{ __('Listado de Transacciones') }} de {{Auth::user()->name}}
                <div style="float: right"><a href="{{ route('transactions.create')}}" class="btn btn-primary btn-sm">Nueva transacción</a></div>
                </div>

                <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th colspan="2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->id}}</td>
                                <td>{{$transaction->desc_transaction}} {{$transaction->last_name}}</td>
                                <td>{{\Carbon\Carbon::parse($transaction->fech_transaction)->diffForHumans()}}
                                <br>
                                {{ date('d/m/Y', strtotime($transaction->fech_transaction))}}</td>
                                <td @if($transaction->amount<0) class="text-danger" @endif>$ {{number_format($transaction->amount,2)}}</td>
                                <td>
                                    <a href="{{ route('transactions.edit',$transaction->id)}}" class="btn btn-primary">Editar</a>
                                </td>
                                <td>
                                    <form action="{{ route('transactions.destroy', $transaction->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3"><h5>Total</h5></td>
                                <td colspan="3" @if($total<0) class="text-danger" @endif><h5>$ {{number_format($total,2)}}</h5></td>
                            </tr>

                        </tbody>
                    </table>
                    <div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection

