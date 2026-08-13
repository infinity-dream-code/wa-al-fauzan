<?php

namespace App\Http\Controllers\Admin\Utilitas;

use App\Helpers\PhoneNumberHelper;
use App\Http\Controllers\Controller;
use App\Models\LogModel;
use App\Models\LogWhatsappsModel;
use App\Models\master_data\mst_kelas;
use App\Models\master_data\mst_siswa;
use App\Models\master_data\mst_thn_aka;
use App\Models\MstKelasModel;
use App\Models\MstThnAkaModel;
use App\Models\ScctcustModel;
use App\Models\UAkunModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifikasiWhatsappController extends Controller
{
    public function __construct()
    {
        $this->title = "Utilitas";
        $this->mainTitle = "Notifikasi WhatsApp";
        $this->dataTitle = "Notifikasi WhatsApp";
        $this->showTitle = "Detail Notifikasi WhatsApp";
        $this->detailDatasUrl = "";
    }

    public function index()
    {
        $post = UAkunModel::all();
        $thn_aka = MstThnAkaModel::where("thn_aka", "!=", null)
            ->orderBy("thn_aka", "desc")
            ->get();
        // $kelas = MstKelasModel::get();

        $kelas = MstKelasModel::select("jenjang", "unit")
            ->distinct()
            ->orderBy("unit")
            ->get();

        $data["title"] = $this->title;
        $data["mainTitle"] = $this->mainTitle;
        $data["dataTitle"] = $this->dataTitle;
        $data["showTitle"] = $this->showTitle;
        $data["thn_aka"] = $thn_aka;
        $data["kelas"] = $kelas;
        //    $data['columnsUrl'] = $this->columnsUrl;
        //    $data['datasUrl'] = $this->datasUrl;

        return view("admin.utilitas.notifikasi_whatsapp.index", $data);
    }

    public function getSiswa(Request $request)
    {
        $kelas = null;
        $unit = null;
        $jenjang = null;
        if (isset($request->unit)) {
            $waduh = explode("-", $request->unit);
            $jenjang = $waduh[0];
            $unit = $waduh[1];
            $kelas = $request->kelas;
        }

        // dd($kelas, $unit, $jenjang);
        $thn_aka =
            $request->angkatan != "all" ? $request->angkatan ?? null : null;

        $nis = null;
        $nama = null;
        if (isset($request->cari_siswa) && $request->cari_siswa) {
            is_numeric($request->cari_siswa)
                ? ($nis = "%" . $request->cari_siswa . "%")
                : ($nama = "%" . $request->cari_siswa . "%");
        }
        if ($request->per === "siswa") {
            $kelas = null;
            $thn_aka = null;
        } elseif ($request->per === "kelas") {
            $nis = null;
            $nama = null;
        }

        $whereAny = [
            "scctcust.NUM2ND",
            "scctcust.NOCUST",
            "scctcust.NMCUST",
            "scctcust.CODE04",
            "scctcust.CODE03",
            "scctcust.CODE02",
            "scctcust.CODE05",
            "scctcust.CODE01",
            "scctcust.DESC01",
            "scctcust.DESC02",
            "scctcust.DESC03",
            "scctcust.DESC04",
            "scctcust.DESC05",
        ];

        $select = array_merge($whereAny, [
            "scctcust.CUSTID as id",
            "scctcust.NMCUST as nama",
            "scctcust.CODE02 as unit",
            "scctcust.DESC02 as kelas",
            "scctcust.DESC03 as kelompok",
            "scctcust.DESC04 as thn_aka",
            "scctcust.NO_WA as nowa",
            "scctcust.NOCUST as nis",
        ]);

        $siswa = ScctcustModel::whereNotNull("CUSTID")
            ->when($kelas, function ($query, $kelas) {
                return $query->where("DESC03", "like", $kelas);
            })
            ->when($jenjang, function ($query, $jenjang) {
                return $query->where("DESC02", "like", $jenjang);
            })
            ->when($unit, function ($query, $unit) {
                return $query->where("CODE02", "like", $unit);
            })
            ->when($thn_aka, function ($query, $thn_aka) {
                return $query->where("DESC04", "like", $thn_aka);
            })
            ->when($nis, function ($query, $nis) {
                return $query->where("NOCUST", "like", $nis);
            })
            ->when($nama, function ($query, $nama) {
                return $query->where("NMCUST", "like", $nama);
            })
            ->select($select)
            ->get()
            ->map(function ($item, $index) {
                $item->kelas = $item->kelas . " " . $item->kelompok;
                $item->angkatan = $item->thn_aka;
                return $item;
            })
            ->toArray();

        $response = [
            "data" => $siswa,
        ];

        return response()->json($response);
    }

    public function sendWa(Request $request)
    {
        $waduh = explode("-", $request->unit);
        $jenjang = $waduh[0];
        $unit = $waduh[1];
        $kelas = $request->kelas;

        set_time_limit(500);
        $per = $request->input("per");
        $pesan = $request->input("pesan")
            ? strip_tags($request->input("pesan"))
            : "";
        $url = "https://api.watzap.id/v1/send_message";
        switch ($per) {
            case "id_thn_aka":
                $siswas = ScctcustModel::select(
                    "CUSTID",
                    "NMCUST",
                    "NOCUST",
                    "NO_WA",
                )
                    ->where("DESC04", $request->id_thn_aka)
                    ->get();
                if ($siswas->isEmpty()) {
                    return response()->json(
                        ["message" => "Tidak ada siswa di angkatan ini"],
                        422,
                    );
                }
                break;
            case "kelas":
                $siswas = ScctcustModel::where("DESC03", $kelas)
                    ->where("DESC02", $jenjang)
                    ->where("CODE02", $unit)
                    ->whereIn("NOCUST", $request->input("siswa"))
                    ->select("CUSTID", "NMCUST", "NOCUST", "NO_WA")
                    ->get();
                if ($siswas->isEmpty()) {
                    return response()->json(
                        ["message" => "Tidak ada siswa di kelas ini"],
                        422,
                    );
                }
                break;
            case "siswa":
                if (!$request->input("siswa")) {
                    return response()->json(
                        ["message" => "Siswa tidak ditemukan"],
                        422,
                    );
                }
                $siswas = ScctcustModel::select(
                    "CUSTID",
                    "NMCUST",
                    "NOCUST",
                    "NO_WA",
                )
                    ->whereIn("NOCUST", $request->input("siswa"))
                    ->get();
                if ($siswas->isEmpty()) {
                    return response()->json(
                        ["message" => "Siswa tidak ditemukan"],
                        422,
                    );
                }
                if (count($request->input("siswa")) != $siswas->count()) {
                    return response()->json(
                        [
                            "message" =>
                                "Jumlah siswa yang dipilih tidak sesuai dengan jumlah data, silahkan muat ulang halaman!",
                        ],
                        422,
                    );
                }
                break;
            default:
                return response()->json(
                    [
                        "message" =>
                            "Data tidak valid, silahkan muat ulang halaman",
                    ],
                    422,
                );
        }

        if ($siswas->count() >= 100) {
            return response()->json(
                [
                    "message" =>
                        "jumlah siswa yang dipilih tidak boleh lebih dari 100",
                ],
                422,
            );
        }

        // $payload = [
        //     'api_key' => 'AQAKMFACHE5T2CDI',
        //     'number_key' => 'k6Hp1h9TSlRuo97c',
        // ];
        // $payload = [
        //     'username' => config('database.connections.mysql.username'),
        //     'password' => config('database.connections.mysql.password'),
        //     'dbname' => config('database.connections.mysql.database'),
        //     'method' => 'SEND_SISWA',
        // ];

//         dd($siswas);
        $log = new LogModel();
        $log->user_id = auth()->check() ? auth()->user()->id : null;
        $log->menu = "Whatsapp notif";
        $log->aksi = "Kirim Whatsapp notif";
        $log->client_info = $request->server("HTTP_USER_AGENT");
        $log->target_id = "Kirim Whatsapp notif";
        $log->ip_address = $request->ip();
        $log->status = "kirim whatsapp";
        $log->save();

        $nasabah = "sulaiman_al_fauzan";
        foreach ($siswas as $siswa) {
            try {
                if ($siswa['NO_WA'] != null) {
                    $NoHP = PhoneNumberHelper::format($siswa['NO_WA']);
                    try {
                        $fixPesan = str_replace("'", "", $pesan);

                        $payload["phone_no"] = $NoHP;
                        $payload["message"] = $fixPesan;

                        $newLog = LogWhatsappsModel::create([
                            "custid" => $siswa->CUSTID,
                            "log_id" => $log->id,
                            "user_id" => Auth::id(),
                            "status" => 0,
                            "no_wa" => $NoHP,
                            "pesan" => $formPesan,
                            "nama" => $siswa->NMCUST,
                            "response" => '',
                        ]);

                        Log::channel('whatsapp')->info('queue manual: enqueue', [
                            'client' => $nasabah,
                            'log_whatsapp_id' => $newLog->id,
                            'phone' => $payload['phone_no'],
                        ]);

                        $sendData = DB::connection('mysql_wa')
                            ->select('CALL new_whatsapp_queue(:param1, :param2, :param3, :param4)', [
                                'param1' => $nasabah,
                                'param2' => $newLog->id,
                                'param3' =>  $payload['phone_no'],
                                'param4' => $payload['message']
                            ]);

                        Log::channel('whatsapp')->info('queue manual: result', [
                            'client' => $nasabah,
                            'log_whatsapp_id' => $newLog->id,
                            'result' => $sendData,
                        ]);

                    } catch (Exception $e) {
                        throw $e;
                    }
                }
            } catch (\Throwable $e) {
                return response()->json(
                    ["error" => true, "message" => $e->getMessage()],
                    500,
                );
            }
        }

        return response()->json([
            "message" => "Pesan Whatsapp dalam proses pengiriman!",
        ]);
    }
}
