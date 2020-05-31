<svg {{ $attributes->merge(['class' => "w-$size h-$size"]) }}>
    <use xlink:href="/fa.svg#{{ $icon }}"></use>
</svg>
