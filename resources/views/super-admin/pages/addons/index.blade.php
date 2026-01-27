@extends('super-admin.layouts.master')

@section('title', 'Addons Management - SuperAdmin Panel')

@section('content')
    <div class="dashboard-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Addons Management</h1>
            <a href="{{ route('super-admin.addons.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Addon
            </a>
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

        <!-- Addons Grid -->
        <div class="addons-grid">
            @foreach($addons as $addon)
                <div class="addon-card {{ !$addon->is_active ? 'inactive-addon' : '' }}">
                    <div class="addon-icon">
                        <i class="{{ $addon->icon ?? 'fas fa-puzzle-piece' }}"></i>
                    </div>
                    
                    <div class="addon-header">
                        <h3 class="addon-name">{{ $addon->name }}</h3>
                        @if(!$addon->is_active)
                            <span class="badge badge-secondary">Inactive</span>
                        @else
                            <span class="badge badge-success">Active</span>
                        @endif
                    </div>

                    <p class="addon-slug">{{ $addon->slug }}</p>

                    @if($addon->description)
                        <p class="addon-description">{{ $addon->description }}</p>
                    @endif

                    <div class="addon-meta">
                        <span class="sort-order">Order: {{ $addon->sort_order }}</span>
                    </div>

                    <div class="addon-actions">
                        <a href="{{ route('super-admin.addons.edit', $addon->id) }}" class="btn btn-sm btn-outline">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('super-admin.addons.toggle-status', $addon->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline">
                                <i class="fas fa-{{ $addon->is_active ? 'eye-slash' : 'eye' }}"></i>
                                {{ $addon->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('super-admin.addons.destroy', $addon->id) }}" method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this addon?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .addons-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }

        .addon-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 2px solid transparent;
            transition: all 0.3s ease;
            text-align: center;
        }

        .addon-card:hover {
            border-color: #6366f1;
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.2);
        }

        .inactive-addon {
            opacity: 0.6;
        }

        .addon-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .addon-icon i {
            font-size: 32px;
            color: white;
        }

        .addon-header {
            margin-bottom: 8px;
        }

        .addon-name {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 8px 0;
        }

        .addon-slug {
            font-size: 12px;
            color: #9ca3af;
            font-family: monospace;
            margin: 0 0 12px 0;
        }

        .addon-description {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
            margin: 12px 0;
        }

        .addon-meta {
            margin: 16px 0;
            padding: 12px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .sort-order {
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
        }

        .addon-actions {
            display: flex;
            gap: 8px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            flex-wrap: wrap;
            justify-content: center;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-secondary {
            background: #f3f4f6;
            color: #6b7280;
        }
    </style>
@endsection
