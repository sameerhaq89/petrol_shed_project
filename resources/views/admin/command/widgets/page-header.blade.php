<div class="page-header" style="margin: 0 0 0.8rem 0;">

    <h3 class="page-title">
        @if (!empty($icon))
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="{{ $icon }}"></i>
            </span>
        @endif
        {{ $title }}
    </h3>

    {{-- BREADCRUMBS + ACTIONS ROW --}}
    <div class="d-flex justify-content-between align-items-center">

        {{-- BREADCRUMBS (ONLY LINKS HERE) --}}
        @if (!empty($breadcrumbs))
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @php
                            $label = $breadcrumb['label'] ?? '';
                            $url   = $breadcrumb['url'] ?? null;
                            $class = $breadcrumb['class'] ?? 'text-decoration-none';
                        @endphp

                        @if ($url)
                            <li class="breadcrumb-item">
                                <a href="{{ $url }}" class="{{ $class }}">
                                    {{ $label }}
                                </a>
                            </li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $label }}
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif

        {{-- ACTION BUTTONS (OUTSIDE BREADCRUMB NAV) --}}
        @if (!empty($showButton))
            <div class="breadcrumb-actions d-flex gap-2">

                {{-- LINK BUTTON --}}
                @if (!empty($link))
                    @can($link['can'])
                        <a href="{{ $link['url'] }}" class="{{ $buttonClass }}">
                            <i class="{{ $buttonIcon }}"></i> {{ $buttonText }}
                        </a>
                    @endcan

                {{-- FORM BUTTON --}}
                @elseif (!empty($form))
                    <form action="{{ $form['action'] }}" method="{{ $form['method'] }}" class="d-inline">
                        @csrf
                        <button type="submit" class="{{ $buttonClass }}">
                            <i class="{{ $buttonIcon }}"></i> {{ $buttonText }}
                        </button>
                    </form>

                {{-- MODAL / NORMAL BUTTON --}}
                @else
                    <button
                        type="button"
                        class="{{ $buttonClass }}"
                        @isset($buttonId) id="{{ $buttonId }}" @endisset
                        @isset($dataBsToggle) data-bs-toggle="{{ $dataBsToggle }}" @endisset
                        @isset($dataBsTarget) data-bs-target="{{ $dataBsTarget }}" @endisset
                    >
                        <i class="{{ $buttonIcon }}"></i> {{ $buttonText }}
                    </button>
                @endif

            </div>
        @endif

    </div>
</div>
