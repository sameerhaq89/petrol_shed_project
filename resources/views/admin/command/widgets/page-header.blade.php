<div class="page-header" style="margin: 0 0 0.8rem 0;">
    <h3 class="page-title">
        @if(!empty($icon))
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="{{ $icon }}"></i>
            </span>
        @endif
        {{ $title }}
    </h3>

    @if(!empty($showButton))
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <button class="{{ $buttonClass }}" id="{{ $buttonId }}">
                        <i class="{{ $buttonIcon }}"></i> {{ $buttonText }}
                    </button>
                </li>
            </ul>
        </nav>
    @endif
</div>

