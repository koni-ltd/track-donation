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
        $request->validate([
            'user_id' => 'required|integer',
            // 文字と数字のみを許可し、大文字小文字を区別しない
            'hash' => 'required|alpha_num',
        ]);

        $userId = $request->input('user_id');
        $hash = $request->input('hash');

        // ユーザーIDを使用してユーザー情報を取得
        $user = User::find($userId);
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User not found.']);
        }

        $node = $user->node;

        // APIエンドポイント
        $url = $node . '/transactions/confirmed/' . $hash;

        try {
            // APIにリクエストを送信し、レスポンスを取得
            $response = $this->client->request('GET', $url);

            // レスポンスボディを取得してデコード
            $transactions = json_decode($response->getBody()->getContents(), true);

            // Symbolネメシスブロックのタイムスタンプ (2021-03-16 00:00:00 UTC)
            $genesisTimestamp = strtotime('2021-03-16 00:00:00') * 1000;

            // APIから取得したタイムスタンプをミリ秒単位で追加
            $transactionTimestamp = $genesisTimestamp + ($transactions['meta']['timestamp']);

            // 正しい日付と時刻に変換（秒単位に変換するために1000で割る）
            $correctDate = date('Y-m-d H:i:s', $transactionTimestamp / 1000);

            return view('transaction', ['transactions' => $transactions, 'correctDate' => $correctDate]);
        } catch (\Exception $e) {
            // エラーが発生した場合、エラーメッセージを返す
            return ['error' => $e->getMessage()];
        }
    }
}
