@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>История операций</h2>
        <form action="{{ route('transactions.index') }}" method="get">
            <div class="input-group mb-3">
                <label>
                    <input type="text" class="form-control" placeholder="Описание" name="description" value="{{ request()->get('description') }}">
                </label>
                <button class="btn btn-primary" type="submit">Поиск</button>
            </div>
        </form>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Сумма</th>
                <th>Описание</th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => (request()->get('sort') == 'asc' ? 'desc' : 'asc')]) }}">Date</a>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
