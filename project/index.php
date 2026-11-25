
<?php

// MEMANGGIL FILE MODUL KANDIDAT
require_once __DIR__ . '/models/TabelKandidat.php';
require_once __DIR__ . '/views/ViewKandidat.php';
require_once __DIR__ . '/presenters/PresenterKandidat.php';

// MEMANGGIL FILE MODUL LOWONGAN
require_once __DIR__ . '/models/TabelLowongan.php';
require_once __DIR__ . '/views/ViewLowongan.php';
require_once __DIR__ . '/presenters/PresenterLowongan.php';

// INISIALISASI MODUL KANDIDAT
$modelKandidat = new TabelKandidat(
    'localhost',
    'mvp_kandidat_db',
    'root',
    ''
);

$viewKandidat = new ViewKandidat();

$presenterKandidat = new PresenterKandidat(
    $modelKandidat,
    $viewKandidat
);

// INISIALISASI MODUL LOWONGAN
$modelLowongan = new TabelLowongan(
    'localhost',
    'mvp_kandidat_db',
    'root',
    ''
);

$viewLowongan = new ViewLowongan();

$presenterLowongan = new PresenterLowongan(
    $modelLowongan,
    $viewLowongan
);

// MENENTUKAN MODUL YANG DIAKSES, Jika parameter module tidak ada, default ke kandidat.
$module = $_POST['module'] ?? $_GET['module'] ?? 'kandidat';

// MENANGANI REQUEST POST (CREATE, UPDATE, DELETE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    // MODUL KANDIDAT
    if ($module === 'kandidat') {

        if ($action === 'tambah') {

            $presenterKandidat->tambahKandidat(
                trim($_POST['nama']),
                trim($_POST['posisi']),
                trim($_POST['domisili']),
                (int) $_POST['skorTes'],
                (int) $_POST['pengalamanTahun']
            );

        } elseif ($action === 'ubah') {

            $presenterKandidat->ubahKandidat(
                (int) $_POST['id'],
                trim($_POST['nama']),
                trim($_POST['posisi']),
                trim($_POST['domisili']),
                (int) $_POST['skorTes'],
                (int) $_POST['pengalamanTahun']
            );

        } elseif ($action === 'hapus') {

            $presenterKandidat->hapusKandidat(
                (int) $_POST['id']
            );

        } else {
            header("Location: index.php");
            exit();
        }

    // MODUL LOWONGAN
    } elseif ($module === 'lowongan') {

        if ($action === 'tambah') {

            $presenterLowongan->tambahLowongan(
                trim($_POST['namaLowongan']),
                trim($_POST['departemen']),
                trim($_POST['lokasi']),
                trim($_POST['tipe']),
                trim($_POST['status'])
            );

        } elseif ($action === 'ubah') {

            $presenterLowongan->ubahLowongan(
                (int) $_POST['id'],
                trim($_POST['namaLowongan']),
                trim($_POST['departemen']),
                trim($_POST['lokasi']),
                trim($_POST['tipe']),
                trim($_POST['status'])
            );

        } elseif ($action === 'hapus') {

            $presenterLowongan->hapusLowongan(
                (int) $_POST['id']
            );

        } else {
            header("Location: index.php?module=lowongan");
            exit();
        }

    } else {
        header("Location: index.php");
        exit();
    }

// MENANGANI REQUEST GET (READ DAN FORM)
} else {

    $screen = $_GET['screen'] ?? 'list';

    // MODUL KANDIDAT
    if ($module === 'kandidat') {

        if ($screen === 'add') {

            echo $presenterKandidat->tampilkanFormKandidat();

        } elseif ($screen === 'edit' && isset($_GET['id'])) {

            echo $presenterKandidat->tampilkanFormKandidat(
                (int) $_GET['id']
            );

        } else {

            echo $presenterKandidat->tampilkanKandidat();
        }

    // MODUL LOWONGAN
    } elseif ($module === 'lowongan') {

        if ($screen === 'add') {

            echo $presenterLowongan->tampilkanFormLowongan();

        } elseif ($screen === 'edit' && isset($_GET['id'])) {

            echo $presenterLowongan->tampilkanFormLowongan(
                (int) $_GET['id']
            );

        } else {

            echo $presenterLowongan->tampilkanLowongan();
        }

    } else {

        header("Location: index.php");
        exit();
    }
}

?>
