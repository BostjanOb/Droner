@extends('layouts.app')

@section('content')
    <div class="flex w-screen h-screen items-center justify-center">
        <div class="w-1/3 mx-auto">
            <h1 class="text-6xl font-thin uppercase text-center mb-4">Droner</h1>

            <div class="shadow-lg bg-white p-8 rounded">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <label class="block">
                        <span class="text-gray-700 font-bold">E-Mail Address</span>
                        <input type="email" class="form-input mt-1 block w-full @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </label>

                    @error('email')
                    <div class="bg-red-100 text-red-700 p-2 rounded my-4 text-sm ">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror

                    <label class="block mt-4">
                        <span class="text-gray-700 font-bold">Password</span>
                        <input type="password" class="form-input mt-1 block w-full @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    </label>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <div class="flex my-4">
                        <div class="w-1/2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="form-checkbox h-4 w-4" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span class="ml-2">Remember Me</span>
                                </label>
                        </div>
                        <div class="w-1/2 text-right">
                            @if (Route::has('password.request'))
                                <a class="hover:underline" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="block bg-blue-700 text-blue-100 rounded w-full py-3 text-lg">
                        Login
                    </button>

                </form>
            </div>
        </div>
    </div>
@endsection
