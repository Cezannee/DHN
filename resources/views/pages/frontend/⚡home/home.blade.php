@php
    $heroBackgroundMedia = setting_media_items('home_background_media', [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'webp',
        'svg',
        'mp4',
        'webm',
        'ogg',
    ]);
    $galleryImages = setting_media_items('home_gallery_images', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
@endphp

<div>
    <section class="relative overflow-hidden bg-white dark:bg-gray-900">
        @if ($heroBackgroundMedia !== [])
            <div
                class="absolute inset-0 z-0 bg-white dark:bg-gray-900"
                data-home-background-slider
                aria-hidden="true"
            >
                @foreach ($heroBackgroundMedia as $media)
                    <div
                        class="home-hero-slide absolute inset-0 {{ $loop->first ? 'is-active' : '' }}"
                        data-home-background-slide
                    >
                        @if ($media['type'] === 'video')
                            <video
                                class="h-full w-full object-cover"
                                muted
                                loop
                                playsinline
                                preload="metadata"
                                @if ($loop->first) autoplay @endif
                            >
                                <source src="{{ $media['url'] }}" type="video/{{ $media['extension'] }}" />
                            </video>
                        @else
                            <img
                                class="h-full w-full object-cover"
                                src="{{ $media['url'] }}"
                                alt=""
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <div class="relative z-10 mx-auto max-w-7xl px-4 py-24 text-center sm:px-12">
            <div class="m-6 flex justify-center">
                <img class="h-24 rounded-sm" src="{{ asset('img/logo-square.jpg') }}" alt="{{ site_name() }}" />
            </div>
            <h1
                class="mb-6 text-4xl font-extrabold leading-none tracking-tight text-gray-900 sm:text-6xl dark:text-white"
            >
                {{ site_name() }}
            </h1>
            <p class="mb-10 text-lg font-normal text-gray-500 sm:px-16 sm:text-2xl xl:px-48 dark:text-gray-400">
                {!! site_description() !!}
            </p>
            <div class="mb-8 flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-x-4 sm:space-y-0 lg:mb-16">
                <a
                    class="inline-flex items-center justify-center rounded-lg bg-gray-700 px-5 py-3 text-center text-base font-medium text-white hover:bg-gray-800 focus:ring-4 focus:ring-gray-300"
                    href="{{ app_url() }}"
                    target="_blank"
                >
                    <svg
                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-github"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5"
                        />
                    </svg>
                    <span class="ms-2">Website</span>
                </a>
                <a
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-center text-base font-medium text-gray-900 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:border-gray-700 dark:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-800"
                    href="{{ app_url() }}"
                    target="_blank"
                >
                    <svg
                        class="icon icon-tabler icons-tabler-outline icon-tabler-world-www"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M19.5 7a9 9 0 0 0 -7.5 -4a8.991 8.991 0 0 0 -7.484 4" />
                        <path d="M11.5 3a16.989 16.989 0 0 0 -1.826 4" />
                        <path d="M12.5 3a16.989 16.989 0 0 1 1.828 4" />
                        <path d="M19.5 17a9 9 0 0 1 -7.5 4a8.991 8.991 0 0 1 -7.484 -4" />
                        <path d="M11.5 21a16.989 16.989 0 0 1 -1.826 -4" />
                        <path d="M12.5 21a16.989 16.989 0 0 0 1.828 -4" />
                        <path d="M2 10l1 4l1.5 -4l1.5 4l1 -4" />
                        <path d="M17 10l1 4l1.5 -4l1.5 4l1 -4" />
                        <path d="M9.5 10l1 4l1.5 -4l1.5 4l1 -4" />
                    </svg>
                    <span class="ms-2">Company Profile</span>
                </a>
            </div>

            @include('frontend.includes.messages')
        </div>
    </section>

    @if ($galleryImages !== [])
        <section class="bg-gray-100 py-20 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
            <div class="container mx-auto flex flex-col items-center justify-center px-5">
                <div class="w-full text-center lg:w-2/3">
                    <h1 class="mb-4 text-3xl font-medium text-gray-800 sm:text-4xl dark:text-gray-200">
                        Galeri Produk
                    </h1>

                    <p class="mb-8 leading-relaxed">
                        Dokumentasi produk dari {{ site_name() }}.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-gray-50 pb-20 dark:bg-gray-700">
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($galleryImages as $image)
                    <a
                        class="group block overflow-hidden rounded-lg bg-white shadow-lg dark:bg-gray-800"
                        href="{{ $image['url'] }}"
                        target="_blank"
                        rel="noopener"
                    >
                        <img
                            class="aspect-[4/3] w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            loading="lazy"
                            src="{{ $image['url'] }}"
                            alt="Galeri Produk {{ $loop->iteration }} {{ site_name() }}"
                        />
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>
