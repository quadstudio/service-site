<?php

namespace QuadStudio\Service\Site\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use QuadStudio\Service\Site\Models\File;

class ProcessFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;
    protected $file;

    /**
     * Create a new job instance.
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            Image::make(Storage::disk($this->file->storage)->getAdapter()->getPathPrefix() . $this->file->path)
                ->resize(config('site.files.image.width', 1024), null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save();
        } catch (\Exception $e) {

        }

    }
}
