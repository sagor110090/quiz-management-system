@extends('layouts.frontend')
@section('title', __('Register'))

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
        <div class="card smooth-shadow-md">
            <div class="card-body p-6">
                <div class="mb-4">
                    <a href="/"><img src="{{ Storage::url(websiteLog()) }}" class="mb-2" style="    height: 200px;" alt=""></a>
                    <p class="mb-6">Please enter your user information.</p>

                </div>
                @include('layouts.parts.validation-message')

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <!-- name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" required="">
                        @error('name')
                        <span class="error text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>

                        <select name="role" id="role" class="form-select">
                            @foreach (Spatie\Permission\Models\Role::where('name', '!=', 'admin')->get() as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                        @error('name')
                        <span class="error text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" name="email"
                            placeholder="Email address here" required="">

                        @error('email')
                        <span class="error text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password"
                            placeholder="**************" required="">
                    </div>
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm
                            Password</label>
                        <input type="password" id="confirm-password" class="form-control" name="password_confirmation"
                            placeholder="**************" required="">
                        @error('password')
                        <span class="error text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div>
                        <!-- Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Create Free Account
                            </button>
                        </div>

                        <div class="d-md-flex justify-content-between mt-4">
                            <div class="mb-2 mb-md-0">
                                <a href="{{ asset('login') }}" class="">Already
                                    member? Login </a>
                            </div>
                            @if (Route::has('password.request'))
                            <div>
                                <a href="{{ route('password.request') }}" class="text-inherit">
                                    {{ __('Forgot Your Password?') }}
                                </a>

                            </div>
                            @endif


                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
