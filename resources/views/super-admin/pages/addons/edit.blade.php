@extends('super-admin.layouts.master')

@section('title', 'Edit Addon - SuperAdmin Panel')

@section('content')
    <div class="dashboard-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Edit Addon</h1>
            <a href="{{ route('super-admin.addons.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Back to Addons
            </a>
        </div>

        <div class="form-container">
            <form action="{{ route('super-admin.addons.update', $addon->id) }}" method="POST" class="modern-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Addon Name *</label>
                        <input type="text" id="name" name="name" class="form-control" 
                               value="{{ old('name', $addon->name) }}" required>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug *</label>
                        <input type="text" id="slug" name="slug" class="form-control" 
                               value="{{ old('slug', $addon->slug) }}" required>
                        <small class="form-text">URL-friendly name (e.g., inventory, reports)</small>
                        @error('slug')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="icon">Icon (FontAwesome Class)</label>
                        <input type="text" id="icon" name="icon" class="form-control" 
                               value="{{ old('icon', $addon->icon) }}" 
                               placeholder="fas fa-puzzle-piece">
                        <small class="form-text">FontAwesome icon class</small>
                        @error('icon')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="sort_order">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control" 
                               min="0" value="{{ old('sort_order', $addon->sort_order) }}">
                        @error('sort_order')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" 
                                  rows="4">{{ old('description', $addon->description) }}</textarea>
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', $addon->is_active) ? 'checked' : '' }}>
                            <span>Active</span>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Addon
                    </button>
                    <a href="{{ route('super-admin.addons.index') }}" class="btn btn-outline">Cancel</a>
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
