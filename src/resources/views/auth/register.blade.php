@extends('layouts.auth')

@section('auth_title', 'Register')

@section('header_action')
<a href="{{ route('login') }}" class="btn btn--ghost">login</a>
@endsection

@section('auth_body')
<form method="POST" action="{{ route('register') }}" class="form-panel form--narrow" novalidate>
    @csrf

    <div class="field">
        <label for="name">お名前</label>
        <input id="name" class="input {{ $errors->has('name') ? 'is-invalid' : '' }} " type="text" name="name"
            value="{{ old('name') }}" required autocomplete="name"
            placeholder="例：山田 太郎">
        @error('name') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="email">メールアドレス</label>
        <input id="email" class="input {{ $errors->has('name') ? 'is-invalid' : '' }}" type="email" name="email"
            value="{{ old('email') }}" required autocomplete="email"
            placeholder="例：test@example.com">
        @error('email') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <div class="field">
        <label for="password">パスワード</label>
        <input id="password" class="input {{ $errors->has('name') ? 'is-invalid' : '' }}" type="password" name="password"
            required autocomplete="new-password"
            placeholder="例：coachtec1106">
        @error('password') <p class="form-error">{{ $message }}</p> @enderror
    </div>

    <button type="submit" class="btn btn--primary">登録</button>
</form>
@endsection