<?php

namespace QuadStudio\Service\Site\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use QuadStudio\Service\Site\Models\CatalogImage;

class ProcessCatalogImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;
    protected $image;

    /**
     * Create a new job instance.
     * @param CatalogImage $image
     */
    public function __construct(CatalogImage $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $img = Image::make(Storage::disk('equipment')->getAdapter()->getPathPrefix() . $this->image->path);
        $img->resize(
            config('equipment.files.image.width', null),
            config('equipment.files.image.height', 500),
            function ($constraint) {
                $constraint->aspectRatio();
            });
        $img->resizeCanvas(
            config('equipment.files.canvas.width', 500),
            config('equipment.files.canvas.height', 500),
            'center',
            false,
            'rgba(255, 255, 255, 1)'
        );
        $img->save();
        $this->image->size = $img->filesize();
        $this->image->save();
    }
}
