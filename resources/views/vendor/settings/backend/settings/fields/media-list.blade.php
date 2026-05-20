@php
    $required = Str::contains($field["rules"], "required") ? "required" : "";
    $required_mark = $required != "" ? '<span class="text-danger"> <strong>*</strong> </span>' : "";
    $current_value = old($field["name"], setting($field["name"]));

    if (is_array($current_value)) {
        $current_value = implode(PHP_EOL, $current_value);
    }

    $current_value = trim((string) $current_value);
    $selected_paths = collect(preg_split('/[\r\n,]+/', $current_value) ?: [])
        ->map(fn ($path) => trim($path))
        ->filter()
        ->values()
        ->all();

    $media_mode = Arr::get($field, "media", "mixed");
    $extensions = $media_mode === "image"
        ? ["jpg", "jpeg", "png", "gif", "webp", "svg"]
        : ["jpg", "jpeg", "png", "gif", "webp", "svg", "mp4", "webm", "ogg"];
    $accept = collect($extensions)
        ->map(fn ($extension) => "." . $extension)
        ->implode(",");
    $upload_enabled = (bool) Arr::get($field, "upload", false);
    $upload_name = Arr::get($field, "upload_name", $field["name"] . "_uploads");
    $video_extensions = ["mp4", "webm", "ogg"];
    $deletable_directories = collect(Arr::wrap(Arr::get($field, "delete_directories", Arr::get($field, "upload_directory", []))))
        ->map(fn ($directory) => trim(str_replace("\\", "/", (string) $directory), "/"))
        ->filter()
        ->values();
    $selected_media = collect($selected_paths)
        ->map(function ($path) use ($deletable_directories) {
            $path = trim(str_replace("\\", "/", (string) $path), "/");

            return [
                "path" => $path,
                "extension" => Str::lower(pathinfo($path, PATHINFO_EXTENSION)),
                "is_deletable" => $deletable_directories->contains(
                    fn ($directory) => $path !== $directory && Str::startsWith($path, $directory . "/")
                ),
            ];
        })
        ->filter(fn ($media) => $media["path"] !== "")
        ->values();

    $directories = Arr::get($field, "directories", ["img", "storage"]);
    $public_root = str_replace("\\", "/", public_path());

    $available_media = collect($directories)
        ->flatMap(function ($directory) use ($extensions, $public_root) {
            $directory = trim((string) $directory, "/\\");
            $absolute_path = public_path($directory);

            if (! is_dir($absolute_path)) {
                return [];
            }

            return collect(\Illuminate\Support\Facades\File::allFiles($absolute_path))
                ->map(function ($file) use ($extensions, $public_root) {
                    $file_path = str_replace("\\", "/", $file->getPathname());
                    $relative_path = ltrim(Str::after($file_path, $public_root), "/");
                    $extension = Str::lower(pathinfo($relative_path, PATHINFO_EXTENSION));

                    if (! in_array($extension, $extensions, true)) {
                        return null;
                    }

                    return [
                        "path" => $relative_path,
                        "extension" => $extension,
                    ];
                })
                ->filter();
        })
        ->unique("path")
        ->sortBy("path")
        ->take(Arr::get($field, "max_files", 120))
        ->values();
@endphp

