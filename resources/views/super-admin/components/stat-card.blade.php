<div class="stat-card {{ $cardClass ?? '' }}">
    <div class="stat-card-content">
        <div class="stat-info">
            <h3 class="stat-title">{{ $title }}</h3>
            <div class="stat-value-wrapper">
                <p class="stat-value">{{ $value }}</p>
                @if (isset($trend))
                    <span class="stat-trend {{ $trend == 'up' ? 'trend-up' : 'trend-down' }}">
                        <i class="fas fa-arrow-{{ $trend == 'up' ? 'up' : 'down' }}"></i>
                    </span>
                @endif
            </div>
        </div>
        <div class="stat-icon">
            <div class="icon-wrapper {{ $iconClass ?? '' }}">
                <i class="{{ $icon }}"></i>
            </div>
        </div>
    </div>
</div>
