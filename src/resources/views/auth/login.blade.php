@extends('layouts.auth')
@section('auth_title','Login')
@section('header_action')
<a href="{{ route('register') }}" class="btn btn--ghost">register</a>
@endsection

@section('auth_body')
<form method="POST" action="{{ route('login') }}" class="form-panel form--narrow" novalidate>
    @csrf
    <div class="field">
        <label for="email">メールアドレス</label>
        <input id="email" class="input  {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
            value="{{ old('email') }}" placeholder="例：test@example.com" autocomplete="email">
        @error('email')<p class="form-error">{{ $message }}</p>@enderror
    </div>
    <div class="field">
        <label for="password">パスワード</label>
        <input id="password" class="input  {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password"
            placeholder="例：coachtech1106" autocomplete="current-password">
        @error('password')<p class="form-error">{{ $message }}</p>@enderror
    </div>
    <button type="submit" class="btn btn--primary">ログイン</button>
</form>
@endsection