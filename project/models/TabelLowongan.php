<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakModelLowongan.php';
require_once __DIR__ . '/Lowongan.php';

class TabelLowongan extends DB implements KontrakModelLowongan
{

    public function __construct(
        string $host = "localhost",
        string $db_name = "mvp_kandidat_db",
        string $username = "root",
        string $password = ""
    ) {
        parent::__construct($host, $db_name, $username, $password);
    }

    private function mapRowToLowongan(array $row): Lowongan
    {
        return new Lowongan(
            (int)$row['id'],
            $row['nama_lowongan'],
            $row['departemen'],
            $row['lokasi'],
            $row['tipe'],
            $row['status']
        );
    }

    // MENGAMBIL DATA SELURUH LOWONGAN
    public function getAllLowongan(): array
    {
        // ambil data semua kolom dari tabel lowongan, urutkan hasil berdasarkan id terkecil dahulu
        $query = "SELECT * FROM lowongan ORDER BY id ASC";

        // panggil method executeQuery dari class DB untuk menjalankan query
        $this->executeQuery($query);

        // ambil hasil query
        $rows = $this->getAllResult();

        // siapkan wadah objek
        $list = [];

        // ubah satu baris query menjadi objek lowongan
        foreach ($rows as $row) {
            $list[] = $this->mapRowToLowongan($row);
        }

        return $list;
    }

    // MENGAMBIL SELURUH DATA MILIK SATU LOWONGAN BERDASARKAN ID YANG DIMINTA
    public function getLowonganById(int $id): ?Lowongan
    {
        // dari data yang ada di tabel lowongan, ambil id yang diminta, maksimal 1 baris
        $query = "SELECT * FROM lowongan WHERE id = :id LIMIT 1";

        // panggil executeQuery untuk menjalankan query sebelumnya
        $this->executeQuery($query, [':id' => $id]);

        // setelah query dijalankan, ambil hasilnya
        $rows = $this->getAllResult();

        // apakah data ditemukan, jika tidak maka tidak mengembalikan apapun
        if (empty($rows)) {
            return null;
        }

        // mengubah hasil database menjadi objek lowongan
        return $this->mapRowToLowongan($rows[0]);
    }

    // MENAMBAHKAN DATA LOWONGAN BARU KE TABEL
    public function addLowongan(
        string $namaLowongan,
        string $departemen,
        string $lokasi,
        string $tipe,
        string $status
    ): void
    {
        // tambahkan data ke tabel lowongan dengan kolom-kolom yang akan diisi, dengan values adalah nilai yang akan dimasukkan ke kolom tersebut
        $query = "INSERT INTO lowongan
              (nama_lowongan, departemen, lokasi, tipe, status)
              VALUES
              (:namaLowongan, :departemen, :lokasi, :tipe, :status)";

        // mengisi placeholder dengan nilai sebenarnya
        $params = [
            ':namaLowongan' => $namaLowongan,
            ':departemen' => $departemen,
            ':lokasi' => $lokasi,
            ':tipe' => $tipe,
            ':status' => $status
        ];

        // jalankan query
        $this->executeQuery($query, $params);
    }

    // MEMPERBARUI DATA LOWONGAN
    public function updateLowongan(
        int $id,
        string $namaLowongan,
        string $departemen,
        string $lokasi,
        string $tipe,
        string $status
    ): void
    {
        // update data dari tabel lowongan, tentukan kolom dan nilai barunya berdasarkan id yang diminta
        $query = "UPDATE lowongan SET
              nama_lowongan = :namaLowongan,
              departemen = :departemen,
              lokasi = :lokasi,
              tipe = :tipe,
              status = :status
              WHERE id = :id";

        // isi placeholder dengan nilai sebenarnya
        $params = [
            ':id' => $id,
            ':namaLowongan' => $namaLowongan,
            ':departemen' => $departemen,
            ':lokasi' => $lokasi,
            ':tipe' => $tipe,
            ':status' => $status
        ];

        // jalankan query
        $this->executeQuery($query, $params);
    }

    // MENGHAPUS DATA LOWONGAN DARI TABEL
    public function deleteLowongan(int $id): void
    {
        // delete data dari tabel lowongan berdasarkan id yang diminta
        $query = "DELETE FROM lowongan WHERE id = :id";

        // isi placeholder
        $params = [
            ':id' => $id
        ];

        // jalankan query
        $this->executeQuery($query, $params);
    }
}

?>