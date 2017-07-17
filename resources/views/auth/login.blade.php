<div class="login">
    <div class="login-triangle"></div>
    <h2 class="login-header">uniweb.md</h2>
    <form class="form-horizontal login-container" role="form" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-md-6">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <p><input id="email" type="email" class="form-control" placeholder="@lang('admin.email')" name="email" value="{{ old('email') }}"></p>
                @if ($errors->has('email'))
                    <p style="font-size: 16px"><span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
                </span></p>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="col-md-6">
                <p><input id="password" type="password" placeholder="@lang('admin.password')" class="form-control" name="password"></p>
                @if ($errors->has('password'))
                    <p style="font-size: 16px"><span class="help-block"><strong>{{ $errors->first('password') }}</strong></span></p>
                @endif
            </div>
        </div>
        <p><input type="submit" value="@lang('admin.login')"></p>
        {{--<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>--}}
    </form>
</div>
<style>
    /* 'Open Sans' font from Google Fonts */
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);
    body {
        background: #456;
        font-family: 'Open Sans', sans-serif;
    }
    .login {
        width: 400px;
        margin: 7% auto;
        font-size: 14px;
    }



    /* Reset top and bottom margins from certain elements */

    .login-header,

    .login p {

        margin-top: 0;

        margin-bottom: 0;

    }



    /* The triangle form is achieved by a CSS hack */

    .login-triangle {

        width: 0;

        margin-right: auto;

        margin-left: auto;

        border: 12px solid transparent;

        border-bottom-color: #28d;

    }



    .login-header {

        background: #28d;

        padding: 20px;

        font-size: 1.4em;

        font-weight: normal;

        text-align: center;

        text-transform: uppercase;

        color: #fff;

    }



    .login-container {

        background: #ebebeb;

        padding: 12px;

    }



    /* Every row inside .login-container is defined with p tags */

    .login p {

        padding: 12px;

    }



    .login input {

        box-sizing: border-box;

        display: block;

        width: 100%;

        border-width: 1px;

        border-style: solid;

        padding: 16px;

        outline: 0;

        font-family: inherit;

        font-size: 0.95em;

    }



    .login input[type="email"],

    .login input[type="password"] {

        background: #fff;

        border-color: #bbb;

        color: #555;

    }



    /* Text fields' focus effect */

    .login input[type="email"]:focus,

    .login input[type="password"]:focus {

        border-color: #888;

    }



    .login input[type="submit"] {

        background: #28d;

        border-color: transparent;

        color: #fff;

        cursor: pointer;

    }



    .login input[type="submit"]:hover {

        background: #17c;

    }



    /* Buttons' focus effect */

    .login input[type="submit"]:focus {

        border-color: #05a;

    }

</style>