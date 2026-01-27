@extends('super-admin.layouts.master')

@section('title', 'Edit Subscription Plan - SuperAdmin Panel')

@section('content')
    <div class="dashboard-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Edit Subscription Plan</h1>
            <a href="{{ route('super-admin.plans.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Back to Plans
            </a>
        </div>

        <div class="form-container">
            <form action="{{ route('super-admin.plans.update', $plan->id) }}" method="POST" class="modern-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Plan Name *</label>
                        <input type="text" id="name" name="name" class="form-control" 
                               value="{{ old('name', $plan->name) }}" required>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug *</label>
                        <input type="text" id="slug" name="slug" class="form-control" 
                               value="{{ old('slug', $plan->slug) }}" required>
                        <small class="form-text">URL-friendly name (e.g., basic-plan, premium-plan)</small>
                        @error('slug')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Price ($) *</label>
                        <input type="number" id="price" name="price" class="form-control" 
                               step="0.01" min="0" value="{{ old('price', $plan->price) }}" required>
                        @error('price')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="duration_days">Duration (Days) *</label>
                        <input type="number" id="duration_days" name="duration_days" class="form-control" 
                               min="1" value="{{ old('duration_days', $plan->duration_days) }}" required>
                        <small class="form-text">7 for trial, 30 for monthly plans</small>
                        @error('duration_days')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="max_addons">Max Addons *</label>
                        <select id="max_addons" name="max_addons" class="form-control" required>
                            <option value="0" {{ old('max_addons', $plan->max_addons) == 0 ? 'selected' : '' }}>None (Trial)</option>
                            <option value="1" {{ old('max_addons', $plan->max_addons) == 1 ? 'selected' : '' }}>1 Addon (Basic)</option>
                            <option value="3" {{ old('max_addons', $plan->max_addons) == 3 ? 'selected' : '' }}>3 Addons (Standard)</option>
                            <option value="-1" {{ old('max_addons', $plan->max_addons) == -1 ? 'selected' : '' }}>Unlimited (Premium)</option>
                        </select>
                        @error('max_addons')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" 
                                  rows="4">{{ old('description', $plan->description) }}</textarea>
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_trial" value="1" 
                                   {{ old('is_trial', $plan->is_trial) ? 'checked' : '' }}>
                            <span>Is Trial Plan</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                            <span>Active</span>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Plan
                    </button>
                    <a href="{{ route('super-admin.plans.index') }}" class="btn btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .form-container {
            background: white;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 900px;
            margin: 24px auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 32px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-text {
            display: block;
            margin-top: 4px;
            font-size: 12px;
            color: #6b7280;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .error-message {
            display: block;
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }
    </style>
@endsection
