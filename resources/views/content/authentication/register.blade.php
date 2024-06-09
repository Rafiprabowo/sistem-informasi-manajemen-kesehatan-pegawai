<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Register</title>
    <!-- CSS files -->
    <link href="{{asset('./dist/css/tabler.min.css?1684106062')}}" rel="stylesheet"/>
    <link href="{{asset('./dist/css/tabler-flags.min.css?1684106062')}}" rel="stylesheet"/>
    <link href="{{asset('./dist/css/tabler-payments.min.css?1684106062')}}" rel="stylesheet"/>
    <link href="{{asset('./dist/css/tabler-vendors.min.css?1684106062')}}" rel="stylesheet"/>
    <link href="{{asset('./dist/css/demo.min.css?1684106062')}}}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="{{asset('./dist/js/demo-theme.min.js?1684106062')}}"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="../user" class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg" height="36" alt=""></a>
        </div>
          @if($errors->any())
                <div class="alert alert-danger m-3">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li class="alert-title">{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
          @endif


        <form class="card card-md" action="/register" method="post" autocomplete="off" novalidate>
            @csrf
            @method('post')
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Create new account</h2>
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter name">
            </div>
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Enter username">
            </div>
            <div class="mb-3">
              <label class="form-label">Email address</label>
              <input type="email" name="email" class="form-control" placeholder="Enter email">
            </div>
            <div class="mb-3">
              <label class="form-label">Address</label>
              <input type="text" name="address" class="form-control" placeholder="Enter address">
            </div>
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="phone" class="form-control" placeholder="+62xxxx">
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <div class="input-group input-group-flat">
                <input type="password" name="password" class="form-control"  placeholder="Password"  autocomplete="off">
              </div>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Create new account</button>
            </div>
          </div>
        </form>
        <div class="text-center text-muted mt-3">
          Already have account? <a href="/login" tabindex="-1">Sign in</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{asset('./dist/js/tabler.min.js?1684106062')}}" defer></script>
    <script src="{{asset('./dist/js/demo.min.js?1684106062')}}" defer></script>
  </body>
</html>
