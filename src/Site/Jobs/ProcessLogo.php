<?php

namespace QuadStudio\Service\Site\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Models\Image;

class ProcessLogo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * @var Image
     */
    protected $image;
    /**
     * @var string
     */
    protected $storage;

    /**
     * Create a new job instance.
     * @param Image $image
     * @param string $storage
     */
    public function __construct(Image $image, string $storage)
    {
        $this->image = $image;
        $this->storage = $storage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $img = \Intervention\Image\Facades\Image::make(Storage::disk($this->storage)->getAdapter()->getPathPrefix() . $this->image->path);
        $img->resize(
            config('site.logo.size.image.width', 200),
            config('site.logo.size.image.height', 200),
            function ($constraint) {
                $constraint->aspectRatio();
            });
        $img->resizeCanvas(
            config('site.logo.size.canvas.width', 200),
            config('site.logo.size.canvas.height', 200),
            'center',
            false,
            'rgba(255, 255, 255, 1)'
        );
        $img->save();
        $this->image->size = $img->filesize();
        $this->image->save();
    }
}
