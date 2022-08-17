@extends('layouts.app')

@section('content')
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function ()
        {
            $("input").each(function (index, element)
            {
                $(element).on("invalid", function(event)
                {
                    event.target.setCustomValidity("");
                    if ( ! event.target.validity.valid)
                    {
                        elemento =  element.getAttribute('data-error')==null ? 'Este valor ' : 'El campo ' + element.getAttribute('data-error');
                        event.target.setCustomValidity( elemento + ' es requerido');
                    }
                });

                $(element).on("input", function(event)
                {
                    event.target.setCustomValidity("");
                });
            });

        });
    </script>
@endpush
<div class="container">
@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
    <div class="row justify-content-center">
    <div class="col-md-12 my-3">
            <div class="card">
                <div class="card-header">{{ __('Editar Transaccion') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{route('transactions.update', $transaction->id)}}">
                    @method('PATCH') 
                    @csrf
                    <div class="mb-3">
                        <label for="type_transaction" class="form-label text-md-right">{{ __('Tipo de Transacción') }}</label>
                        <div class="col-md-2">
                            <select name="type_transaction" id="type_transaction" class="form-control{{ $errors->has('type_transaction') ? ' is-invalid' : '' }}">
                               
                                <option value="1" @if($transaction->type_transaction==true) selected @endif>Ingreso</option>
                                <option value="0" @if($transaction->type_transaction==false) selected @endif>Egreso</option>
                               
                            </select>
                            @if ($errors->has('type_transaction'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('type_transaction') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="desc_transaction" class="form-label text-md-right">{{ __('Descripción') }}</label>
                        <div class="col-md-7">
                            <input id="desc_transaction" type="text" class="form-control{{ $errors->has('desc_transaction') ? ' is-invalid' : '' }}" name="desc_transaction" value="{{$transaction->desc_transaction}}"  required data-error="Descripción de Transacción" placeholder="ejemplo: Ingresos por Salario">
                            @if ($errors->has('desc_transaction'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('desc_transaction') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>        
                    <div class="mb-3">
                        <label for="amount" class="form-label text-md-right">{{ __('Monto') }}</label>
                        <div class="col-md-7">
                            <input id="amount" type="number" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{$transaction->amount}}"  data-error="Monto" required placeholder="ejemplo: 150000.00" pattern="[0-9]+([,\.][0-9]+)?" step="0.01">
                            @if ($errors->has('amount'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('amount') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>        
                    <div class="mb-3">
                        <label for="fech_transaction" class="form-label text-md-right">{{ __('Fecha de transacción') }}</label>
                        <div class="col-md-7">
                            <input id="fech_transaction" type="date" class="form-control{{ $errors->has('fech_transaction') ? ' is-invalid' : '' }}" name="fech_transaction" value="{{$transaction->fech_transaction}}" required  data-error="Fecha de Transacción">
                            @if ($errors->has('fech_transaction'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('fech_transaction') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>        
                    <div class="form-group row my-3">
                        <div class="mx-auto">
                            <button type="submit" class="btn btn-primary">
                                Actualizar
                            </button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

