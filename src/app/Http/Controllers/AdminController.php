<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    /**
     * 一覧：検索/絞り込み + ページネーション(7件)
     */
    public function index(Request $request)
    {
        $contacts   = $this->buildQuery($request)->paginate(7)->withQueryString();
        $categories = Category::orderBy('id')->get();

        return view('admin.index', compact('contacts', 'categories'));
    }

    /**
     * 詳細
     */
    public function show(Contact $contact)
    {
        $contact->load('category');
        return view('admin.show', compact('contact'));
    }

    /**
     * 削除（詳細のモーダルから）
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.index')->with('status', '削除しました。');
    }

    /**
     * CSV エクスポート（現在の絞り込み条件を適用）
     */
    public function export(Request $request): StreamedResponse
    {
        $query    = $this->buildQuery($request);
        $fileName = 'contacts_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');

            // Excel 対策: UTF-8 BOM
            fwrite($out, "\xEF\xBB\xBF");

            // ヘッダ
            fputcsv($out, ['id', '姓', '名', '性別', 'メール', '電話', '住所', '建物', '種類', '内容', '日付']);

            $genderMap = [1 => '男性', 2 => '女性', 3 => 'その他'];

            foreach ($query->cursor() as $c) {
                fputcsv($out, [
                    $c->id,
                    $c->last_name,
                    $c->first_name,
                    $genderMap[$c->gender] ?? '',
                    $c->email,
                    $c->tel,
                    $c->address,
                    $c->building,
                    optional($c->category)->content,
                    $c->detail,
                    optional($c->created_at)->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($out);
        }, $fileName, [
            'Content-Type'  => 'text/csv; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }

    /**
     * 検索/絞り込み用クエリ
     * - keyword     : 姓/名/フルネーム/メール
     * - gender      : 1|2|3
     * - category_id : カテゴリ
     * - date        : Y-m-d（作成日）
     */
    protected function buildQuery(Request $request): Builder
    {
        $q = Contact::with('category')->latest('created_at');

        // キーワード（姓/名/フルネーム/メール）
        if ($kw = trim((string) $request->input('keyword'))) {
            $concat = DB::connection()->getDriverName() === 'sqlite'
                ? "last_name || first_name"
                : "CONCAT(last_name, first_name)";

            $q->where(function ($sub) use ($kw, $concat) {
                $sub->where('last_name',  'like', "%{$kw}%")
                    ->orWhere('first_name','like', "%{$kw}%")
                    ->orWhereRaw("$concat like ?", ["%{$kw}%"])
                    ->orWhere('email',     'like', "%{$kw}%");
            });
        }

        // 性別
        if (in_array($request->gender, ['1', '2', '3'], true)) {
            $q->where('gender', (int) $request->gender);
        }

        // 種類
        if ($cid = $request->input('category_id')) {
            $q->where('category_id', (int) $cid);
        }

        // 日付
        if ($date = $request->input('date')) {
            $q->whereDate('created_at', $date);
        }

        return $q;
    }
}
