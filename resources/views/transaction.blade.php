@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4 p-lg-5">
                        <p class="fs-1 fw-bold mb-4">Transaction</p>

                        <div class="alert alert-dark" role="alert">
                            コード改修中
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Recipient</th>
                                        <th scope="col">Hash</th>
                                        <th scope="col">Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap">{{ $correctDate }}</td>
                                        <td class="text-nowrap">
                                            {{ $transactions['transaction']['mosaics'][0]['amount'] / 1000000 }} XYM</td>
                                        <td class="text-break">{{ $transactions['transaction']['recipientAddress'] }}</td>
                                        <td class="text-break">{{ $transactions['meta']['hash'] }}</td>
                                        <td class="text-break">
                                            {{ !empty($transactions['transaction']['message']) ? hex2bin($transactions['transaction']['message']) : 'No message' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
