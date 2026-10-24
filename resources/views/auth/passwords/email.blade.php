@extends('layouts.admin') {{-- Ganti sesuai nama layout admin kamu --}}

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5 shadow">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Reset Password Admin</h4>
                </div>
                <div class="card-body p-4">

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
<!-- hhahaahh -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Admin</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger w-100">
                            Kirim Link Reset Password
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection