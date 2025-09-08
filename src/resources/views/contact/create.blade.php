@extends('layouts.auth')
@section('auth_title','Contact')
@section('header_action')
<a href="{{ route('login') }}" class="btn btn--ghost">login</a>
@endsection

@section('auth_body')
<form method="POST" action="{{ route('contact.confirm') }}" class="form-panel " novalidate>
    @csrf
    <section class="form-panel contact-page">
        <div class="field">
            <label>お名前</label>
            <div class="inline" style="gap:12px; width:100%;">
                <input class="input {{ $errors->has('name') ? 'is-invalid' : '' }}" style="flex:1" name="last_name" value="{{ old('last_name', session('contact.last_name')) }}" placeholder="姓">
                <input class="input {{ $errors->has('name') ? 'is-invalid' : '' }}" style="flex:1" name="first_name" value="{{ old('first_name',session('contact.first_name')) }}" placeholder="名">
            </div>
            @error('last_name')<p class="form-error">{{ $message }}</p>@enderror
            @error('first_name')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="field @error('gender') has-error @enderror">
            <label>性別</label>

            @php $g = old('gender', session('contact.gender', 1)); @endphp
            <div class="inline">
                <label><input type="radio" name="gender" value="1" {{ $g==1 ? 'checked' : '' }}> 男性</label>
                <label><input type="radio" name="gender" value="2" {{ $g==2 ? 'checked' : '' }}> 女性</label>
                <label><input type="radio" name="gender" value="3" {{ $g==3 ? 'checked' : '' }}> その他</label>
            </div>

            @error('gender') <p class="form-error">{{ $message }}</p> @enderror
        </div>
        <div class="field">
            <label for="email">メールアドレス</label>
            <input id="email" class="input {{ $errors->has('name') ? 'is-invalid' : '' }}" type="email" name="email"
                value="{{ old('email',session('contact.email')) }}" placeholder="例：test@example.com">
            @error('email')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="field">
            <label for="tel">電話</label>
            <input id="tel" class="input {{ $errors->has('name') ? 'is-invalid' : '' }}" type="tel" name="tel"
                value="{{ old('tel',session('contact.tel')) }}" placeholder="08012345678">
            @error('tel')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="field">
            <label for="address">住所</label>
            <input id="address" class="input {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="address"
                value="{{ old('address',session('contact.address')) }}" placeholder="住所">
            @error('address')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="field">
            <label for="building">建物名（任意）</label>
            <input id="building" class="input {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="building"
                value="{{ old('building',session('contact.building')) }}" placeholder="建物名">
            @error('building')<p class="form-error">{{ $message }}</p>@enderror
        </div>

        <div class="field">
            <label for="category_id">お問い合わせ種類</label>
            <select id="category_id" class="select @error('category_id') is-invalid @enderror" name="category_id">
                <option value="" disabled {{ old('category_id',session('contact.category_id'))?'':'selected' }}>選択してください</option>
                @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ old('category_id',session('contact.category_id'))==$c->id?'selected':'' }}>
                    {{ $c->content }}
                </option>
                @endforeach
            </select>
            @error('category_id')<p class="form-error">{{ $message }}</p>@enderror
        </div>
        <div class="field">
            <label for="detail">お問い合わせ内容</label>
            <div>
                <textarea
                    id="detail"
                    name="detail"
                    rows="4"
                    class="input {{ $errors->has('detail') ? 'is-invalid' : '' }}">{{ old('detail') }}</textarea>
                <div class="muted" id="detailCount"></div>

                @error('detail')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </section>
    <script>
        (() => {
            const ta = document.getElementById('detail');
            const counter = document.getElementById('detailCount');
            if (!ta || !counter) return;
            const MAX = 120;
            const update = () => {
                const n = ta.value.length;
                counter.textContent = `${n}/${MAX}`;
                counter.classList.toggle('over', n > MAX);
            };
            ta.addEventListener('input', update);
            update();
        })();
    </script>
    <button type="submit" class="btn btn--primary">確認画面</button>
</form>
@endsection