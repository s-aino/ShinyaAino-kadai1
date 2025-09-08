@extends('layouts.auth')

@section('auth_body')
  <p style="text-align:center; margin:8px 0 24px;">お問い合わせありがとうございました</p>
  <div style="text-align:center">
    <a href="{{ url('/') }}" class="btn btn--primary">HOME</a>
  </div>
@endsection
