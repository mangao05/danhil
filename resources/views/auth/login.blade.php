@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-md-4 mt-5">
            <div class="card text-white pt-3 pb-5" style="background-color:black;font-family:Arial, Helvetica, sans-serif">
                <div class="card-header h2">
                    Login
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- <div class="form-group row"> --}}
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> --}}

                            {{-- <div class="col-md-6"> --}}
                                <input id="email" placeholder="E-Mail Address" style="background-color:#232220;border-radius:15px;border:none;color:gray" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            {{-- </div> --}}
                        {{-- </div> --}}

                        {{-- <div class="form-group row"> --}}
                            {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> --}}

                            {{-- <div class="col-md-6"> --}}
                                <input id="password" style="background-color:#232220;border-radius:15px;border:none;color:gray" type="password" class="form-control mt-2 @error('password') is-invalid @enderror" name="password" required placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            {{-- </div> --}}
                        {{-- </div> --}}

                        {{-- <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                        <button type="submit" class="btn btn-info form-control mt-3" style="border-radius:15px;">
                                {{ __('Login') }}
                        </button>
                        <div class="form-group row mb-0">
                            {{-- <div class="col-md-8"> --}}
                                {{-- <button type="submit" class="btn btn-primary form-control">
                                    {{ __('Login') }}
                                </button> --}}

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            {{-- </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-5 p-5 text-white">
            <span class="h3 font-weight-bold ">DANHIL INTERPRISES</span>
            <p class="mt-3" style="text-indent:50px;text-align:justify">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </p>
            <button class="btn btn-warning font-weight-bold" style="letter-spacing:1px;"  >Inquire Now!!!</button>
        </div>
    </div>
</div>
@endsection
