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
                      <div class="mb-2 text-center">
                        @if($errors->any())
                            <span class="text-danger"><i>{{$errors->first()}}</i></span>
                        @endif
                      </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                                <input id="email" placeholder="E-Mail Address" style="background-color:#232220;border-radius:15px;border:none;color:gray" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        
                                <input id="password" style="background-color:#232220;border-radius:15px;border:none;color:gray" type="password" class="form-control mt-2 @error('password') is-invalid @enderror" name="password" required placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        
                        <button type="submit" class="btn btn-info form-control mt-3" style="border-radius:15px;">
                                {{ __('Login') }}
                        </button>
                        <div class="form-group row mb-0">
                          
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
