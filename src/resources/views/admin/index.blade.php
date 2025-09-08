@extends('layouts.auth')
@section('auth_title','Admin')
@section('header_action')
  <form method="POST" action="{{ route('logout') }}" class="inline" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn--ghost">logout</button>
  </form>
@endsection
@section('auth_body')
<section class="form-panel form--wide admin-index">
    {{-- フラッシュ --}}
    @if(session('status'))
    <div class="flash">{{ session('status') }}</div>
    @endif

    {{-- フィルター --}}
    <form method="GET" action="{{ url('/admin') }}" class="filters" novalidate>
        <input class="input" type="text" name="keyword"
            placeholder="お名前やメールアドレスを入力してください"
            value="{{ request('keyword') }}">

        <select class="select" name="gender">
            <option value="">性別</option>
            <option value="1" {{ request('gender')==='1'?'selected':'' }}>男性</option>
            <option value="2" {{ request('gender')==='2'?'selected':'' }}>女性</option>
            <option value="3" {{ request('gender')==='3'?'selected':'' }}>その他</option>
        </select>

        <select class="select" name="category_id">
            <option value="">お問い合わせ種類</option>
            @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ (string)request('category_id')===(string)$c->id?'selected':'' }}>
                {{ $c->content }}
            </option>
            @endforeach
        </select>

        <input class="input" type="date" name="date" value="{{ request('date') }}">

        <button class="btn btn--primary filters__search">検索</button>

        <div class="filters__links">
            <a class="btn btn--ghost btn--sm" href="{{ url('/admin') }}">リセット</a>
            <a class="btn btn--ghost btn--sm" href="{{ route('admin.export', request()->query()) }}">エクスポート</a>
        </div>
    </form>

    {{-- 一覧 --}}
    <div class="card table-wrap">
        <table class="table table--admin">
            <thead>
                <tr>
                    <th>お名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせの種類</th>
                    <th class="th--action"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $ct)
                <tr>
                    <td>{{ $ct->last_name }} {{ $ct->first_name }}</td>
                    <td>{{ [1=>'男性',2=>'女性',3=>'その他'][$ct->gender] ?? '' }}</td>
                    <td class="td--email">{{ $ct->email }}</td>
                    <td>{{ optional($ct->category)->content }}</td>
                    <td class="td--action">
                        <a href="{{ route('admin.show', $ct) }}" class="btn btn--ghost btn--sm">詳細</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ページネーション（検索クエリ維持） --}}
    <div class="pagination-centered">
        {{ $contacts->appends(request()->query())->links() }}
    </div>
</section>
@endsection