<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Models\User;

class SymbolController extends Controller
{
    public function __construct()
    {
        $this->client = new Client();
    }

    public function getTransaction(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'hash' => 'required|alpha_num',
        ]);

        $userId = $validatedData['user_id'];
        $inputHash = $validatedData['hash'];

        // ユーザーIDを使用してユーザー情報を取得
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('home')->with('error', 'ユーザーが見つかりません。');
        }

        // APIエンドポイント
        $url = 'https://0-0-0-5.symbol-nodes.jp:3001/transactions/confirmed/' . $inputHash;

        try {
            $address = $user->address;

            // APIにリクエストを送信し、レスポンスを取得
            $response = $this->client->request('GET', $url);

            // レスポンスボディを取得してデコード
            $transactions = json_decode($response->getBody()->getContents(), true);

            $height = $transactions['meta']['height'];
            $hash = $transactions['meta']['hash'];
            $recipientAddress = $transactions['transaction']['recipientAddress'];

            // APIエンドポイント
            $url = 'https://0-0-0-5.symbol-nodes.jp:3001/transactions/confirmed?address=' . $address . '&type=16724&pageSize=100&order=asc&fromHeight=' . $height;

            try {
                // APIにリクエストを送信し、レスポンスを取得
                $response = $this->client->request('GET', $url);

                // レスポンスボディを取得してデコード
                $transactionsList = json_decode($response->getBody()->getContents(), true);

                // APIエンドポイント
                $url = 'https://0-0-0-5.symbol-nodes.jp:3001/accounts/' . $address;
                try {
                    // APIにリクエストを送信し、レスポンスを取得
                    $response = $this->client->request('GET', $url);

                    // レスポンスボディを取得してデコード
                    $account = json_decode($response->getBody()->getContents(), true);

                    $balance = !empty($account['account']['mosaics']) ? $account['account']['mosaics'][0]['amount'] / 1000000 : 0;

                    $formattedTransactions = $this->formatTransactions($transactionsList['data'], $recipientAddress, $hash);

                    return view('transaction', [
                        'user' => $user,
                        'transactionsList' => $formattedTransactions,
                        'balance' => $balance,
                    ]);
                } catch (\Exception $e) {
                    // エラーが発生した場合、エラーメッセージを返す
                    return redirect()->route('home')->with('error', 'トランザクションの取得に失敗しました。');
                }
            } catch (\Exception $e) {
                // エラーが発生した場合、エラーメッセージを返す
                return redirect()->route('home')->with('error', 'トランザクションの取得に失敗しました。');
            }
        } catch (\Exception $e) {
            // エラーが発生した場合、エラーメッセージを返す
            return redirect()->route('home')->with('error', 'トランザクションの取得に失敗しました。');
        }
    }

    public function formatTransactions($transactions, $userAddress, $hash)
    {
        $formattedTransactions = [];

        foreach ($transactions as $transaction) {
            $genesisTimestamp = strtotime('2021-03-16 00:00:00') * 1000;
            $transactionTimestamp = $genesisTimestamp + $transaction['meta']['timestamp'];
            $formattedTimestamp = date('Y-m-d H:i:s', $transactionTimestamp / 1000);

            $recipientAddress = $transaction['transaction']['recipientAddress'] ?? '';

            $transactionType = $recipientAddress === $userAddress ? 'Received' : 'Sent';

            $amount = !empty($transaction['transaction']['mosaics'])
                ? $transaction['transaction']['mosaics'][0]['amount'] / 1000000
                : 0;

            $message = isset($transaction['transaction']['message'])
                ? hex2bin($transaction['transaction']['message'])
                : '';

            $cssClass = $transaction['meta']['hash'] === $hash ? 'table-active' : '';

            $formattedTransactions[] = [
                'timestamp' => $formattedTimestamp,
                'recipientAddress' => $recipientAddress,
                'type' => $transactionType,
                'amount' => $amount,
                'message' => $message,
                'cssClass' => $cssClass,
            ];
        }

        return $formattedTransactions;
    }
}