<div class="form-group {{ $errors->has($field["name"]) ? " has-error" : "" }} mt-3">
    <label for="{{ $field["name"] }}" class="form-label">
        <strong>{{ __($field["label"]) }}</strong>
        ({{ $field["name"] }})
    </label>
    {!! $required_mark !!}

    @if ($available_media->isNotEmpty())
        <select
            class="form-select {{ Arr::get($field, "class") }}"
            id="{{ $field["name"] }}-selector"
            multiple
            size="8"
            data-media-list-select="{{ $field["name"] }}"
        >
            @foreach ($available_media as $media)
                <option
                    value="{{ $media["path"] }}"
                    @selected(in_array($media["path"], $selected_paths, true))
                >
                    {{ $media["path"] }}
                </option>
            @endforeach
        </select>
        <div class="d-flex flex-wrap gap-2 mt-2">
            <button
                type="button"
                class="btn btn-sm btn-outline-primary"
                data-media-list-apply="{{ $field["name"] }}"
            >
                Gunakan media terpilih
            </button>
            <small class="form-text text-muted">
                Tahan Ctrl atau Shift untuk memilih lebih dari satu file.
            </small>
        </div>
    @else
        <div class="alert alert-info mb-2">
            Belum ada media lokal yang ditemukan. Path public masih bisa diisi manual di bawah.
        </div>
    @endif

    @if ($selected_media->isNotEmpty())
        <div class="mt-3 rounded border p-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <strong>Media aktif</strong>
                @if ($selected_media->contains("is_deletable", true))
                    <button
                        class="btn btn-sm btn-outline-danger"
                        type="submit"
                        name="media_action"
                        value="delete"
                        onclick="return confirm('Hapus media yang dicentang?')"
                    >
                        Hapus media dicentang
                    </button>
                @endif
            </div>

            <div class="row g-3 mt-1">
                @foreach ($selected_media as $media)
                    <div class="col-md-6 col-xl-4">
                        <div class="h-100 rounded border p-2">
                            @if (in_array($media["extension"], $video_extensions, true))
                                <video
                                    class="mb-2 w-100 rounded bg-dark"
                                    controls
                                    preload="metadata"
                                >
                                    <source src="{{ asset($media["path"]) }}" type="video/{{ $media["extension"] }}" />
                                </video>
                            @elseif (in_array($media["extension"], ["jpg", "jpeg", "png", "gif", "webp", "svg"], true))
                                <img
                                    class="mb-2 w-100 rounded border"
                                    src="{{ asset($media["path"]) }}"
                                    alt="{{ $media["path"] }}"
                                    style="aspect-ratio: 16 / 9; object-fit: cover;"
                                />
                            @endif

                            <div class="small text-break">{{ $media["path"] }}</div>

                            @if ($media["is_deletable"])
                                <div class="form-check mt-2">
                                    <input
                                        class="form-check-input"
                                        id="{{ $field["name"] }}-delete-{{ $loop->index }}"
                                        name="delete_media[{{ $field["name"] }}][]"
                                        type="checkbox"
                                        value="{{ $media["path"] }}"
                                    />
                                    <label
                                        class="form-check-label text-danger"
                                        for="{{ $field["name"] }}-delete-{{ $loop->index }}"
                                    >
                                        Hapus file ini
                                    </label>
                                </div>
                            @else
                                <small class="text-muted">
                                    File ini tidak berada di folder upload field ini.
                                </small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($upload_enabled)
        <div class="mt-3 rounded border p-3">
            <label class="form-label" for="{{ $upload_name }}">
                <strong>Upload dari komputer</strong>
            </label>
            <div class="input-group">
                <input
                    class="form-control"
                    id="{{ $upload_name }}"
                    name="{{ $upload_name }}[]"
                    type="file"
                    accept="{{ $accept }}"
                    multiple
                />
                <button class="btn btn-primary" type="submit">
                    Upload media
                </button>
            </div>
            <small class="form-text text-muted">
                File baru akan disimpan ke folder public/{{ trim(Arr::get($field, "upload_directory", ""), "/\\") }} dan otomatis ditambahkan ke daftar.
            </small>
        </div>
    @endif

    <textarea
        name="{{ $field["name"] }}"
        class="form-control mt-2 {{ $errors->has($field["name"]) ? " is-invalid" : "" }}"
        id="{{ $field["name"] }}"
        placeholder="{{ $field["label"] }}"
        rows="6"
        {{ $required }}
    >{{ $current_value }}</textarea>

    @if ($errors->has($field["name"]))
        <small class="invalid-feedback">{{ $errors->first($field["name"]) }}</small>
    @endif

    @if (isset($field["help"]))
        <small class="form-text text-muted">{{ $field["help"] }}</small>
    @endif
</div>
