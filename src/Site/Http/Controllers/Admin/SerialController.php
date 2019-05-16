<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\BaseReader;
use QuadStudio\Service\Site\Filters\Serial\SerialPerPageFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\SerialRequest;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Models\Serial;
use QuadStudio\Service\Site\Repositories\SerialRepository;
use QuadStudio\Service\Site\Support\SerialLoadFilter;

class SerialController extends Controller
{

    protected $serials;

    /**
     * Create a new controller instance.
     *
     * @param SerialRepository $serials
     */
    public function __construct(SerialRepository $serials)
    {
        $this->serials = $serials;
    }

    /**
     * Show the user profile
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->serials->trackFilter();
        $this->serials->pushTrackFilter(SerialPerPageFilter::class);

        return view('site::admin.serial.index', [
            'repository' => $this->serials,
            'serials'    => $this->serials->paginate($request->input('filter.per_page', config('site.per_page.serial', 10)), ['serials.*'])
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site::admin.serial.create');
    }

    /**
     * @param SerialRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SerialRequest $request)
    {

        $inputFileType = ucfirst($request->path->getClientOriginalExtension());
        $filterSubset = new SerialLoadFilter();
        /** @var BaseReader $reader */
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setReadFilter($filterSubset);

        $spreadsheet = $reader->load($request->path->getPathname());

        $rowIterator = $spreadsheet->getActiveSheet()->getRowIterator();

        $data = [];

        foreach ($rowIterator as $r => $row) {


            $cellIterator = $row->getCellIterator();

            $id = $product_id = $comment = false;

            foreach ($cellIterator as $c => $cell) {


                switch ($c) {
                    case 'A':
                        $id = (string)trim($cell->getValue());
                        break;
                    case 'B':
                        $sku = (string)trim($cell->getValue());

                        $product = Product::query()->where('sku', $sku);
                        if($product->exists()){
                            $product_id = $product->first()->getAttribute('id');
                        }

                        break;
                    case 'C':

                        $comment = (string)$cell->getValue();

                        break;
                }
            }
            if ($id !== false && $product_id !== false && $comment !== false) {
                DB::table('serials')
                    ->updateOrInsert(
                        ['id' => $id],
                        ['product_id' => $product_id, 'comment' => $comment]
                    );
            }
        }

        return redirect()->route('admin.serials.create')->with('success', trans('site::serial.loaded'));
    }

    public function show(Serial $serial)
    {
        return view('site::admin.serial.show', compact('serial'));
    }
}