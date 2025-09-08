{{-- resources/views/layouts/auth.blade.php --}}
@extends('layouts.app')

@section('content')
    @php
        // 見出しは auth_title > title の優先順で取得
        $pageTitle  = trim($__env->yieldContent('auth_title'))
                   ?: trim($__env->yieldContent('title'));

        // パネル幅はデフォルト「狭め」、必要に応じて各ページで上書き可
        // 例）@section('panel_class', 'form-panel')  // 広い
        //    @section('panel_class', 'form-panel form--narrow') // 狭い（デフォルト）
        $panelClass = trim($__env->yieldContent('panel_class')) ?: 'form-panel form--narrow';

        // どうしてもパネルでラップしたくないページ用（通常は使わない）
        // 例）@section('no_panel', '1')
        $noPanel = trim($__env->yieldContent('no_panel')) !== '';
    @endphp

    @if ($pageTitle)
        <h1 class="page-title">{{ $pageTitle }}</h1>
    @endif

    @if ($noPanel)
        {{-- パネルラップを使わない。ページ側で完全に自由にレイアウトしたい場合のみ --}}
        @if (trim($__env->yieldContent('auth_body')))
            @yield('auth_body')
        @else
            @yield('content')
        @endif
    @else
        {{-- 通常はパネルでラップ（デフォルトは狭め） --}}
        <section class="{{ $panelClass }}">
            @if (trim($__env->yieldContent('auth_body')))
                {{-- 既存の auth_* 方式（互換） --}}
                @yield('auth_body')
            @else
                {{-- 新方式：通常の @section('content') をそのまま描画 --}}
                @yield('content')
            @endif
        </section>
    @endif
@endsection
