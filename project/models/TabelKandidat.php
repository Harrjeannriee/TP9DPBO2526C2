<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakModel.php';
require_once __DIR__ . '/Kandidat.php';

class TabelKandidat extends DB implements KontrakModel
{

    public function __construct(
        string $host = "localhost",
        string $db_name = "mvp_kandidat_db",
        string $username = "root",
        string $password = ""
    ) {
        parent::__construct($host, $db_name, $username, $password);
    }

    private function mapRowToKandidat(array $row): Kandidat
    {
        return new Kandidat(
            (int)$row['id'],
            $row['nama'],
            $row['posisi'],
            $row['domisili'],
            (int)$row['skorTes'],
            (int)$row['pengalamanTahun']
        );
    }

    // MENGAMBIL DATA SELURUH KANDIDAT
    public function getAllKandidat(): array
    {
        // ambil data semua kolom dari tabel kandidat, urutkan hasil dari skor tertinggi, jika skor sama maka id terkecil dahulu 
        $query = "SELECT * FROM kandidat ORDER BY skorTes DESC, id ASC";
        // panggil method executeQuery dari class DB untuk menjalankan query
        $this->executeQuery($query);
        // ambil hasil query 
        $rows = $this->getAllResult();

        // siapkan wadah objek
        $list = [];
        // ubah satu abris query menjadi objek kandidat
        foreach ($rows as $row) {
            $list[] = $this->mapRowToKandidat($row);
        }
        return $list;
    }

    // MENGAMBIL SELURUH DATA MILIK SATU KANDIDAT BERDASARKAN ID YANG DIMINTA
    public function getKandidatById(int $id): ?Kandidat
    {
        // dari data yang ada di tabel kandidat, ambil id yang diminta, maksimal 1 baris
        $query = "SELECT * FROM kandidat WHERE id = :id LIMIT 1";
        // panggil executeQuery untuk menjalankan query sebelumnya
        $this->executeQuery($query, [':id' => $id]);
        // setelah query dijalankan, ambil hasilnya
        $rows = $this->getAllResult();

        // apakah data ditemukan, jika tidak maka tidak mengembalikan apapun
        if (empty($rows)) {
            return null;
        }

        // mengubah hasil database menjadi objek kandidat
        return $this->mapRowToKandidat($rows[0]);
    }

    // MENAMBAHKAN DATA KANDIDAT BARU KE TABEL
    public function addKandidat(string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void
    {
        // tambahkan data ke tabel kandidat dengan kolom-kolom yang akan diisi, dengan values adalah nilai yang akan dimasukkan ke kolom tersebut
        $query = "INSERT INTO kandidat
              (nama, posisi, domisili, skorTes, pengalamanTahun)
              VALUES    
              (:nama, :posisi, :domisili, :skorTes, :pengalamanTahun)"; //ini placeholder, tempat sementara untuk nilai yang bakal dimasukkin

        // mengisi placeholder dengan nilai sebenernya
        $params = [
            ':nama' => $nama,
            ':posisi' => $posisi,
            ':domisili' => $domisili,
            ':skorTes' => $skorTes,
            ':pengalamanTahun' => $pengalamanTahun
        ];

        // jalankan query
        $this->executeQuery($query, $params);
    }

    // MEMPERBARUI DATA KANDIDAT
    public function updateKandidat(int $id, string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void
    {
        // update data dari tabel kandidat,tentukan kolom dan nilai barunya berdasarkan id yang diminta 
        $query = "UPDATE kandidat SET
              nama = :nama,
              posisi = :posisi,
              domisili = :domisili,
              skorTes = :skorTes,
              pengalamanTahun = :pengalamanTahun
              WHERE id = :id";

        // isi placeholder dengan nilai sebenarnya
        $params = [
            ':id' => $id,
            ':nama' => $nama,
            ':posisi' => $posisi,
            ':domisili' => $domisili,
            ':skorTes' => $skorTes,
            ':pengalamanTahun' => $pengalamanTahun
        ];

        // jalankan query
        $this->executeQuery($query, $params);
    }

    // MENGHAPUS DATA KANDIDAT DARI KOLOM
    public function deleteKandidat(int $id): void
    {
        // delete data dari tabel kandidat berdasarkan id yang diminta
        $query = "DELETE FROM kandidat WHERE id = :id";

        // isi placeholder
        $params = [
            ':id' => $id
        ];

        // jalankan query
        $this->executeQuery($query, $params);
    }
}
