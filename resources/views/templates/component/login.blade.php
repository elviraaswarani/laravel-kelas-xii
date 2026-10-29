<div class="modal video-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        Account
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
      </div>
      <section>
        <div class="modal-body">
          <div class="w3_login_module">
            <div class="module form-module">
              <button type="button" class="toggle" aria-label="Switch to register">
                <i class="fa fa-pencil"></i>
                <span class="tooltip">Register</span>
              </button>
              @if ($errors->any() || session('status'))
                <div class="auth-feedback {{ $errors->any() ? 'auth-feedback-error' : '' }}" role="alert">
                  @if (session('status'))
                    {{ session('status') }}
                  @else
                    {{ $errors->first() }}
                  @endif
                </div>
              @endif
              <div class="form login-form">
                <h3>Sign in</h3>
                <form action="{{ route('login') }}" method="post">
                  @csrf
                  <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" autocomplete="email" required>
                  <input type="password" name="password" placeholder="Password" autocomplete="current-password" required>
                  <label class="remember-option"><input type="checkbox" name="remember" value="1"> Remember me</label>
                  <button type="submit" class="auth-submit">Login</button>
                </form>
              </div>
              <div class="form register-form">
                <h3>Create an account</h3>
                <form action="{{ route('register') }}" method="post">
                  @csrf
                  <input type="text" name="name" placeholder="Full name" value="{{ old('name') }}" autocomplete="name" required>
                  <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" autocomplete="email" required>
                  <input type="password" name="password" placeholder="Password (minimum 8 characters)" autocomplete="new-password" minlength="8" required>
                  <input type="password" name="password_confirmation" placeholder="Confirm password" autocomplete="new-password" minlength="8" required>
                  <button type="submit" class="auth-submit">Create account</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<script>
  $(function () {
    var module = $('.form-module');
    var toggle = $('.toggle');
    var setMode = function (register) {
      module.toggleClass('register-active', register);
      toggle.attr('aria-label', register ? 'Switch to login' : 'Switch to register');
      toggle.find('.tooltip').text(register ? 'Login' : 'Register');
      toggle.find('i').toggleClass('fa-pencil', !register).toggleClass('fa-times', register);
    };

    toggle.on('click', function () {
      setMode(!module.hasClass('register-active'));
    });

    @if (session('auth_form') === 'register')
      setMode(true);
    @endif

    @if ($errors->any() || session('status') || session('auth_form'))
      $('#myModal').modal('show');
    @endif
  });
</script>