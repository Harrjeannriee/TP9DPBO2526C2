
<?php
require_once __DIR__ . '/KontrakPresenterLowongan.php';
require_once __DIR__ . '/../models/KontrakModelLowongan.php';
require_once __DIR__ . '/../models/Lowongan.php';
require_once __DIR__ . '/../views/KontrakView.php';

class PresenterLowongan implements KontrakPresenterLowongan
{
    private KontrakModelLowongan $model;
    private KontrakView $view;

    // CONSTRUCTOR
    public function __construct(KontrakModelLowongan $model, KontrakView $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    /**
     * Helper untuk merakit 1 baris HTML tabel lowongan.
     * Panggil dari dalam tampilkanLowongan() saat melakukan foreach.
     */
    private function buildRowHtml(int $no, Lowongan $lowongan): string
    {
        $id = (int)$lowongan->getId();
        $namaLowongan = htmlspecialchars($lowongan->getNamaLowongan());
        $departemen = htmlspecialchars($lowongan->getDepartemen());
        $lokasi = htmlspecialchars($lowongan->getLokasi());
        $tipe = htmlspecialchars($lowongan->getTipe());
        $status = htmlspecialchars($lowongan->getStatus());

        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$namaLowongan}</strong></td>
            <td>{$departemen}</td>
            <td>{$lokasi}</td>
            <td>{$tipe}</td>
            <td>{$status}</td>
            <td class='col-actions'>
                <a href='index.php?module=lowongan&screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
                <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus lowongan ini?')\">
                    <input type='hidden' name='module' value='lowongan'>
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    public function tampilkanLowongan(): string
    {
        // 1. Ambil data dari $this->model->getAllLowongan()
        $listLowongan = $this->model->getAllLowongan();

        // 2. Hitung $totalLowongan = count($listLowongan)
        $totalLowongan = count($listLowongan);

        // 3. Rakit $rowsHtml menggunakan loop + $this->buildRowHtml($no, $lowongan)
        $rowsHtml = '';

        // cek apakah listLowongan kosong
        if (empty($listLowongan)) {
            // kalau belum ada data lowongan maka tampilkan anu
            $rowsHtml = '<tr><td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data lowongan.</td></tr>';
        }
        // kalau data gak kosong
        else {
            // berikan nomor urut pada setiap lowongan, mulai dari 1
            $no = 1;

            // ambil setiap lowongan dari listLowongan secara bergantian, untuk membuat html untuk setiap lowongan dan menggabungkannya ke $rowsHtml
            foreach ($listLowongan as $lowongan) {
                $rowsHtml .= $this->buildRowHtml($no, $lowongan);
                $no++;
            }
        }

        // 4. Kembalikan $this->view->renderDaftar($rowsHtml, $totalLowongan)
        return $this->view->renderDaftar($rowsHtml, $totalLowongan);
    }

    // MENENTUKAN FORM APA YANG HARUS DITAMPILKAN, FORM ADD ATAU UPDATE
    public function tampilkanFormLowongan(?int $id = null): string
    {
        // apakah id ada
        if ($id !== null) {
            // ambil lowongan dengan id yang diminta
            $lowongan = $this->model->getLowonganById($id);

            // jika lowongan yang diminta gak ada, arahkan pengguna kembali ke halaman utama
            if ($lowongan === null) {
                header("Location: index.php?module=lowongan");
                exit(); // untuk menghentikan eksekusi program sebelum redirect
            }

            // mengubah data dari objek lowongan menjadi array $formData
            $formData = [
                'id' => $lowongan->getId(),
                'namaLowongan' => $lowongan->getNamaLowongan(),
                'departemen' => $lowongan->getDepartemen(),
                'lokasi' => $lowongan->getLokasi(),
                'tipe' => $lowongan->getTipe(),
                'status' => $lowongan->getStatus()
            ];

            // kirim data ke view, presenter meminta view untuk menampilkan form edit
            return $this->view->renderForm(
                "Ubah Data Lowongan",
                "ubah",
                $formData
            );
        }

        return $this->view->renderForm(
            "Tambah Lowongan Baru",
            "tambah",
            []
        );
    }

    // presenter menerima data dari form
    public function tambahLowongan(
        string $namaLowongan,
        string $departemen,
        string $lokasi,
        string $tipe,
        string $status
    ): void
    {
        // bagian yang menghubungkan presenter dengan model
        $this->model->addLowongan(
            $namaLowongan,
            $departemen,
            $lokasi,
            $tipe,
            $status
        );

        // setelah data berhasil direspon, pengguna diarahkan kembali ke halaman utama
        header("Location: index.php?module=lowongan");
        exit(); //hentikan eksekusi script setelah redirect
    }

    // presenter menerima data dari form
    public function ubahLowongan(
        int $id,
        string $namaLowongan,
        string $departemen,
        string $lokasi,
        string $tipe,
        string $status
    ): void {
        // meneruskan seluruh data ke model
        $this->model->updateLowongan(
            $id,
            $namaLowongan,
            $departemen,
            $lokasi,
            $tipe,
            $status
        );

        // mengarahkan pengguna kembali ke halaman utama
        header("Location: index.php?module=lowongan");
        // mengehntikan eksekusi program
        exit();
    }

    public function hapusLowongan(int $id): void
    {
        // presenter meneruskan id lowongan ke model melalui method deleteLowongan
        $this->model->deleteLowongan($id);

        // mengarahkan pengguna kembali ke halaman utama
        header("Location: index.php?module=lowongan");
        // menghentikan eksekusi program
        exit();
    }
}

?>
