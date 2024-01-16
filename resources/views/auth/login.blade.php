 @extends('layouts.layout_login')

@section('content_login')

<div id="logreg-forms" >
    <style>
        
        .dk{
                display: flex;
            justify-content: center;
            text-align: center;
            padding: 5px;
        }
        .dk a{
            justify-content: center;
            text-align: center;
            margin: 0 0 7 px;
        }
        .dk h6{
            padding: 15px;
        }
    </style>
        <form action="{{route('login')}}" method="POST">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Đăng Nhập Web Phim</h1>
            <div class="social-login" style="display: flex;">
                <a href="{{route('login-by-facebook')}}"><button class="btn facebook-btn social-btn" type="button"><span><i class="fab fa-facebook-f"></i> Sign in with Facebook</span> </button></a>
                <a href="{{ route('login-by-google') }}"><button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i> Sign in with Google+</span> </button></a>
            </div>
            <p style="text-align:center"> OR  </p>
            <!-- <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required=""> -->
            <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>


                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="********">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkbox" onclick="hidePassword();">
                                    <label class="form-check-label">
                                       Show Password 
                                    </label>
                                </div>
                                
                            </div>
                        </div>
            
            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</button>
            @if(Route::has('password.request'))
            <a class="btn btn-link" href="{{route('password.request')}}" id="forgot_pswd">{{ __('Forgot Your Password?')}}</a>
            @endif
            <hr>
           <!--  <p>Don't have an account!</p> 
            <button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fas fa-user-plus"></i> Sign up New Account</button> -->

            @if(Route::has('register'))
                <div class="dk">
                    <h6>Don't have an account!</h6> 
                    <a href="{{route('register')}}"><i class="fas fa-user-plus"></i> {{ __('Register')}}</a>
                </div>
            @endif
            </form>
            <br>
            

    </div>

@endsection
