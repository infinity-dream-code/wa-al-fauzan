<?php

namespace App\Http\Controllers\Admin\Utilitas;

use App\Helpers\PhoneNumberHelper;
use App\Http\Controllers\Controller;
use App\Models\LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\LogWhatsappsModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotifikasiWhatsappGajiController extends Controller
{
    public function index()
    {
        return view("admin.utilitas.notifikasi_whatsapp_gaji.index");
    }

    public function uploadGajiTsanawiyah(Request $request)
    {
        $request->validate([
            "file" => "required|mimes:xlsx,xls",
        ]);

        $data = Excel::toArray([], $request->file("file"));

        foreach ($data[0] as $i => $row) {
            if ($i === 0) {
                continue;
            }

            $nama = $row[1];
            $nomor = $row[2];
            Carbon::setLocale("id");
            $formatTanggal = Carbon::now()->translatedFormat("d F Y");

            $pesan = <<<EOD
            GAJI GURU TSANAWIYAH
            BATAM HIDAYATULLAH

            No: {$row[0]}
            Nama: {$nama}

            1. Gaji Pokok
            a. Jumlah jam mengajar Reg      : Rp {$row[3]}
            b. Jumlah jam mengajar Mult     : Rp {$row[4]}
            c. Hadir Piket                  : Rp {$row[5]}
            d. Wali kelas                   : Rp {$row[6]}
            e. DPLK                         : Rp {$row[7]}
            f. Fungsional                   : Rp {$row[8]}

            2. Kehadiran
            {$row[9]} x Rp 12.500 = Rp {$row[10]}

            3. Potongan
            a. Dana Sosial Reg          : Rp {$row[11]}
            b. Dana Sosial Multi        : Rp {$row[12]}
            c. Arisan A                 : Rp {$row[13]}
            d. Arisan B                 : Rp {$row[14]}
            e. SP/SW                    : Rp {$row[15]}
            f. Simpan Pinjam            : Rp {$row[16]}
            g. DPLK                     : Rp {$row[17]}
            h. Voucher                  : Rp {$row[18]}
            i. Koperasi                 : Rp {$row[19]}
            j. BRI                      : Rp {$row[20]}
            k. BPJS                     : Rp {$row[21]}
            l. b jogja                  : Rp {$row[22]}
            m. dsm                      : Rp {$row[23]}
                                        ----------------+
               Jumlah                   : Rp {$row[24]}
            Jumlah Bersih               : Rp {$row[25]}

                    Batam, {$formatTanggal}
            Semoga menjadi rezeqi yang barokah, Aamiin.
            EOD;

            $this->kirimPesan($request, $nomor, $pesan, $row[0], $nama);
        }

        return back()->with("success", "Pesan berhasil dikirim");
    }

    public function uploadGajiTetap(Request $request)
    {
        $request->validate([
            "file" => "required|mimes:xlsx,xls",
        ]);

        $data = Excel::toArray([], $request->file("file"));

        foreach ($data[0] as $i => $row) {
            if ($i === 0) {
                continue;
            }

            $nama = $row[1];
            $nomor = $row[2];
            Carbon::setLocale("id");
            $formatTanggal = Carbon::now()->translatedFormat("d F Y");
            $pesan = <<<EOD
            GAJI GURU TETAP PERSYARIKATAN
            BATAM HIDAYATULLAH

            No: {$row[0]}
            Nama: {$nama}

            1. Gaji Pokok : Rp {$row[3]}
            2. Tambahan : Rp {$row[4]}
            3. jabatan/Piket : Rp {$row[5]}
            a. Suami/istri : Rp {$row[6]}
            b. Anak : Rp {$row[7]}
            c. Beras : Rp {$row[8]}
            d. Jabatan : Rp {$row[9]}
            e. Dapen : Rp {$row[10]}
            f. Fungsional : Rp {$row[11]}
            g. Pembulatan : Rp {$row[12]}
                     -----------------+
               Jumlah : Rp {$row[13]}

            4. Kehadiran       {$row[14]}x : Rp {$row[15]}
                  Tambh. Hadir {$row[16]}x : Rp {$row[17]}
                     -----------------+
               Jumlah : Rp {$row[18]}

            5. Potongan
            a. Dana Sosial : Rp {$row[19]}
            b. Dapen : Rp {$row[20]}
            c. Arisan A  : Rp {$row[21]}
            d. Arisan B : Rp {$row[22]}
            e. SP/SW : Rp {$row[23]}
            f. Simpin : Rp {$row[24]}
            g. DPLK : Rp {$row[25]}
            h. Voucher : Rp {$row[26]}
            i. Beras : Rp {$row[27]}
            j. BRI : Rp {$row[28]}
            k. BPJS : Rp {$row[29]}
            l. Beras : Rp {$row[30]}
            m. lain2 : Rp {$row[31]}
            n. Pembulatan : Rp {$row[32]}
                -----------------+
                Jumlah     : Rp {$row[33]}
            Jumlah Bersih  : Rp {$row[34]}

                    Batam, {$formatTanggal}
            Semoga menjadi rezeqi yang barokah, Aamiin.
            EOD;

            $this->kirimPesan($request, $nomor, $pesan, $row[0], $nama);
        }

        return back()->with("success", "Pesan sedang dalam proses pengiriman");
    }

    private function formatNomor($nomor)
    {
        $nomor = PhoneNumberHelper::format($nomor);
        return $nomor;
    }

    private function kirimPesan(Request $request, $nomor, $pesan, $no, $nama)
    {
        $nomor = $this->formatNomor($nomor);

        $payload['phone_no'] = $nomor;
        $payload['message'] = $pesan;
        $nasabah = "riau_sulaiman_al_fauzan";

        $log = new LogModel();
        $log->user_id = Auth::user()->id;
        $log->menu = "Whatsapp Gaji";
        $log->aksi = "Kirim Whatsapp Gaji";
        $log->client_info = $request->server("HTTP_USER_AGENT");
        $log->target_id = "Kirim Whatsapp Gaji";
        $log->ip_address = $request->ip();
        $log->status = "kirim whatsapp";
        $log->save();

        $idLog = $log->id;

        try {
            DB::beginTransaction();

            $newLog = LogWhatsappsModel::create([
                "custid" => $no,
                "log_id" => $idLog,
                "user_id" => Auth::id(),
                "status" => 0,
                "no_wa" => $nomor,
                "pesan" => $pesan,
                "nama" => $nama,
                "response" => '',
            ]);

            $sendData = DB::connection('mysql_wa')
                ->select('CALL new_whatsapp_queue(:param1, :param2, :param3, :param4)', [
                    'param1' => $nasabah,
                    'param2' => $newLog->id,
                    'param3' =>  $payload['phone_no'],
                    'param4' => $payload['message']
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger("LogWhatsappsModel Error: " . $e->getMessage());
        }
    }
}
