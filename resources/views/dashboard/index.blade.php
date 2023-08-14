@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Дашбоард</h2>


        <div class="row">
            <div class="col">
                <h4>Баланс: <span id="balance">{{ $balance->balance }}</span></h4>
            </div>

            <div class="col ">
                <label for="refreshInterval">Обновлять каждые</label>
                <select id="refreshInterval" class="form-control">
                    <option value="2">2 секунды</option>
                    <option selected value="5">5 секунд</option>
                    <option value="10">10 секунд</option>
                </select>

            </div>

        </div>

        <h4>Последние операции:</h4>
        <ul class="list-group">
            @foreach($transactions as $transaction)
                <li class="list-group-item">
                    Сумма: {{ $transaction->amount }} |
                    Описание: {{ $transaction->description }} |
                    Дата: {{ $transaction->created_at }}
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        function refreshData() {
            $.ajax({
                url: "{{ route('dashboard.index') }}",
                success: function (data) {
                    $('#balance').html(data.balance);

                    let transactionList = "";
                    data.transactions.forEach(function (transaction) {
                        let formattedDate = moment(transaction.created_at).format('YYYY-MM-DD HH:mm:ss');
                        transactionList += '<li class="list-group-item">Сумма: ' + transaction.amount + ' | Описание: ' + transaction.description + ' | Дата: ' + formattedDate + '</li>';
                    });
                    $(".list-group").html(transactionList);
                }
            });
        }

        let intervalId;
        $("#refreshInterval").on('change', function () {
            clearInterval(intervalId);
            let interval = $(this).val() * 1000;  // Convert to milliseconds
            intervalId = setInterval(refreshData, interval);
        }).trigger('change');

    </script>
@endsection
