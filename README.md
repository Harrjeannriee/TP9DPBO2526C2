# DESAIN PROGRAM
Program ini dibuat untuk mengelola data rekrutmen karyawan, yang mencakup pengelolaan data kandidat dan informasi lowongan pekerjaan. Program menyediakan fitur CRUD (Create, Read, Update, Delete) untuk kedua jenis data tersebut dengan menggunakan PHP, dan MySQL. Program ini memiliki dua tabel utama dalam database yaitu:
1. Tabel kandidat, digunakan untuk menyimpan data kandidat yang meliputi ID, nama, posisi yang dilamar, domisili, skor tes, dan pengalaman kerja.
2. Tabel lowongan, digunakan untuk menyimpan informasi lowongan pekerjaan meliputi ID, nama lowongan, departemen, lokasi, tipe pekerjaan, dan status lowongan.
   
Dalam penerapan MVP, program dibagi menjadi tiga bagian dengan tanggung jawab masing-masing yaitu:
1. Model: Bertugas mengelola data dan berhubungan langsung dengan database. Model menangani proses pengambilan, penambahan, perubahan, dan penghapusan data.
2. View: Bertugas mengatur tampilan program, mulai dari halaman daftar data hingga form tambah dan eidt. View hanya menampilkan data yang sudah disiapkan oleh presenter.
3. Presenter, menjadi penghubung antara model dan view. Presenter mengambil data dari model, mengolahnya, menyiapkan baris tabel, menghitung jumlah data, dan meneruskannya ke view.

Selain itu pada program ini terdapat Contract atau Interface sebagai aturan komunikasi antar komponen. Interface menentukan method yang harus tersedia pada setiap komponen sehingga Model, View, Presenter memiliki kesepakatan mengenai cara mereka saling berkomunikasi. 
Penggunaan interface juga membantu mengurangi ketergantungan antar class. Dengan begitu implmentasi suatu komponen dapat diubah tanpa harus mengubah seluruh bagian program, selama tetap mengikuti contract yang sudah ditentukan.
Program ini menerapkan prinsip Strict Passive View, yaitu View tidak mengakses Model maupun Entity secara langsung. Proses pengolahan data dilakukan oleh Presenter, sedangkan View hanya bertugas menampilkan hasilnya.
se
# PENJELASAN ALUR PROGRAM
Alur program dimulai ketika pengguna membuka halaman kandidat atau lowongan melalui index.php. File ini menentukan modul yang akan dijalankan, kemudian meneruskan request ke Presenter yang sesuai.
1. View menerima input dan menampilkan halaman. Ketika pengguna membuka halaman, View akan menyiapkan tampilan berdasarkan template HTML. Jika pengguna ingin menambah atau mengubah data, View menampilkan form dan meneruskan input melalui request ke index.php.
2. Presenter mengatur proses program. Presenter menerima request dari index.php, kemudian menentukan proses yang harus dijalankan, seperti menampilkan daftar data, menampilkan form, menambah, mengubah, atau menghapus data. Untuk mengambil atau mengubah data, Presenter memanggil method yang tersedia pada Model melalui interface.
3. Model mengelola data di database. Model menjalankan proses sesuai permintaan Presenter, seperti mengambil data dari tabel, menyimpan data baru, memperbarui data, atau menghapus data. Hasil proses tersebut kemudian dikembalikan kepada Presenter.
4. Presenter menyiapkan hasil untuk View. Data yang diperoleh dari Model diolah oleh Presenter menjadi informasi yang siap ditampilkan. Pada halaman daftar, Presenter juga menyiapkan baris tabel dan menghitung jumlah data. Setelah itu, Presenter meneruskan hasilnya ke View.
5. View menampilkan hasil kepada pengguna. View menerima data yang sudah disiapkan Presenter, kemudian mengganti placeholder pada template HTML. Dengan begitu, View tidak perlu mengakses database atau mengolah data sendiri.

# DOKUMENTASI
[Klik di sini untuk melihat video dokumentasi](dokumentasi/screen_record_tp9.mp4)
