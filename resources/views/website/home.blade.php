@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">Secure License Management <span>Simplified</span></h1>
                <p class="hero-subtitle">A multi-tenant License Server that manages products, plans, features, and licenses with robust validation APIs and comprehensive audit logging.</p>
                <div class="mt-4">
                    <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#signupModal">Get Started</a>
                    <a href="#features" class="btn btn-outline-primary">Learn More</a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/images/dash.png') }}" alt="License Server Dashboard" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>
@endsection