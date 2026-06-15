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
    $marketplaces = collect([
        [
            'name' => 'Shopee',
            'url' => setting('marketplace_shopee_url'),
            'icon' => asset('img/iconsmarket/shopee.png'),
        ],
        [
            'name' => 'Tokopedia',
            'url' => setting('marketplace_tokopedia_url'),
            'icon' => asset('img/iconsmarket/tokopedia.png'),
        ],
        [
            'name' => 'TikTok Shop',
            'url' => setting('marketplace_tiktokshop_url'),
            'badge' => 'TS',
            'badge_class' => 'bg-gray-950 text-white dark:bg-gray-100 dark:text-gray-950',
        ],
    ])
        ->map(function (array $marketplace) {
            $url = trim((string) $marketplace['url']);

            if ($url === '') {
                return null;
            }

            $lowerUrl = \Illuminate\Support\Str::lower($url);

            if (\Illuminate\Support\Str::startsWith($lowerUrl, ['javascript:', 'data:'])) {
                return null;
            }

            if (! \Illuminate\Support\Str::startsWith($lowerUrl, ['http://', 'https://'])) {
                $url = 'https://'.$url;
            }

            $marketplace['url'] = $url;

            return $marketplace;
        })
        ->filter()
        ->values();
    $contactTitle = setting('contact_section_title') ?: 'Halaman Kontak';
    $contactDescription = setting('contact_section_description')
        ?: 'Hubungi kami untuk informasi produk, kerja sama, atau pertanyaan lainnya.';
    $contactAddress = trim((string) setting('contact_address'));
    $contactPhone = trim((string) setting('contact_phone'));
    $contactPhoneHref = preg_replace('/[^0-9+]/', '', $contactPhone);
    $contactEmail = trim((string) (setting('contact_email') ?: setting('email')));
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
            @if ($marketplaces->isNotEmpty())
                <div class="mb-8 flex justify-center lg:mb-16">
                    <details class="marketplace-menu group relative inline-block w-full max-w-xs text-left sm:w-auto">
                        <summary
                            class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg bg-emerald-700 px-5 py-3 text-center text-base font-semibold text-white shadow-sm hover:bg-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-300 sm:w-auto dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-900"
                        >
                            <svg
                                class="h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="M6 2l1.5 4h9L18 2" />
                                <path d="M3 6h18l-2 14H5L3 6z" />
                                <path d="M9 10a3 3 0 0 0 6 0" />
                            </svg>
                            <span class="ms-2">Belanja Sekarang!</span>
                            <svg
                                class="ms-2 h-4 w-4 transition-transform group-open:rotate-180"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </summary>

                        <div
                            class="absolute left-1/2 z-20 mt-3 w-full min-w-64 -translate-x-1/2 overflow-hidden rounded-lg border border-gray-200 bg-white p-2 text-gray-900 shadow-xl dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                            @foreach ($marketplaces as $marketplace)
                                <a
                                    class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-semibold transition hover:bg-gray-100 focus:bg-gray-100 focus:outline-none dark:hover:bg-gray-700 dark:focus:bg-gray-700"
                                    href="{{ $marketplace['url'] }}"
                                    target="_blank"
                                    rel="noopener"
                                >
                                    @if (isset($marketplace['icon']))
                                        <img
                                            class="h-9 w-9 shrink-0 rounded-md object-contain"
                                            src="{{ $marketplace['icon'] }}"
                                            alt=""
                                            aria-hidden="true"
                                        />
                                    @else
                                        <span
                                            class="{{ $marketplace['badge_class'] }} flex h-9 w-9 shrink-0 items-center justify-center rounded-md text-base font-extrabold"
                                            aria-hidden="true"
                                        >
                                            {{ $marketplace['badge'] }}
                                        </span>
                                    @endif
                                    <span>{{ $marketplace['name'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </details>
                </div>
            @endif

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

    <section id="contact" class="bg-white py-20 text-gray-700 dark:bg-gray-900 dark:text-gray-300">
        <div class="mx-auto grid max-w-7xl gap-10 px-5 lg:grid-cols-[0.9fr_1.1fr] lg:px-8">
            <div>
                <p class="mb-3 text-sm font-semibold uppercase tracking-widest text-emerald-700 dark:text-emerald-400">
                    Kontak
                </p>
                <h2 class="mb-4 text-3xl font-bold text-gray-900 sm:text-4xl dark:text-white">
                    {{ $contactTitle }}
                </h2>
                <p class="mb-8 max-w-2xl leading-relaxed text-gray-600 dark:text-gray-400">
                    {{ $contactDescription }}
                </p>

                <div class="space-y-4">
                    @if ($contactAddress !== '')
                        <div class="flex gap-4 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-emerald-700 text-white">
                                <svg
                                    class="h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <path d="M12 21s7 -4.35 7 -11a7 7 0 1 0 -14 0c0 6.65 7 11 7 11z" />
                                    <path d="M12 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-1 font-semibold text-gray-900 dark:text-white">Alamat</h3>
                                <p class="leading-relaxed">{!! nl2br(e($contactAddress)) !!}</p>
                            </div>
                        </div>
                    @endif

                    @if ($contactPhone !== '')
                        <div class="flex gap-4 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-emerald-700 text-white">
                                <svg
                                    class="h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -16 -16a2 2 0 0 1 2 -2" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-1 font-semibold text-gray-900 dark:text-white">Nomor Kontak</h3>
                                @if ($contactPhoneHref !== '')
                                    <a class="hover:text-emerald-700 hover:underline dark:hover:text-emerald-400" href="tel:{{ $contactPhoneHref }}">
                                        {{ $contactPhone }}
                                    </a>
                                @else
                                    <p>{{ $contactPhone }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($contactEmail !== '')
                        <div class="flex gap-4 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-emerald-700 text-white">
                                <svg
                                    class="h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <path d="M4 4h16v16h-16z" />
                                    <path d="M4 7l8 6l8 -6" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="mb-1 font-semibold text-gray-900 dark:text-white">Email</h3>
                                <a class="break-all hover:text-emerald-700 hover:underline dark:hover:text-emerald-400" href="mailto:{{ $contactEmail }}">
                                    {{ $contactEmail }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-lg border border-gray-200 bg-gray-50 p-5 shadow-sm sm:p-8 dark:border-gray-700 dark:bg-gray-800">
                @if (session('contact_status'))
                    <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 dark:border-emerald-900 dark:bg-emerald-950 dark:text-emerald-200">
                        {{ session('contact_status') }}
                    </div>
                @endif

                @if (session('contact_error'))
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-200">
                        {{ session('contact_error') }}
                    </div>
                @endif

                <form class="space-y-5" method="POST" action="{{ route('contact.send') }}">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white" for="contact_name">
                            Nama
                        </label>
                        <input
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-emerald-600 focus:ring-emerald-600 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:placeholder-gray-400"
                            id="contact_name"
                            name="contact_name"
                            type="text"
                            value="{{ old('contact_name') }}"
                            required
                        />
                        @error('contact_name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white" for="contact_email">
                                Email
                            </label>
                            <input
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-emerald-600 focus:ring-emerald-600 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:placeholder-gray-400"
                                id="contact_email"
                                name="contact_email"
                                type="email"
                                value="{{ old('contact_email') }}"
                                required
                            />
                            @error('contact_email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white" for="contact_phone">
                                Nomor Kontak
                            </label>
                            <input
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-emerald-600 focus:ring-emerald-600 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:placeholder-gray-400"
                                id="contact_phone"
                                name="contact_phone"
                                type="text"
                                value="{{ old('contact_phone') }}"
                            />
                            @error('contact_phone')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-900 dark:text-white" for="contact_message">
                            Pesan
                        </label>
                        <textarea
                            class="block min-h-36 w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 focus:border-emerald-600 focus:ring-emerald-600 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:placeholder-gray-400"
                            id="contact_message"
                            name="contact_message"
                            required
                        >{{ old('contact_message') }}</textarea>
                        @error('contact_message')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        class="inline-flex w-full items-center justify-center rounded-lg bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-300 sm:w-auto dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-900"
                        type="submit"
                    >
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
