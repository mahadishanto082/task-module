<x-layouts.guest>
<form method="POST" action="{{ route('register') }}">
    @csrf
    
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
            @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
            @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="user_name" class="form-label">Username</label>
        <input type="text" class="form-control" id="user_name" name="user_name" value="{{ old('user_name') }}" required>
        @error('user_name') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Sign up</button>

    <div class="mb-3 mt-2 text-center">
        <span>Already Signed? <a href="{{ route('login') }}" class="text-decoration-none">Login</a></span> 
    </div>
</form>
</x-layouts.guest>
