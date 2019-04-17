<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\BlockRequest;
use QuadStudio\Service\Site\Models\Block;
use QuadStudio\Service\Site\Repositories\BlockRepository;

class BlockController extends Controller
{

    protected $blocks;

    /**
     * Create a new controller instance.
     *
     * @param BlockRepository $blocks
     */
    public function __construct(BlockRepository $blocks)
    {
        $this->blocks = $blocks;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->blocks->trackFilter();

        return view('site::admin.block.index', [
            'repository' => $this->blocks,
            'blocks'  => $this->blocks->paginate(config('site.per_page.block', 10), ['blocks.*'])
        ]);
    }

    public function create()
    {
        return view('site::admin.block.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BlockRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockRequest $request)
    {

        //dd($request->all());
        $block = $this->blocks->create($request->except(['_token', '_method', '_create']));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.blocks.create')->with('success', trans('site::block.created'));
        } else {
            $redirect = redirect()->route('admin.blocks.index')->with('success', trans('site::block.created'));
        }

        return $redirect;
    }


    /**
     * @param Block $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        return view('site::admin.block.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlockRequest $request
     * @param  Block $block
     * @return \Illuminate\Http\Response
     */
    public function update(BlockRequest $request, Block $block)
    {

        $block->update($request->except(['_method', '_token', '_stay']));

        if ($request->input('_stay') == 1) {

            $redirect = redirect()->route('admin.blocks.edit', $block)->with('success', trans('site::block.updated'));
        } else {
            $redirect = redirect()->route('admin.blocks.index')->with('success', trans('site::block.updated'));
        }

        return $redirect;
    }

    public function sort(Request $request)
    {
        $sort = array_flip($request->input('sort'));

        foreach ($sort as $block_id => $sort_order) {
            /** @var Block $block */
            $block = Block::find($block_id);
            $block->setAttribute('sort_order', $sort_order);
            $block->save();
        }
    }


}