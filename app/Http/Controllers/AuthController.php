<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()
                ->route(
                    'inventory.index'
                );
        }

        return view(
            'auth.login'
        );
    }

    public function login(
        Request $request
    ): RedirectResponse {
        $data =
            $request->validate([
                'email' => [
                    'required',
                    'email',
                    'max:150',
                ],

                'password' => [
                    'required',
                    'string',
                ],
            ]);

        $key =
            Str::lower(
                $data['email']
            )
            .'|'
            .$request->ip();

        if (
            RateLimiter::tooManyAttempts(
                $key,
                5
            )
        ) {
            $seconds =
                RateLimiter::availableIn(
                    $key
                );

            return back()
                ->withInput(
                    $request->only(
                        'email'
                    )
                )
                ->withErrors([
                    'email' =>
                        "Demasiados intentos. Intenta nuevamente en {$seconds} segundos.",
                ]);
        }

        if (
            Auth::attempt([
                'email' =>
                    $data['email'],

                'password' =>
                    $data['password'],
            ])
        ) {
            $request
                ->session()
                ->regenerate();

            RateLimiter::clear(
                $key
            );

            return redirect()
                ->intended(
                    route(
                        'inventory.index'
                    )
                );
        }

        RateLimiter::hit(
            $key,
            60
        );

        return back()
            ->withInput(
                $request->only(
                    'email'
                )
            )
            ->withErrors([
                'email' =>
                    'El correo o la contraseña son incorrectos.',
            ]);
    }

    public function logout(
        Request $request
    ): RedirectResponse {
        Auth::logout();

        $request
            ->session()
            ->invalidate();

        $request
            ->session()
            ->regenerateToken();

        return redirect()
            ->route('home');
    }
}