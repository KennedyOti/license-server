<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Server - Secure License Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
</head>
<body>
<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="card-title text-center mb-4">Sign Up for License<span>Server</span></h2>

                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf

                            <h5 class="mb-4 text-primary">Personal Information</h5>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input id="name" class="form-control form-control-lg" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Personal Email</label>
                                <input id="email" class="form-control form-control-lg" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email" />
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <h5 class="mb-4 text-primary mt-5">Company Information</h5>

                            <!-- Company Name -->
                            <div class="mb-3">
                                <label for="company_name" class="form-label fw-semibold">Company Name</label>
                                <input id="company_name" class="form-control form-control-lg" type="text" name="company_name" :value="old('company_name')" required autocomplete="organization" placeholder="Enter company name" />
                                @error('company_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Email -->
                            <div class="mb-3">
                                <label for="company_email" class="form-label fw-semibold">Company Email</label>
                                <input id="company_email" class="form-control form-control-lg" type="email" name="company_email" :value="old('company_email')" required autocomplete="email" placeholder="Enter company email" />
                                @error('company_email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Industry -->
                            <div class="mb-3">
                                <label for="industry" class="form-label fw-semibold">Industry</label>
                                <select id="industry" class="form-select form-select-lg" name="industry" required>
                                    <option value="">Select Industry</option>
                                    <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                    <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                    <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                    <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>Education</option>
                                    <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>Retail</option>
                                    <option value="Manufacturing" {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                    <option value="Other" {{ old('industry') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('industry')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <h5 class="mb-4 text-primary mt-5">Security</h5>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input id="password" class="form-control form-control-lg" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password" />
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                <input id="password_confirmation" class="form-control form-control-lg" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                                @error('password_confirmation')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Create Account</button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}">Already registered?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            // Optional: Add client-side validation with SweetAlert
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            if (password !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Passwords do not match. Please try again.',
                });
            }
        });
    </script>
</body>
</html>
