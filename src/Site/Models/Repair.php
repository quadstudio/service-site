<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Contracts\Messagable;
use QuadStudio\Service\Site\Facades\Site;


class Repair extends Model implements Messagable
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'serial_id', 'product_id', 'contragent_id',
        'cost_difficulty', 'cost_distance',
        'distance_id', 'difficulty_id',
        'date_launch', 'date_trade', 'date_call',
        'date_repair',
        'engineer_id', 'trade_id', 'launch_id',
        'reason_call', 'diagnostics', 'works',
        'recommends', 'remarks', 'country_id',
        'client', 'phone_primary', 'phone_secondary',
        'address', 'status_id'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'repairs';
    }

//    public static function boot()
//    {
//        parent::boot();
//
//        self::updated(function (Repair $repair) {
//
//
//        });
//    }

    public function pdf(\Codedge\Fpdf\Fpdf\Fpdf $fpdf)
    {
        $font_size = 9;
        $font_size_small = 7;
        $line_height = 4;
        $fpdf->SetFillColor(255, 255, 255);
        $fpdf->SetDrawColor(0, 0, 0);
        $fpdf->AddFont('verdana', '',  'verdana.php');
        $fpdf->AddFont('verdana', 'B', 'verdanab.php');
        $fpdf->AddFont('verdana', 'I', 'verdanai.php');
        $fpdf->AddFont('verdana', 'U', 'verdanaz.php');
        $fpdf->SetMargins(10, 10, 10);
        $fpdf->AddPage();
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(0, $line_height,  w1251(trans('site::repair.pdf.annex')), 0, 1, 'C');
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(0, $line_height,  w1251(trans('site::repair.pdf.contract'). ' ' .$this->contragent->contract), 0, 1, 'C');
        $fpdf->ln(5);
        // Город
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(13, $line_height,  w1251(trans('site::repair.pdf.city')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(177, $line_height,  w1251($this->user->address()->locality), 0, 1, 'L');
        // Организация
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(53, $line_height,  w1251(trans('site::repair.pdf.organization')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(137, $line_height,  w1251($this->contragent->name), 0, 1, 'L');
        // Акт
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(0, 14, w1251(trans('site::repair.pdf.title')), 0, 1, 'C');
        // Клиент
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(43, $line_height,  w1251(trans('site::repair.pdf.client')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(147, $line_height,  w1251($this->client), 0, 1, 'L');
        // Адрес
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(14, $line_height,  w1251(trans('site::repair.pdf.address')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(176, $line_height,  w1251($this->address), 0, 1, 'L');
        // Телефон
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(38, $line_height,  w1251(trans('site::repair.pdf.phone')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(162, $line_height,  w1251($this->country->phone.$this->phone_primary), 0, 1, 'L');
        //
        $fpdf->ln(2);
        $fpdf->Line(10, $fpdf->GetY(), 200, $fpdf->GetY());
        $fpdf->ln(2);
        // Модель котла
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(28, $line_height,  w1251(trans('site::repair.pdf.model')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(162, $line_height,  w1251($this->product->brand->name. ' ' .$this->product->name), 0, 1, 'L');
        // Серийный номер
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(34, $line_height,  w1251(trans('site::repair.pdf.serial')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(166, $line_height,  w1251($this->serial_id), 0, 1, 'L');
        // Дата продажи
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(28, $line_height,  w1251(trans('site::repair.pdf.date_trade')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(164, $line_height,  \Carbon\Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_trade))->format('d.m.Y'), 0, 1, 'L');
        // Дата продажи
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(53, $line_height,  w1251(trans('site::repair.pdf.date_launch')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(137, $line_height,  \Carbon\Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_launch))->format('d.m.Y'), 0, 1, 'L');
        //
        $fpdf->ln(2);
        $fpdf->Line(10, $fpdf->GetY(), 200, $fpdf->GetY());
        $fpdf->ln(2);
        // Дата поступления заявки
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(40, $line_height,  w1251(trans('site::repair.pdf.date_call')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(150, $line_height,  \Carbon\Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_call))->format('d.m.Y'), 0, 1, 'L');
        // Дата выполенния работ
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(37, $line_height,  w1251(trans('site::repair.pdf.date_repair')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(153, $line_height,  \Carbon\Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_repair))->format('d.m.Y'), 0, 1, 'L');
        $fpdf->SetFont('Verdana', 'B', $font_size);
        // Неисправности
        $fpdf->Cell(0, $line_height,  w1251(trans('site::repair.pdf.diagnostics')), 0, 1, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $y = $fpdf->GetY();
        $fpdf->MultiCell(190, 4, w1251($this->diagnostics), 0, 'J');
        // Работы
        $fpdf->SetXY(10, $y + 16);
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(0, $line_height,  w1251(trans('site::repair.pdf.works')), 0, 1, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $y = $fpdf->GetY();
        $fpdf->MultiCell(190, 4, w1251($this->works), 0, 'J');
        // Исполнитель
        $fpdf->SetXY(10, $y + 16);
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(30, $line_height,  w1251(trans('site::repair.pdf.executor')), 0, 0, 'L');
        $fpdf->SetFont('Verdana', '', $font_size);
        $fpdf->Cell(100, $line_height,  w1251($this->engineer->name), 'B', 0, 'C');
        $fpdf->Cell(10, $line_height,  '/', 0, 0, 'C');
        $fpdf->Cell(50, $line_height,  '', 'B', 1, 'L');
        $fpdf->SetFont('Verdana', '', $font_size_small);
        $fpdf->Cell(30, $line_height,  '', 0, 0, 'L');
        $fpdf->Cell(100, $line_height,  w1251(trans('site::repair.pdf.fio')), 0, 0, 'C');
        $fpdf->Cell(10, $line_height,  '', 0, 0, 'C');
        $fpdf->Cell(50, $line_height,  w1251(trans('site::repair.pdf.sign')), 0, 1, 'C');
        //
        $fpdf->ln(5);
        $fpdf->SetFont('Verdana', 'I', $font_size_small);
        $fpdf->Cell(120, $line_height,  w1251(trans('site::repair.pdf.confirm')), 0, 0, 'L');
        $fpdf->Cell(70, $line_height,  '', 'B', 1, 'C');
        $fpdf->Cell(120, $line_height,  '', 0, 0, 'L');
        $fpdf->Cell(70, $line_height,  w1251(trans('site::repair.pdf.sign_client')), 0, 1, 'C');
        //
        $fpdf->ln(2);
        $fpdf->Line(10, $fpdf->GetY(), 200, $fpdf->GetY());
        //
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->ln(5);
        $y = $fpdf->GetY();
        $fpdf->SetX(20);
        $fpdf->MultiCell(170, 4,  w1251(trans('site::repair.pdf.cost')), 0, 'C');
        $fpdf->ln(5);
        //Детали
        $fpdf->SetFont('Verdana', '', $font_size_small);
        $fpdf->Cell(10, $line_height,  w1251('№'), 1, 0, 'C');
        $fpdf->Cell(100, $line_height,  w1251(trans('site::repair.pdf.table.part')), 1, 0, 'C');
        $fpdf->Cell(30, $line_height,  w1251(trans('site::repair.pdf.table.difficulty')), 1, 0, 'C');
        $fpdf->Cell(50, $line_height,  w1251(trans('site::repair.pdf.table.distance')), 1, 1, 'C');
        //
        $fpdf->Cell(10, $line_height,  w1251(trans('site::repair.pdf.table.pp')), 1, 0, 'C');
        $fpdf->Cell(70, $line_height,  w1251(trans('site::repair.pdf.table.sku')), 1, 0, 'C');
        $fpdf->Cell(30, $line_height,  w1251(trans('site::repair.pdf.table.cost')), 1, 0, 'C');
        $fpdf->Cell(30, $line_height,  w1251(trans('site::repair.pdf.table.cost')), 1, 0, 'C');
        $fpdf->Cell(20, $line_height,  w1251(trans('site::repair.pdf.table.category')), 1, 0, 'C');
        $fpdf->Cell(30, $line_height,  w1251(trans('site::repair.pdf.table.cost')), 1, 1, 'C');
        $y = $fpdf->getY();
        $key = 0;
        if(($parts = $this->parts)->count() > 0){
            foreach ($parts as $key => $part){
                $fpdf->Cell(10, $line_height,  $key + 1, 1, 0, 'C');
                $fpdf->Cell(70, $line_height,  w1251($part->product->sku), 1, 0, 'C');
                $fpdf->Cell(30, $line_height,  number_format($part->total, 2, '.', ' '), 1, 1, 'R');
            }
        } else{
            $fpdf->Cell(10, $line_height,  '', 1, 0, 'C');
            $fpdf->Cell(70, $line_height,  '-', 1, 0, 'C');
            $fpdf->Cell(30, $line_height,  '-', 1, 1, 'R');
        }

        $bottom = $fpdf->getY();
        $fpdf->setXY(120, $y);
        $fpdf->Cell(30, $line_height * ($key + 1),  number_format($this->cost_difficulty, 2, '.', ' '), 1, 0, 'R');
        $fpdf->Cell(20, $line_height * ($key + 1),  w1251($this->difficulty->name), 1, 0, 'C');
        $fpdf->Cell(30, $line_height * ($key + 1),  number_format($this->cost_distance, 2, '.', ' '), 1, 0, 'R');
        $fpdf->setXY(10, $bottom + 2);
        $fpdf->SetFont('Verdana', 'B', $font_size);
        $fpdf->Cell(140, $line_height,  w1251(trans('site::repair.pdf.table.total')), 0, 0, 'R');
        $fpdf->Cell(30, $line_height,  number_format($this->totalCost, 2, '.', ' '), 0, 0, 'R');
        $fpdf->Cell(20, $line_height,  w1251(trans('site::repair.pdf.table.rub')), 0, 1, 'R');
        $fpdf->ln(5);
        $fpdf->SetFont('Verdana', '', $font_size_small);
        $fpdf->Cell(60, $line_height, '', 'B', 1, 'C');
        $fpdf->Cell(60, $line_height,  w1251(trans('site::repair.pdf.sign')), 0, 1, 'C');
        $fpdf->ln(5);
        $fpdf->Cell(60, $line_height,  w1251(trans('site::repair.pdf.mp')), 0, 1, 'C');
        //
        return response($fpdf->Output(), 200)->header('Content-Type', 'application/pdf');
    }

    public function setStatus($status_id)
    {

        if ($status_id == 5 && $this->getOriginal('status_id') != 5) {

            $this->parts->each(/**
             * @param Part $part
             * @param int $key
             */
                function ($part) {
                    $part->update(['cost' => Site::round($part->cost())]);
                });
            $this->update([
                'status_id'       => $status_id,
                'cost_difficulty' => $this->getAttribute('difficultyCost'),
                'cost_distance'   => $this->getAttribute('distanceCost'),

            ]);
        } else {
            $this->update(['status_id' => $status_id]);
        }
    }

    /**
     * Узнать, можно ли сменить статус отчета по ремонту
     *
     * @param $status_id
     * @return bool
     */
    public function canSetStatus($status_id)
    {
        switch ($status_id) {
            case 5:
                return $this->parts()->count() == 0 || $this->parts->every(function ($part) {
                        return $part->hasPrice();
                    });
            default:
                return true;
        }
    }

    /**
     * Запчасти
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function check()
    {
        return $this->checkParts() && $this->checkContragent();
    }

    public function checkParts()
    {
        return $this->getAttribute('allow_parts') == 0
            || $this->parts->every(function ($part) {
                return $part->hasPrice();
            });
    }

    public function checkContragent()
    {
        return $this->contragent->check();
    }

    /**
     * Файлы
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function detachFiles()
    {
        foreach ($this->files as $file) {
            $file->fileable_id = null;
            $file->fileable_type = null;
            $file->save();
        }
    }


    public function getTotalCostAttribute()
    {
        return $this->cost_difficulty() + $this->cost_distance() + $this->cost_parts();
    }

    /**
     * Стоимость работ
     *
     * @return float
     */
    public function cost_difficulty()
    {
        switch ($this->getAttribute('status_id')) {
            case 5:
            case 6:
                return $this->getAttribute('cost_difficulty');
            default:
                return $this->getAttribute('difficultyCost');
        }
    }

    /**
     * Стоимость дороги
     *
     * @return float
     */
    public function cost_distance()
    {
        switch ($this->getAttribute('status_id')) {
            case 5:
            case 6:
                return $this->getAttribute('cost_distance');
                break;
            default:
                return $this->getAttribute('distanceCost');
        }
    }

    /**
     * Стоимлсть запчастей
     *
     * @return float
     */
    public function cost_parts()
    {
        return $this->parts()->count() == 0 ? 0 : $this->parts->sum('total');
    }

    public function getTotalDifficultyCostAttribute()
    {
        return $this->cost_difficulty();
    }

    public function getTotalDistanceCostAttribute()
    {
        return $this->cost_distance();
    }

    public function getTotalCostPartsAttribute()
    {
        return $this->cost_parts();
    }

    public function getDifficultyCostAttribute()
    {
        return $this->difficulty->cost * Site::currencyRates($this->difficulty->currency, $this->user->currency);
    }

    public function getDistanceCostAttribute()
    {
        return $this->distance->cost * Site::currencyRates($this->distance->currency, $this->user->currency);
    }

    public function created_at($time = false)
    {
        return !is_null($this->created_at) ? Carbon::instance($this->created_at)->format('d.m.Y' . ($time === true ? ' H:i' : '')) : '';
    }

    public function date_launch()
    {
        return !is_null($this->date_launch) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_launch))->format('d.m.Y') : '';
    }

    public function date_trade()
    {
        return !is_null($this->date_trade) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_trade))->format('d.m.Y') : '';
    }

    public function date_call()
    {
        return !is_null($this->date_call) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_call))->format('d.m.Y') : '';
    }

    public function date_repair()
    {
        return !is_null($this->date_repair) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_repair))->format('d.m.Y') : '';
    }

    public function statuses()
    {
        return RepairStatus::whereIn('id', config('site.repair_status_transition.' . (Auth::user()->admin == 1 ? 'admin' : 'user') . '.' . $this->getAttribute('status_id'), []));
    }

    /**
     * Сообщения
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messagable');
    }

    /**
     * Ошибки
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fails()
    {
        return $this->hasMany(RepairFail::class);
    }


    /**
     * Статус отчета по ремонту
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(RepairStatus::class);
    }

    /**
     * Акт выполненных работ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function act()
    {
        return $this->belongsTo(Act::class);
    }

    /**
     * Контрагент - исполнитель
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contragent()
    {
        return $this->belongsTo(Contragent::class);
    }

    /**
     * Страна
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Торговая организация
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }

    /**
     * Сервисный инженер
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }

    /**
     * Ввод в эксплуатацию
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function launch()
    {
        return $this->belongsTo(Launch::class);
    }

    /**
     * Тариф на транспорт
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function distance()
    {
        return $this->belongsTo(Distance::class);
    }

    /**
     * Класс сложности
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }

    /**
     * Оборудование
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    function name()
    {
        return trans('site::repair.repair') . ' ' . $this->getAttribute('number');
    }

    function route()
    {
        //return '';
        return route((Auth::user()->admin == 1 ? 'admin.' : '') . 'repairs.show', [$this, '#messages-list']);
    }
}
