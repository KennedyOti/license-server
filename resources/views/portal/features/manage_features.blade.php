@extends('layouts.portal')

@section('title', 'Manage Features - License Server')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Features</h2>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="table-container">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Product</th>
                    <th>Feature Name</th>
                    <th>Code</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse($features as $feature)
                <tr>
                    <td>{{ $feature->product->company->name }}</td>
                    <td>{{ $feature->product->name }}</td>
                    <td>{{ $feature->name }}</td>
                    <td>{{ $feature->code }}</td>
                    <td>{{ $feature->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No features found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection