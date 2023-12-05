@extends('admin.layout.app')

@push('css')
    <style type="text/css">
        #showHidePassword {
            position: relative;
        }

        label::after {
            content: '*';
            color: red;
        }

        #togglePassword,
        #togglePasswordConfirm {
            position: absolute;
            top: 45%;
            right: 14px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#togglePassword i').click(function(event) {
                event.preventDefault();
                const passwordInput = $('#password');
                const togglePassword = $('#togglePassword i');

                if (passwordInput.attr('type') === 'text') {
                    passwordInput.attr('type', 'password');
                    togglePassword.removeClass('bi-eye-slash').addClass('bi-eye');
                } else if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    togglePassword.removeClass('bi-eye').addClass('bi-eye-slash');
                }
            });

            $('#togglePasswordConfirm i').click(function(event) {
                event.preventDefault();
                const passwordConfirmInput = $('#password-confirm');
                const toggleConfirmPassword = $('#togglePasswordConfirm i');

                if (passwordConfirmInput.attr('type') === 'text') {
                    passwordConfirmInput.attr('type', 'password');
                    toggleConfirmPassword.removeClass('bi-eye-slash').addClass('bi-eye');
                } else if (passwordConfirmInput.attr('type') === 'password') {
                    passwordConfirmInput.attr('type', 'text');
                    toggleConfirmPassword.removeClass('bi-eye').addClass('bi-eye-slash');
                }
            });
        });
    </script>
@endpush

@section('app')
    <div class="card">
        <div class="card-header">{{ $name }}</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('user.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text"
                                class="form-control form-control-sm @error('name')
                            is-invalid
                            @enderror"
                                id="name" name="name" value="{{ old('name') }}" autofocus placeholder="ex: budi">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email"
                                class="form-control form-control-sm @error('email')
                            is-invalid
                            @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="ex: name@gmail.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password">{{ __('Password') }}</label>
                            <div id="showHidePassword">
                                <input id="password" type="password"
                                    class="form-control form-control-sm @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password" placeholder="Masukan Password" autocomplete="current-password">
                                <a href="javascript:;" id="togglePassword" class="bg-transparent"><i
                                        class="bi bi-eye"></i></a>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <div id="showHidePassword">
                                <input id="password-confirm" type="password" class="form-control form-control-sm"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Masukan Confirm Password">
                                <a href="javascript:;" id="togglePasswordConfirm" class="bg-transparent"><i
                                        class="bi bi-eye"></i></a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-warning"><i
                                    class="bi bi-skip-backward"></i></a>
                            <button type="submit" class="btn btn-sm btn-success ms-2"><i class="bi bi-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
