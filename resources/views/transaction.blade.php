@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4 p-lg-5">
                        <div class=" mb-4">
                            <p class="fs-1 fw-bold mb-4">トランザクション</p>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col" class="text-nowrap">Organization Name</th>
                                        <th scope="col" class="text-nowrap">Organization Symbol Address</th>
                                        <th scope="col" class="text-nowrap">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap">{{ $user->name }}</td>
                                        <td class="text-nowrap">{{ $user->address }}</td>
                                        <td class="text-nowrap text-end">{{ $balance }} XYM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Recipient Symbol Address</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Amount</th>
                                        {{-- <th scope="col">Message</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactionsList as $index => $transaction)
                                        <tr class="{{ $transaction['cssClass'] }}">
                                            <td class="text-nowrap">{{ $transaction['timestamp'] }}</td>
                                            <td class="text-nowrap" id="address-{{ $index }}"></td>
                                            <td class="text-nowrap">{{ $transaction['type'] }}</td>
                                            <td class="text-nowrap text-end">{{ $transaction['amount'] }} XYM</td>
                                            {{-- <td class="text-break">{{ $transaction['message'] }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @foreach ($transactionsList as $index => $transaction)
                var hexAddress = '{{ $transaction['recipientAddress'] ?? '' }}';
                if (hexAddress) {
                    var elementId = 'address-{{ $index }}';
                    document.getElementById(elementId).textContent = hexToBase32(hexAddress);
                }
            @endforeach
        });

        /** @param {string} hex */
        function hexToBase32(hex) {
            const bytesArray = [];
            for (let i = 0; i < hex.length; i += 2) {
                bytesArray.push(parseInt(hex.substr(i, 2), 16));
            }
            const uint8Array = new Uint8Array(bytesArray);

            const base32Chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
            let bits = 0;
            let value = 0;
            let base32 = "";

            for (let i = 0; i < uint8Array.length; i++) {
                value = (value << 8) | uint8Array[i];
                bits += 8;

                while (bits >= 5) {
                    base32 += base32Chars[(value >>> (bits - 5)) & 0x1f];
                    bits -= 5;
                }
            }

            if (bits > 0) {
                base32 += base32Chars[(value << (5 - bits)) & 0x1f];
            }

            return base32;
        }
    </script>
@endsection
