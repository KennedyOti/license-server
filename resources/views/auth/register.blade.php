<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Server - Secure License Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
</head>
<body>
<section class="auth-page">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Join License<span>Server</span></h2>
        </div>

        <div class="auth-body">
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-custom alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-custom alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm" class="register-form">
                @csrf

                <!-- Personal Information -->
                <div class="form-section">
                    <h5><i class="bi bi-person me-2"></i>Personal Information</h5>

                    <div class="input-group-custom">
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
                        <i class="bi bi-person input-icon"></i>
                        @error('name')
                            <div class="text-danger mt-1 small">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="input-group-custom">
                        <label for="email" class="form-label">Personal Email</label>
                        <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your personal email" />
                        <i class="bi bi-envelope input-icon"></i>
                        @error('email')
                            <div class="text-danger mt-1 small">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Company Information -->
                <div class="form-section">
                    <h5><i class="bi bi-building me-2"></i>Company Information</h5>

                    <div class="input-group-custom">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input id="company_name" class="form-control" type="text" name="company_name" :value="old('company_name')" required autocomplete="organization" placeholder="Enter company name" />
                        <i class="bi bi-building input-icon"></i>
                        @error('company_name')
                            <div class="text-danger mt-1 small">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="input-group-custom">
                        <label for="company_email" class="form-label">Company Email</label>
                        <input id="company_email" class="form-control" type="email" name="company_email" :value="old('company_email')" required autocomplete="email" placeholder="Enter company email" />
                        <i class="bi bi-envelope-at input-icon"></i>
                        @error('company_email')
                            <div class="text-danger mt-1 small">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="input-group-custom">
                        <label for="industry" class="form-label">Industry</label>
                        <select id="industry" class="form-select" name="industry" required>
                            <option value="">Select Industry</option>
                            <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>Technology</option>
                            <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                            <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Manufacturing" {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                            <option value="Other" {{ old('industry') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <i class="bi bi-briefcase input-icon"></i>
                        @error('industry')
                            <div class="text-danger mt-1 small">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Security -->
                <div class="form-section form-section-full">
                    <h5><i class="bi bi-shield-lock me-2"></i>Security</h5>

                    <div class="input-group-custom">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password" />
                        <i class="bi bi-lock input-icon"></i>
                        <div class="password-strength" id="password-strength" style="display: none;">
                            <div class="strength-meter">
                                <div class="strength-fill" id="strength-fill"></div>
                            </div>
                            <div class="strength-text" id="strength-text"></div>
                        </div>
                        @error('password')
                            <div class="text-danger mt-1 small">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="input-group-custom">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                        <i class="bi bi-lock-fill input-icon"></i>
                        @error('password_confirmation')
                            <div class="text-danger mt-1 small">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-auth">
                    <i class="bi bi-person-plus me-2"></i>Create Account
                </button>
            </form>

            <div class="auth-links">
                <span class="text-muted">Already have an account?</span>
                <a href="{{ route('login') }}" class="ms-2">Sign in here</a>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthMeter = document.getElementById('password-strength');
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let feedback = [];

        if (password.length >= 8) strength++;
        else feedback.push('At least 8 characters');

        if (/[a-z]/.test(password)) strength++;
        else feedback.push('Lowercase letter');

        if (/[A-Z]/.test(password)) strength++;
        else feedback.push('Uppercase letter');

        if (/[0-9]/.test(password)) strength++;
        else feedback.push('Number');

        if (/[^A-Za-z0-9]/.test(password)) strength++;
        else feedback.push('Special character');

        if (password.length > 0) {
            strengthMeter.style.display = 'block';
            strengthFill.className = 'strength-fill';

            if (strength <= 2) {
                strengthFill.classList.add('strength-weak');
                strengthText.textContent = 'Weak password';
                strengthText.style.color = '#dc3545';
            } else if (strength <= 4) {
                strengthFill.classList.add('strength-medium');
                strengthText.textContent = 'Medium strength';
                strengthText.style.color = '#ffc107';
            } else {
                strengthFill.classList.add('strength-strong');
                strengthText.textContent = 'Strong password';
                strengthText.style.color = '#28a745';
            }
        } else {
            strengthMeter.style.display = 'none';
        }
    });

    // Form validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'Passwords do not match. Please try again.',
                confirmButtonColor: '#d32f2f'
            });
        }
    });
</script>
</body>
</html>
