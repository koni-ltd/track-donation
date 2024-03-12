<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class SymbolController extends Controller
{
    public function __construct()
    {
        $this->client = new Client();
    }

    public function getTransactionDetail(Request $request)
    {
        // ノードURLとトランザクションハッシュをリクエストから取得
        $node = $request->node;
        $node = 'https://symbol01.node.oe-jpy.com:3001';
        $hash = $request->hash;
        $hash = '701A694597919E2DED6640B54FEEEBDF2A4DDB7AA1DD3D0B418AC8B1DA00717C';

        // SymbolのAPIエンドポイントを組み立て
        $url = $node . '/transactions/confirmed/' . $hash;

        try {
            // APIにリクエストを送信し、レスポンスを取得
            $response = $this->client->request('GET', $url);

            // レスポンスボディを取得してデコード
            $transactionDetail = json_decode($response->getBody()->getContents(), true);

            // トランザクション詳細から受取人アドレスを取得
            // トランザクションタイプによっては、受取人アドレスのフィールド名が異なる場合があるため、適宜調整が必要
            $recipientAddress = $transactionDetail['transaction']['recipientAddress'] ?? null;

            // 受取人アドレスが取得できた場合、そのアドレスのトランザクション履歴を取得
            if ($recipientAddress) {
                return $this->getAccountTransactions($node, $recipientAddress);
            } else {
                return response()->json(['error' => 'Recipient address not found in the transaction detail.'], 404);
            }
        } catch (\Exception $e) {
            // エラーが発生した場合、エラーメッセージを返す
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getAccountTransactions($node, $accountAddress)
    {
        // SymbolのAPIエンドポイントを組み立て
        $url = $node . '/accounts/' . $accountAddress . '/transactions';

        try {
            // APIにリクエストを送信し、レスポンスを取得
            $response = $this->client->request('GET', $url);

            // レスポンスボディを取得してデコード
            $transactions = json_decode($response->getBody()->getContents(), true);

            return $transactions; // 取得したトランザクションのリストを返す
        } catch (\Exception $e) {
            // エラーが発生した場合、エラーメッセージを返す
            return ['error' => $e->getMessage()];
        }
    }
}
