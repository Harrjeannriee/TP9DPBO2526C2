<?php
require_once __DIR__ . '/KontrakPresenter.php';
require_once __DIR__ . '/../models/KontrakModel.php';
require_once __DIR__ . '/../views/KontrakView.php';

class PresenterKandidat implements KontrakPresenter
{
    private KontrakModel $model;
    private KontrakView $view;

    // CONSTRUCTOR
    public function __construct(KontrakModel $model, KontrakView $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    /**
     * Helper untuk merakit 1 baris HTML tabel kandidat.
     * Panggil dari dalam tampilkanKandidat() saat melakukan foreach.
     */
    private function buildRowHtml(int $no, Kandidat $kandidat): string
    {
        $id = (int)$kandidat->getId();
        $nama = htmlspecialchars($kandidat->getNama());
        $posisi = htmlspecialchars($kandidat->getPosisi());
        $domisili = htmlspecialchars($kandidat->getDomisili());
        $skorTes = number_format($kandidat->getSkorTes()) . ' / 100';
        $pengalaman = number_format($kandidat->getPengalamanTahun()) . ' Tahun';

        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$nama}</strong></td>
            <td>{$posisi}</td>
            <td>{$domisili}</td>
            <td>{$skorTes}</td>
            <td>{$pengalaman}</td>
            <td class='col-actions'>
                <a href='index.php?screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
                <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus kandidat ini?')\">
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    public function tampilkanKandidat(): string
    {
        // 1. Ambil data dari $this->model->getAllKandidat()
        $listKandidat = $this->model->getAllKandidat();
        // 2. Hitung $totalKandidat = count($listKandidat)
        $totalKandidat = count($listKandidat);

        // 3. Rakit $rowsHtml menggunakan loop + $this->buildRowHtml($no, $kandidat)
        $rowsHtml = '';

        // cek apakah listKandidat kosong
        if (empty($listKandidat)) {
            // kalau belum ada data kandidat maka tampilkan anu
            $rowsHtml = '<tr><td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data kandidat.</td></tr>';
        } 
        // kalau data gak kosong
        else {
            // berikan nomor urut pada setiap kandidat, mulai dari 1
            $no = 1;

            // ambil setiap kandidat dari listKandidat secara bergantian, untuk membaut html untuk setiap kandidat dan menggabungkannya ke $rowsHtml
            foreach ($listKandidat as $kandidat) {
                $rowsHtml .= $this->buildRowHtml($no, $kandidat);
                $no++;
            }
        }

        // 4. Kembalikan $this->view->renderDaftar($rowsHtml, $totalKandidat)
        return $this->view->renderDaftar($rowsHtml, $totalKandidat);
    }

    // MENENTUKAN FORM APA YANG HARUS DITAMPILKAN, FORM ADD ATAU UPDATE
    public function tampilkanFormKandidat(?int $id = null): string
    {
        // apakah id ada
        if ($id !== null) {
            // ambil kandidat dengan id yang diminta
            $kandidat = $this->model->getKandidatById($id);

            // jika kandidat yang diminta gak ada, arahkan pengguna kembali ke halaman utama
            if ($kandidat === null) {
                header("Location: index.php");
                exit(); // untuk menghentikan eksekusi program sebelum redirect
            }

            // mengubah data dari objek kandidat menjadi array $formData
            $formData = [
                'id' => $kandidat->getId(),
                'nama' => $kandidat->getNama(),
                'posisi' => $kandidat->getPosisi(),
                'domisili' => $kandidat->getDomisili(),
                'skorTes' => $kandidat->getSkorTes(),
                'pengalamanTahun' => $kandidat->getPengalamanTahun()
            ];

            // kirim data ke vuew, presenter meminta view untuk menampilkan form edit
            return $this->view->renderForm(
                "Ubah Data Kandidat",
                "ubah",
                $formData
            );

        }
        
        return $this->view->renderForm(
            "Tambah Kandidat Baru",
            "tambah",
            []
        );
    }

    // presenter menerima data dari form
     public function tambahKandidat(string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void 
     {
        // bagian yang menghubungkan presenter dengan model
        $this->model->addKandidat(
            $nama,
            $posisi,
            $domisili,
            $skorTes,
            $pengalamanTahun
        );

        // setelah data berhasil direspon, pengguna diarahkan kembali ke halaman utama
        header("Location: index.php");
        exit(); //hentikan eksekusi script setelah redirect
    }

    // presenter menerima data dari form
    public function ubahKandidat(int $id, string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        // meneruskan seluruh data ke model
        $this->model->updateKandidat(
            $id,
            $nama,
            $posisi,
            $domisili,
            $skorTes,
            $pengalamanTahun
        );

        // mengarahkan pengguna kembali ke halaman utama
        header("Location: index.php");
        // mengehntikan eksekusi program
        exit();
    }

    public function hapusKandidat(int $id): void
    {
        // presenter meneruskan id kandidat ke model melali method deleteKandidat
        $this->model->deleteKandidat($id);

        // mengarahkan pengguna kembali ke halaman utama
        header("Location: index.php");
        // menghentikan eksekusi program
        exit();
    }
}
