<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nasirkhan\ModuleManager\Modules\Settings\Http\Controllers\SettingController as BaseSettingController;

class SettingController extends BaseSettingController
{
    public function store(Request $request)
    {
        collect(config('settings.setting_fields'))
            ->pluck('elements')
            ->flatten(1)
            ->filter(fn ($field) => Arr::get($field, 'upload'))
            ->each(function ($field) use ($request): void {
                $this->removeDeletedMedia($request, $field);
                $this->mergeUploadedMedia($request, $field);
            });

        return parent::store($request);
    }

    private function removeDeletedMedia(Request $request, array $field): void
    {
        $fieldName = $field['name'];
        $deletePaths = collect(Arr::wrap($request->input("delete_media.{$fieldName}", [])))
            ->map(fn ($path) => $this->normalizeMediaPath((string) $path))
            ->filter()
            ->unique()
            ->values();

        if ($deletePaths->isEmpty()) {
            return;
        }

        $remainingPaths = $this->mediaPathsFrom($request->input($fieldName, ''))
            ->reject(fn ($path) => $deletePaths->contains($path))
            ->values()
            ->implode(PHP_EOL);

        $request->merge([$fieldName => $remainingPaths]);

        $deletePaths->each(fn ($path) => $this->deletePublicMedia($path, $field));
    }

    private function mergeUploadedMedia(Request $request, array $field): void
    {
        $fieldName = $field['name'];
        $uploadName = Arr::get($field, 'upload_name', $fieldName.'_uploads');

        if (! $request->hasFile($uploadName)) {
            return;
        }

        $extensions = Arr::get($field, 'media') === 'image'
            ? ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']
            : ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'mp4', 'webm', 'ogg'];

        $request->validate([
            $uploadName => ['array'],
            $uploadName.'.*' => ['file', 'mimes:'.implode(',', $extensions), 'max:102400'],
        ]);

        $uploadDirectory = trim(Arr::get($field, 'upload_directory', 'background'), '/\\') ?: 'background';
        $absoluteDirectory = public_path($uploadDirectory);

        File::ensureDirectoryExists($absoluteDirectory, 0755, true);

        $uploadedPaths = collect(Arr::wrap($request->file($uploadName)))
            ->filter(fn ($file) => $file instanceof UploadedFile && $file->isValid())
            ->map(function (UploadedFile $file) use ($absoluteDirectory, $uploadDirectory) {
                $extension = Str::lower($file->getClientOriginalExtension());
                $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $slug = Str::slug($baseName) ?: 'background';
                $filename = now()->format('YmdHis').'-'.Str::random(6).'-'.$slug.'.'.$extension;

                $file->move($absoluteDirectory, $filename);

                return $uploadDirectory.'/'.$filename;
            })
            ->values();

        if ($uploadedPaths->isEmpty()) {
            return;
        }

        $mergedPaths = $this->mediaPathsFrom($request->input($fieldName, ''))
            ->merge($uploadedPaths)
            ->unique()
            ->values()
            ->implode(PHP_EOL);

        $request->merge([$fieldName => $mergedPaths]);
    }

    private function mediaPathsFrom(mixed $value)
    {
        return collect(preg_split('/[\r\n,]+/', (string) $value) ?: [])
            ->map(fn ($path) => $this->normalizeMediaPath((string) $path))
            ->filter()
            ->unique()
            ->values();
    }

    private function normalizeMediaPath(string $path): ?string
    {
        $path = ltrim(trim(str_replace('\\', '/', $path)), '/');

        if ($path === '' || Str::contains($path, '..') || preg_match('/^[A-Za-z]:/', $path)) {
            return null;
        }

        return $path;
    }

    private function deletePublicMedia(string $path, array $field): void
    {
        if (! $this->isDeletableMediaPath($path, $field)) {
            return;
        }

        $publicRoot = realpath(public_path());
        $filePath = realpath(public_path($path));

        if (! $publicRoot || ! $filePath) {
            return;
        }

        $publicRoot = rtrim(str_replace('\\', '/', $publicRoot), '/').'/';
        $filePath = str_replace('\\', '/', $filePath);

        if (! Str::startsWith($filePath, $publicRoot) || ! File::isFile($filePath)) {
            return;
        }

        File::delete($filePath);
    }

    private function isDeletableMediaPath(string $path, array $field): bool
    {
        $directories = collect(Arr::wrap(Arr::get($field, 'delete_directories', Arr::get($field, 'upload_directory', []))))
            ->map(fn ($directory) => $this->normalizeMediaPath((string) $directory))
            ->filter()
            ->values();

        return $directories->contains(
            fn ($directory) => $path !== $directory && Str::startsWith($path, $directory.'/')
        );
    }
}
