<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('abouts')->insert([
            [
                'name' => 'Visi',
                'description' => 'Menjadi jemaat yang akrab, terbuka dan bersahabat',
                'users_id' => 1
            ],
            [
                'name' => 'Misi',
                'description' => '1. Memfasilitasi perjumpaan Allah dengan jemaat, sehingga jemaat mengalami pertumbuhan spiritual.
2. Mengupayakan agar jemaat hidup dalam kasih dan persaudaraan yang akrab dan terbuka.
3. Meningkatkan kecintaan jemaat terhadap GKI Sudirman sebagai tubuh Kristus.
4. Melaksanakan kesaksian dan pelayanan di gereja dan masyarakat.
5. Melakukan perwujudan keesaan gereja dan persaudaraan umat manusia.
6. Meningkatkan pertumbuhan anggota jemaat.
7. Mengembangkan sarana prasarana untuk memfasilitasi terlaksananya kegiatan Ibadah yang nyaman.',
                'users_id' => 1
            ],
            [
                'name' => 'Alamat',
                'description' => 'Jl. Jenderal Sudirman No. 638, Bandung 40183',
                'users_id' => 1
            ],
            [
                'name' => 'Email',
                'description' => 'gkisudirman@yahoo.com',
                'users_id' => 1
            ],
            [
                'name' => 'Nomor Telepon / WhatsApp',
                'description' => '(022) 6002374 / +62 852-2153-6465',
                'users_id' => 1
            ],
            [
                'name' => 'YouTube',
                'description' => 'https://youtube.com/@gkisudirmanbandungofficial',
                'users_id' => 1
            ],
            [
                'name' => 'Instagram',
                'description' => 'https://www.instagram.com/gkisudirman638/',
                'users_id' => 1
            ],
            [
                'name' => 'Media Sosial Lainnya',
                'description' => 'https://linktr.ee/gkisudirman',
                'users_id' => 1
            ],
            [
                'name' => 'Google Maps',
                'description' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7771140072223!2d107.57513697499641!3d-6.917229393082363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e60f9afa0293%3A0x63838b8166ba3d47!2sGKI%20Sudirman!5e0!3m2!1sid!2sid!4v1779028497868!5m2!1sid!2sid',
                'users_id' => 1
            ],
            [
                'name' => 'Tema Utama',
                'description' => 'Tuhan Mencipta, Manusia Ikut Serta',
                'users_id' => 1
            ],
            [
                'name' => 'Tema GKI Sinwil Jabar',
                'description' => 'Permulaan Hikmat Adalah Takut Akan Tuhan: Upaya GKI Sinwil Jabar Memperkuat MULTAE ECCLESIAE',
                'users_id' => 1
            ],
            [
                'name' => 'Informasi Penting',
                'description' => 'Sekretariat Gereja: Siska Gunawan (0852-2153 6465)
Konseling Pastoral: Pdt. Yosafat Simatupang (0813-1496-7766)
Petugas Kebaktian: Pnt. Khibouth Ambrosia (0815-6204-668)
Perubahan alamat: Kepala Rayon masing-masing',
                'users_id' => 1
            ]
        ]);
    }
}
