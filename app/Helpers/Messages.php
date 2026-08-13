<?php

namespace App\Helpers;


final class Messages
{

    public static function wa($message)
    {

        // $messages = [
        //     "Assalamualaikum Wr Wb,
        //     \nSalam sejahtera bagi kita semua. Kami ingin menginformasikan kepada Anda, orang tua ananda {nama_anak}, untuk tunggakan tagihan anak Anda sebesar {jumlah_tagihan}.
        //     \nDengan Rincian :{rincian}\nDemikian pesan dari kami. Wassalam 🙏.\n\n*_*pesan otomatis dari " . config('app.nama_instansi') . "_*\n*_*silahkan hubungi admin sekolah jika ada kesalahan tagihan atau nama siswa_*",

        //     "Selamat pagi/siang/malam,Bapak/Ibu {nama_orang_tua}. Kami ingin mengingatkan bahwa tunggakan tagihan untuk ananda {nama_anak} sebesar {jumlah_tagihan} sudah jatuh tempo.
        //     \nRincian Tagihan :{rincian}\nTerima kasih atas perhatiannya. Salam hormat dari kami 🙏.\n\n*_*pesan otomatis dari " . config('app.nama_instansi') . "_*\n*_*silahkan hubungi admin sekolah jika ada kesalahan tagihan atau nama siswa_*",

        //     " *_*Friendly Rimender From " . config('app.nama_instansi') . "_*\n\nPermisi Bapak/Ibu {nama_orang_tua}, berikut ini merupakan pesan pengingat untuk tunggakan tagihan sekolah yang dimiliki ananda {nama_anak} yang berjumlah {jumlah_tagihan}.
        //     \nDengan Rincian Tagihannya :{rincian}\nKami harap Bapak/Ibu dapat segera melunaskan beban tagihan tersebut. Terimakasih Wassalamualaikum wr wb 🙏.\n\n*_*silahkan hubungi admin sekolah jika ada kesalahan tagihan atau nama siswa_*",

        //     "Dengan hormat, kami sampaikan kepada Bapak/Ibu {nama_orang_tua}, bahwa tunggakan tagihan untuk ananda {nama_anak} sebesar {jumlah_tagihan} sudah harus dibayarkan.
        //     \nRincian :{rincian}\nTerima kasih atas perhatian dan kerjasamanya. Wassalam 🙏.\n\n*_pesan otomatis dari " . config('app.nama_instansi') . "_*\n*_*silahkan hubungi admin sekolah jika ada kesalahan tagihan atau nama siswa_*"
        // ];

        // $pesan = [
        //     "Assalamu'alaikum Warahmatullahi wabarakatuh\nKami dari keuangan Ibnu Abbas\nMemberitahukan kepada wali santri atas nama {nama_anak}\nMasih ada kekurangan pembayaran sebesar {jumlah_tagihan}, dengan rincian : {rincian}Mohon untuk segera di tunaikan, atas perhatiannya kami sampaikan \nJazaakumullah khairan katsiran.\n\n*_*pesan otomatis dari " . config('app.nama_instansi') . "_*\n*_*silahkan hubungi admin sekolah jika ada kesalahan tagihan atau nama siswa_*",

        //     "-السلام عليكم ورحمة الله وبركاته-\nKami dari Ibnu Abbas, memberitahukan kepada wali santri atas nama {nama_anak}\nAnanda masih memiliki kekurangan pembayaran sebesar {jumlah_tagihan}, dengan rincian : {rincian}Mohon untuk segera di tunaikan, atas perhatiannya kami sampaikan\nJazaakumullah khairan katsiran.\n\n*_*pesan otomatis dari " . config('app.nama_instansi') . "_*\n*_*silahkan hubungi admin sekolah jika ada kesalahan tagihan atau nama siswa_*",

        //     "Assalamu'alaikum Warahmatullahi wabarakatuh\nDengan hormat, dari " . config('app.nama_instansi') . ", kami sampaikan kepada Bapak/Ibu {nama_orang_tua}, bahwa $message untuk ananda {nama_anak} sebesar {jumlah_tagihan} sudah harus dibayarkan.\nRincian :{rincian}Terima kasih atas perhatian dan kerjasamanya. Wassalam 🙏.\n\n*_*pesan otomatis dari " . config('app.nama_instansi') . "_*\n*_*silahkan hubungi admin sekolah jika ada kesalahan tagihan atau nama siswa_*",

        //     "Assalamualaikum Wr Wb,\nBa'da tahmid, tahlil dan shalawat bagi kita semua. Kami ingin menginformasikan kepada Anda, orang tua ananda {nama_anak}, untuk $message anak Anda sebesar {jumlah_tagihan}.\nDengan Rincian :{rincian}\nDemikian pesan dari kami. Wassalam 🙏.\n\n*_*pesan otomatis dari " . config('app.nama_instansi') . "_*\n*_*silahkan hubungi admin sekolah jika ada kesalahan tagihan atau nama siswa_*",
        // ];

        $pesan = [
            "Assalamualaikum Warahmatullahi wabarakatuh\nKami dari keuangan Ponpes Sulaiman Al Fauzan\nMemberitahukan kepada wali santri atas nama {nama_anak}\nMasih ada kekurangan pembayaran sebesar {jumlah_tagihan}, dengan rincian : {rincian}Mohon untuk segera di tunaikan, atas perhatiannya kami sampaikan \nJazaakumullah khairan katsiran.\n\n*_*pesan otomatis dari " . config('app.nama_instansi') . "_*\n*_*Silahkan menghubungi bagian keuangan jika ada kesalahan tagihan atau nama siswa_*",

            "Assalamualaikum Warahmatullahi wabarakatuh\nDengan hormat, kami dari " . config('app.nama_instansi') . "  menyampaikan bahwa ananda {nama_anak} masih memiliki tagihan sebesar {jumlah_tagihan} dengan rincian.\nRincian :{rincian}Terima kasih atas perhatian dan kerjasamanya. Wassalam 🙏.\n\n*_*pesan otomatis dari " . config('app.nama_instansi') . "_*\n*_*Silahkan menghubungi bagian keuangan jika ada kesalahan tagihan atau nama siswa_*",

            "Assalamualaikum Wr Wb,\nBada tahmid, tahlil dan shalawat bagi kita semua. Kami ingin menginformasikan kepada Bapak/Ibu, orang tua ananda {nama_anak}, untuk $message Bapak/Ibu sebesar {jumlah_tagihan}.\nDengan Rincian :{rincian}\nDemikian pesan dari kami. Wassalam 🙏.\n\n*_*pesan otomatis dari " . config('app.nama_instansi') . "_*\n*_*Silahkan menghubungi bagian keuangan jika ada kesalahan tagihan atau nama siswa_*",
        ];
        return $pesan;
    }
}