<?php

namespace App\Http\Controllers\Admin\Utilitas;

use App\Http\Controllers\Controller;
use App\Models\LogWhatsappsModel;
use App\Models\MstKelasModel;
use App\Models\MstThnAkaModel;
use App\Models\ScctBillModel;
use App\Models\UAkunModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class LogWhatsappController extends Controller
{
    public $mainTitle;

    public function __construct()
    {
        $this->title = 'Keuangan';
        $this->mainTitle = 'Log Whatsapp';
        $this->dataTitle = 'Log Whastapp';
        $this->showTitle = 'Detail Log Whastapp';
    }

    public function getColumn()
    {
        return [
            ['data' => 'no', 'name' => 'no'],
            ['data' => 'nama_admin', 'name' => 'pengirim', 'searchable' => true, 'orderable' => true],
            ['data' => 'nama', 'name' => 'NAMA', 'searchable' => true, 'orderable' => true],
            ['data' => 'no_wa', 'name' => 'Nomor WhatsApp', 'searchable' => true, 'orderable' => true],
            ['data' => 'status', 'name' => 'Status', 'orderable' => true, 'columnType' => 'custom_status_whatsapp', 'exportable' => true, "className" => "text-center fixed-column-3"],
            ['data' => 'created_at', 'name' => 'Tanggal', 'columnType' => 'timeStamp', 'searchable' => false, 'orderable' => false],
            ['data' => 'pesan', 'name' => 'Pesan', 'searchable' => true, 'orderable' => true],
        ];
    }

    public function getData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');

        $defaultColumn = 'log_whatsapps.id';
        $defaultOrder = 'desc';

        if ($request->has('order')) {
            $columnIndex_arr = $request->get('order');
            $columnIndex = $columnIndex_arr[0]['column'];
            $columnSortOrder = $columnIndex_arr[0]['dir'];
        } else {
            $columnIndex = $defaultColumn;
            $columnSortOrder = $defaultOrder;
        }

        $columnName = $columnName_arr[$columnIndex]['data'];
        $searchValue = $search_arr['value'];

        if (!$columnName || $columnName == 'no') {
            $columnName = $defaultColumn;
            $columnSortOrder = $defaultOrder;
        }

        $filters = [];
        $filterQuery = null;

        $filter = $request->input('filter');

        if ($request->status_tagihan == 1) {
            $filters[] = ['status', '=', '200'];
        } elseif ($request->status_tagihan == 0) {
            $filters[] = [];
        } else {
            $filters[] = ['status', '!=', '200'];
        }

        if ($request->dari_tanggal && $request->sampai_tanggal) {
            $dateEnd =  Carbon::parse($request->sampai_tanggal)->addHours(23, 59, 59);
            $filters[] = ['log_whatsapps.created_at', '>=', $request->dari_tanggal];
            $filters[] = ['log_whatsapps.created_at', '<=', $dateEnd];
        }

        if (!empty($filters)) {
            $filterQuery = function ($query) use ($filters) {
                foreach ($filters as $filter) {
                    if (count($filter) === 3) {
                        $query->where($filter[0], $filter[1], $filter[2]);
                    } elseif (count($filter) === 4) {
                        $query->{$filter[3]}($filter[0], $filter[1], $filter[2]);
                    }
                }
            };
        }

        $totalRecords = LogWhatsappsModel::leftJoin('users', 'users.id', 'log_whatsapps.user_id')->select('count(*) as allcount')->count();

        $totalRecordswithFilter = LogWhatsappsModel::join('users', 'users.id', 'log_whatsapps.user_id')
            ->select('count(*) as allcount')
            ->whereAny([
                'log_whatsapps.nama',
                'log_whatsapps.no_wa',
                'log_whatsapps.pesan',
                'users.name',
            ], 'like', '%' . $searchValue . '%')
            ->where(function ($query) use ($filterQuery) {
                if ($filterQuery) {
                    $filterQuery($query);
                }
            })
            ->count();
        $records = LogWhatsappsModel::leftJoin('users', 'users.id', 'log_whatsapps.user_id')
            ->orderBy($columnName, $columnSortOrder)
            ->select([
                'log_whatsapps.nama',
                'log_whatsapps.no_wa',
                'log_whatsapps.id',
                'log_whatsapps.pesan',
                'log_whatsapps.status',
                'log_whatsapps.created_at',
                'users.name as nama_admin',
            ])
            ->whereAny([
                'log_whatsapps.nama',
                'log_whatsapps.no_wa',
                'log_whatsapps.pesan',
                'users.name',
            ], 'like', '%' . $searchValue . '%')
            ->where(function ($query) use ($filterQuery) {
                if ($filterQuery) {
                    $filterQuery($query);
                }
            })
            ->skip($start)
            ->take($rowperpage)
            ->get()
            ->map(function ($item, $index) {
                $item->no = $index + 1;
                $item->item_id = Crypt::encrypt($item->id);
                unset($item->id);
                return $item;
            })->toArray();


        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $records,
        );
        return response()->json($response);
    }

    public function index()
    {
        $post = UAkunModel::all();
        $thn_aka = MstThnAkaModel::where('thn_aka', '!=', null)->orderBy('thn_aka', 'desc')->get();
        // $kelas = MstKelasModel::get();

        $kelas = MstKelasModel::select('jenjang', 'unit')
            ->distinct()
            ->orderBy('unit')
            ->get();

        $data['post'] = $post;
        $data['thn_aka'] = $thn_aka;
        $data['kelas'] = $kelas;
        $data['title'] = $this->title;
        $data['mainTitle'] = $this->mainTitle;
        $data['dataTitle'] = $this->dataTitle;
        $data['showTitle'] = $this->showTitle;
        $data['columnsUrl'] = route('admin.log-whatsapp.get-column');
        $data['datasUrl'] = route('admin.log-whatsapp.get-data');
        // $data['modalLink'] = view('admin.utilitas.notifikasi_whatsapp_tagihan.modal', compact('post'));

        $this->syncMessage();
        return view('admin.utilitas.log.index', $data);
    }

    public function syncMessage()
    {
        $data = LogWhatsappsModel::select(['id', 'log_id'])
            ->whereNotIn('status', ['200', '2'])
            ->get();

        $nasabah = 'Riau_Ponpes_Al_Utsaimin';

        if ($data) {
            $ForUpdate = $data->pluck('log_id')
                ->implode(',');

            $targets = DB::connection('mysql_wa')
                ->select('CALL get_whatsapp_queue_by_client_with_queue_id(:param1, :param2, :param3)', [
                    'param1' => $nasabah,
                    'param2' => $ForUpdate,
                    'param3' => null,
                ]);

            $targets = collect($targets);
            foreach ($targets as $target) {
                LogWhatsappsModel::where('log_id', $target->id)->update(['status' => $target->status]);
            }
        }
    }
}
