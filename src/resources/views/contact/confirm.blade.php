{{-- resources/views/contact/confirm.blade.php --}}
@extends('layouts.auth')

@section('auth_title', 'Confirm')

@section('auth_body')
<table class="table" style="margin: bottom 20px">
    <tr>
        <th>お名前</th>
        <td>{{ $last_name }} {{ $first_name }}</td>
    </tr>
    <tr>
        <th>性別</th>
        <td>{{ [1 => '男性', 2 => '女性', 3 => 'その他'][$gender] ?? '' }}</td>
    </tr>
    <tr>
        <th>メールアドレス</th>
        <td>{{ $email }}</td>
    </tr>
    <tr>
        <th>電話番号</th>
        <td>{{ $tel }}</td>
    </tr>
    <tr>
        <th>住所</th>
        <td>{{ $address }}</td>
    </tr>
    <tr>
        <th>建物名</th>
        <td>{{ $building ?: '-' }}</td>
    </tr>
    <tr>
        <th>お問い合わせの種類</th>
        <td>{{ optional($category)->content }}</td>
    </tr>
    <tr>
        <th>お問い合わせ内容</th>
        <td>{!! nl2br(e($detail)) !!}</td>
    </tr>
</table>



<div class="actions" style="display:flex; gap:12px; align-items:center;">
    {{-- 修正（入力フォームへ戻る） --}}
    <a href="{{ url('/') }}" class="btn btn--ghost btn--sm">修正</a>

    {{-- 送信（DB保存） --}}
    <form method="POST" action="{{ route('contact.store') }}" class="inline" novalidate>
        @csrf
        {{-- hidden で値をすべて再送（セッションに依存しない） --}}
        <input type="hidden" name="last_name" value="{{ $last_name }}">
        <input type="hidden" name="first_name" value="{{ $first_name }}">
        <input type="hidden" name="gender" value="{{ $gender }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="tel" value="{{ $tel }}">
        <input type="hidden" name="address" value="{{ $address }}">
        <input type="hidden" name="building" value="{{ $building }}">
        <input type="hidden" name="category_id" value="{{ $category_id ?? optional($category)->id }}">
        {{-- 改行保持のため textarea を hidden で使う --}}
        <textarea name="detail" hidden>{{ $detail }}</textarea>

        <button type="submit" class="btn btn--primary btn--sm">送信</button>
    </form>
</div>
@endsection