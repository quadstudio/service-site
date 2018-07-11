<?php

namespace QuadStudio\Service\Site\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProcessFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
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
        Image::make(Storage::disk('files')->getAdapter()->getPathPrefix() . $this->file->path)
            ->resize(config('site.files.image.width', 1024), null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save();
    }
}
