<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::loginView(fn() => view('auth.login'));
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
            return null;
        });
        Fortify::registerView(fn() => view('auth.register'));
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        Fortify::authenticateUsing(function (Request $request) {
            // 送信された値をログに出して確認（動作確認用。不要なら後で消してください）
            // \Log::debug('login payload', $request->only('email', 'password'));

            Validator::make(
                $request->all(),
                [
                    // ← ポイント: 'email:filter' にすると「一般的なメール形式」チェックが安定して通る
                    'email'    => ['required', 'string', 'email:filter'],
                    'password' => ['required', 'string'],
                ],
                [
                    'email.required'    => 'メールアドレスを入力してください。',
                    'email.email'       => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください。',
                    'password.required' => 'パスワードを入力してください。',
                ],
                [
                    'email'    => 'メールアドレス',
                    'password' => 'パスワード',
                ]
            )->validate();

            // 以降はそのまま（認証処理）
            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
            return null;
        });
    }
}
