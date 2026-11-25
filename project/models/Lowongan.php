<?php

class Lowongan {
    private ?int $id;
    private string $namaLowongan;
    private string $departemen;
    private string $lokasi;
    private string $tipe;
    private string $status;

    public function __construct(
        ?int $id,
        string $namaLowongan,
        string $departemen,
        string $lokasi,
        string $tipe,
        string $status
    ) {
        $this->id = $id;
        $this->namaLowongan = $namaLowongan;
        $this->departemen = $departemen;
        $this->lokasi = $lokasi;
        $this->tipe = $tipe;
        $this->status = $status;
    }

    // GETTER
    public function getId(): ?int { return $this->id; }
    public function getNamaLowongan(): string { return $this->namaLowongan; }
    public function getDepartemen(): string { return $this->departemen; }
    public function getLokasi(): string { return $this->lokasi; }
    public function getTipe(): string { return $this->tipe; }
    public function getStatus(): string { return $this->status; }

    // SETTER
    public function setNamaLowongan(string $namaLowongan): void {
        $this->namaLowongan = $namaLowongan;
    }

    public function setDepartemen(string $departemen): void {
        $this->departemen = $departemen;
    }

    public function setLokasi(string $lokasi): void {
        $this->lokasi = $lokasi;
    }

    public function setTipe(string $tipe): void {
        $this->tipe = $tipe;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }
}

?>