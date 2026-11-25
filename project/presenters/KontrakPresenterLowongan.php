<?php

interface KontrakPresenterLowongan {
    // MENAMPILKAN DAFTAR LOWONGAN
    public function tampilkanLowongan(): string;
    // MENAMPILKAN FORM TAMBAH ATAU EDIT LOWONGAN
    public function tampilkanFormLowongan(?int $id = null): string;
    // MENAMBAHKAN LOWONGAN BARU
    public function tambahLowongan(string $namaLowongan, string $departemen, string $lokasi, string $tipe, string $status): void;
    // MEMPERBARUI DATA LOWONGAN
    public function ubahLowongan(int $id, string $namaLowongan, string $departemen, string $lokasi, string $tipe, string $status): void;
    // MENGHAPUS DATA LOWONGAN
    public function hapusLowongan(int $id): void;
}

?>