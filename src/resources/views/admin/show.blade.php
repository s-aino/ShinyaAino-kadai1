@extends('layouts.auth')

@section('auth_body')
{{-- 画面全体のオーバーレイ --}}
<div class="show-overlay">
  {{-- 中央に浮くカード --}}
  <section class="show-card">

    {{-- 右上 ×（一覧に戻る）--}}
    <a href="{{ route('admin.index', request()->query()) }}"
       class="show-close" aria-label="一覧へ戻る">×</a>


    {{-- ラベル＋値（フラット表示。線/背景なし） --}}
    @php $g=[1=>'男性',2=>'女性',3=>'その他']; @endphp
    <dl class="show-list">
      <div class="show-row">
        <dt>お名前</dt>
        <dd class="break">{{ $contact->last_name }} {{ $contact->first_name }}</dd>
      </div>
      <div class="show-row">
        <dt>性別</dt>
        <dd>{{ $g[$contact->gender] ?? '' }}</dd>
      </div>
      <div class="show-row">
        <dt>メールアドレス</dt>
        <dd class="break">{{ $contact->email }}</dd>
      </div>
      <div class="show-row">
        <dt>電話番号</dt>
        <dd>{{ $contact->tel }}</dd>
      </div>
      <div class="show-row">
        <dt>住所</dt>
        <dd class="break">{{ $contact->address }}</dd>
      </div>
      <div class="show-row">
        <dt>建物名</dt>
        <dd class="break">{{ $contact->building }}</dd>
      </div>
      <div class="show-row">
        <dt>お問い合わせの種類</dt>
        <dd class="break">{{ optional($contact->category)->content }}</dd>
      </div>
      <div class="show-row">
        <dt>お問い合わせ内容</dt>
        <dd class="break">{!! nl2br(e($contact->detail)) !!}</dd>
      </div>
    </dl>

    <div class="actions right">
      {{-- 削除はモーダル風カード内で実行（赤ボタン） --}}
      <form method="POST" action="{{ route('admin.destroy', $contact) }}"
            onsubmit="return confirm('削除します。よろしいですか？')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn--danger">削除</button>
      </form>
    </div>

  </section>
</div>
@endsection
