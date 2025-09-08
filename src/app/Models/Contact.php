<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter($query, \Illuminate\Http\Request $request)
    {
        // キーワード（姓・名・フルネーム・メール）
        if ($request->filled('q')) {
            $key = $request->q;
            $query->where(function ($w) use ($key) {
                $w->where('last_name', 'like', "%{$key}%")
                    ->orWhere('first_name', 'like', "%{$key}%")
                    ->orWhereRaw("concat(last_name, ' ', first_name) like ?", ["%{$key}%"])
                    ->orWhere('email', 'like', "%{$key}%");
            });
        }

        // 性別（all 以外）
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        // 種類（category_id）
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 日付（created_at の日付一致）
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        return $query;
    }
}
