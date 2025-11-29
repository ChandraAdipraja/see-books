@props([
    'padded' => false,
    'minFullscreen' => false,
    'containerClass' => '',
])

@php
    $sectionClasses = collect([
        'container flex flex-col lg:max-w-screen-lg mx-auto',
        $minFullscreen ? 'flex min-h-[calc(100vh-144px)] w-full flex-col' : '',
        $padded ? 'px-4' : '',
        $attributes->get('class'), // extra class dari pemanggil
    ])->filter()->implode(' ');
@endphp

<div class="relative h-full w-full {{ $containerClass }}">
    <section {{ $attributes->except('class')->merge(['class' => $sectionClasses]) }}>
        @yield('content')
    </section>
</div>
