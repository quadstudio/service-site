<?php

namespace QuadStudio\Service\Site\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as IntImage;
use QuadStudio\Service\Site\Models\Image;

class ProcessImage implements ShouldQueue
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
    //protected $storage;

    /**
     * Create a new job instance.
     * @param Image $image
     */
    public function __construct(Image $image) //, string $storage
    {
        $this->image = $image;
        //$this->storage = $storage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $storage = $this->image->getAttribute('storage');
        
        if (config("site.{$storage}.process") === true) {
            /** @var \Intervention\Image\Image $img */
            $img = IntImage::make(
                Storage::disk($this->image->getAttribute('storage'))
                    ->getAdapter()->getPathPrefix() . $this->image->getAttribute('path'));
            $img->resize(
                config("site.{$storage}.image.width", 500),
                config("site.{$storage}.image.height", 500),
                function ($constraint) {
                    $constraint->aspectRatio();
                });
            $img->resizeCanvas(
                config("site.{$storage}.canvas.width", 500),
                config("site.{$storage}.canvas.height", 500),
                'center',
                false,
                'rgba(255, 255, 255, 1)'
            );
            $img->save();
            $this->image->size = $img->filesize();
            $this->image->save();
        }
    }
}
