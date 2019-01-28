<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;


use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Filters\News\PublishedSelectFilter;
use QuadStudio\Service\Site\Filters\News\SearchFilter;
use QuadStudio\Service\Site\Filters\News\SortCreatedAtFilter;
use QuadStudio\Service\Site\Filters\Repair\DateNewsFromFilter;
use QuadStudio\Service\Site\Filters\Repair\DateNewsToFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\NewsRequest;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Models\Image;
use QuadStudio\Service\Site\Models\Item;
use QuadStudio\Service\Site\Repositories\NewsRepository;

trait NewsControllerTrait
{
    /**
     * @var NewsRepository
     */
    protected $news;

    /**
     * Create a new controller instance.
     *
     * @param NewsRepository $news
     */
    public function __construct(NewsRepository $news)
    {
        $this->news = $news;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->news->trackFilter();
        $this->news->applyFilter(new SortCreatedAtFilter());
        $this->news->pushTrackFilter(DateNewsFromFilter::class);
        $this->news->pushTrackFilter(DateNewsToFilter::class);
        $this->news->pushTrackFilter(PublishedSelectFilter::class);
        $this->news->pushTrackFilter(SearchFilter::class);

        return view('site::admin.news.index', [
            'repository' => $this->news,
            'news'       => $this->news->paginate(config('site.per_page.news', 15), ['news.*'])
        ]);
    }

    /**
     * @param $item_id
     * @return \Illuminate\Http\Response
     */
    public function show($item_id)
    {
        $item = Item::query()->find($item_id);

        return view('site::admin.news.show', compact('item'));
    }

    public function create()
    {
        return view('site::admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NewsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {

        $scheme = $this->news->create($request->except(['_token', '_method', '_create']));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.news.create')->with('success', trans('site::news.created'));
        } else {
            $redirect = redirect()->route('admin.news.show', $scheme)->with('success', trans('site::news.created'));
        }

        return $redirect;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $item_id
     * @return \Illuminate\Http\Response
     */
    public function edit($item_id)
    {

        $item = Item::query()->find($item_id);

        return view('site::admin.news.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NewsRequest $request
     * @param  int $item_id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $item_id)
    {
        $item = Item::query()->find($item_id);

        $item->update($request->except(['_token', '_method', '_stay', 'image']));
        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.news.edit', $item)->with('success', trans('site::news.updated'));
        } else {
            $redirect = redirect()->route('admin.news.show', $item)->with('success', trans('site::news.updated'));
        }


        return $redirect;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function image(ImageRequest $request)
    {

        $this->authorize('create', Image::class);
        $file = $request->file('path');

        $image = new Image([
            'path'    => Storage::disk($request->input('storage'))->putFile('', new File($file->getPathName())),
            'mime'    => $file->getMimeType(),
            'storage' => $request->input('storage'),
            'size'    => $file->getSize(),
            'name'    => $file->getClientOriginalName(),
        ]);

        $image->save();

        return response()->json([
            'update' => [
                '#image-src' => view('site::admin.image.field', ['image' => $image])->render()
            ]
        ]);
    }

}