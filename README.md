
# LINTANG AYU KINASIH AZZAHRO (220302039)

PRAKTIKUM PBF CODEIGNITER 4

## Selamat datang di CodeIgniter 4
### Selamat datang di CodeIgniter 4

#### Apa itu CODEIGNITER?
CodeIgniter sebuah tools untuk orang-orang yang membangun situs web menggunakan PHP. Tujuannya adalah untuk mengembangkan proyek jauh lebih cepat daripada jika menulis kode dari awal, dengan menyediakan kumpulan library yang kaya untuk tugas-tugas umum, serta antarmuka sederhana dan struktur logis untuk mengakses perpustakaan ini. CodeIgniter memungkinkan Anda fokus secara kreatif pada proyek Anda dengan meminimalkan jumlah kode yang dibutuhkan untuk tugas tertentu.

Jika memungkinkan, CodeIgniter dibuat sefleksibel mungkin, memungkinkan bekerja sesuai keinginan, tidak dipaksa bekerja dengan cara tertentu. Kerangka kerja dapat memiliki bagian-bagian inti yang mudah diperluas atau diganti seluruhnya untuk membuat sistem bekerja sesuai kebutuhan. Singkatnya, CodeIgniter adalah kerangka kerja lunak yang mencoba menyediakan alat yang Anda butuhkan tanpa mengganggu.

#### Apakah CodeIgniter Tepat untuk Anda?
CodeIgniter tepat jika:
- Menginginkan kerangka kerja dengan tapak kecil.
- Membutuhkan kinerja yang luar biasa.
- Menginginkan kerangka kerja yang hampir tidak memerlukan konfigurasi.
- Menginginkan kerangka kerja yang tidak mengharuskan Anda menggunakan baris perintah.
- Mnginginkan kerangka kerja yang tidak mengharuskan Anda mematuhi aturan pengkodean yang ketat.
- Menghindari kerumitan, lebih memilih solusi sederhana.
- Memerlukan dokumentasi yang jelas dan menyeluruh.

### Persyaratan Server
- PHP versi 7.4 atau lebih baru dengan ekstensi intl, mbstring, json
- Database yang didukung : 
    - MySQL versi 5.1 ke atas.
    - Oracle
    - PostgreSQL 
    - MSSQL 
    - SQLite 
    - CUBRID 
    - Interbase/Firebird 
    - ODBC 

## Instalasi
CodeIgniter memiliki dua metode instalasi yang didukung: download manual, atau menggunakan Composer.

### Instalasi Composer
Pada instalasi composer kali ini pastikan sudah melakukan instalasi composer dengan versi 2.0.14 atau lebih baru.

- Lakukan instalasi diatas folder yang diroot lalu mengetikkan baris perintah

    ```
    composer create-project codeigniter4/appstarter (nama-project)
    ```
- Untuk memperbarui versi composer maka dapat melakukan perintah:
    ```
    composer update
    ```

### Instalasi Manual
Pada instalasi manual, Lakukan download starter project pada repository diatas, dan dapat langsung mendunduh ZIP

Kelebihan : 
Kita hanya perlu mengunduh dan menjalankan.

### Menjalankan Aplikasi Anda
#### Konfigurasi awal
- Buka file **app/Config/App.php**
- Atur $baseURL untuk menentukan URL dasar, caranya adalah dengan megetikkan baris perintah
    ```
    $baseURL = 'http://localhost:8080/';
    ```
- Untuk menghilangkan URL index.php pada situs maka stel $indexPage menjadi ' '
    ```
    public string $indexPage = '';
    ```
- Cari file **env** dan Rename menjadi **.env** (dotenv)
- Dalam file .env ada perintah **#CI_ENVIRONMENT = production**, hilangkan tanda pagar **#** dan ubah production menjadi development.
    ```
    CI_ENVIRONMENT = development
    ```
#### Server Pengembangan Lokal
CodeIgniter 4 hadir dengan server pengembangan lokal, memanfaatkan server web bawaan PHP dengan routing CodeIgniter.

```
php spark serve
```
Pada terminal akan muncul server http://localhost:8080 , klik alamat URL tersebut maka dapat melihat Aplikasi pada browser.

## Bangun Aplikasi Pertama Anda
### Halaman Statis
Hal pertama yang akan dilakukan adalah menyiapkan aturan perutean untuk menangani static pages.

#### Menetapkan Aturan Perutean
Routes mengaitkan URl degan method Controller. Buka file rute yang terletak di **app/Config/Routes.php**.

Tambahkan baris berikut
```
use App\Controllers\Pages;

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
```

#### Buat Halaman Controller
Buat file di **app/Controllers/Pages.php**, tambahkan kode berikut
```
<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view($page = 'home')
    {
        // ...
    }
}
```
Kita telah membuat class Pages dengan method `view( )` yang menerima satu argumen dengan nama `$page`.

#### Buat Tampilan
Buat header di **app/Views/templates/header.php** dan tambahkan baris kode berikut:

```
<!doctype html>
<html>
<head>
    <title>CodeIgniter Tutorial</title>
</head>
<body>

    <h1><?= esc($title) ?></h1>
```
Header berisi kode HTML dasar yang ingin ditampilkan sebelum memuat views utama.

Buat Footer di **app/Views/templates/footer.php** yang memuat baris kode berikut:

```
   <em>&copy; 2022</em>
</body>
</html>
```

#### Menambahkan Logika ke Controller
- Buka direktori **app/Views/pages**
- Pada direktori tersebut buat **home.php** dan **about.php**, isikan dengan "Hallo World!"
- Untuk memuat tersebut maka membutuhkan method `view()` pada controller Pages yang telah dibuat diatas:

    ```
    <?php

    namespace App\Controllers;

    use CodeIgniter\Exceptions\PageNotFoundException; // Add this line

    class Pages extends BaseController
    {
        // ...

        public function view($page = 'home')
        {
            if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
                // Whoops, we don't have a page for that!
                throw new PageNotFoundException($page);
            }

            $data['title'] = ucfirst($page); // Capitalize the first letter

            return view('templates/header', $data)
                . view('pages/' . $page)
                . view('templates/footer');
        }
    }
    ```
### Halaman Statis (News Section)
#### Buat database untuk Digunakan
Kita perlu membuat database **ci4tutorial** yang dapat digunakan dan kemudian mengkonfigurasi CodeIgniter untuk menggunakannya.

Jalankan perintah SQL di bawah ini (menggunakan MySQL)
```
CREATE TABLE news (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(128) NOT NULL,
    slug VARCHAR(128) NOT NULL,
    body TEXT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE slug (slug)
);
```
Lakukan insert data pada table news dengan memasukan perintah pada SQL nya:
```
INSERT INTO news VALUES
(1,'Elvis sighted','elvis-sighted','Elvis was sighted at the Podunk internet cafe. It looked like he was writing a CodeIgniter app.'),
(2,'Say it isn\'t so!','say-it-isnt-so','Scientists conclude that some programmers have a sense of humor.'),
(3,'Caffeination, Yes!','caffeination-yes','World\'s largest coffee shop open onsite nested coffee shop for staff only.');
```

#### Connect dengan Database
File konfigurasi lokal, **.env** , yang dibuat saat menginstal CodeIgniter, harus memiliki pengaturan properti database. Pastikan telah mengkonfigurasikannya dengan benar.
```
database.default.hostname = localhost
database.default.database = ci4tutorial
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

#### Membuat NewsModel
Buka direktori **app/Models** dan buat file baru dengan nama **NewsModel.php** lalu tambahkan baris kode berikut:
```
<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
}
```

#### Menambahkan method getNews()
Tambahkan baris kode berikut di dalam NewsModel.php.
```
public function getNews($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
```
#### Menambahkan Routes
Tambahkan baris kode pada file **app/Config/Routes.php**
```
<?php

// ...

use App\Controllers\News; // Add this line
use App\Controllers\Pages;

$routes->get('news', [News::class, 'index']);           // Add this line
$routes->get('news/(:segment)', [News::class, 'show']); // Add this line

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
```

#### Buat Controller News
Buat Controller baru di **app/Controllers/News.php**.
```
<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews();
    }

    public function show($slug = null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($slug);
    }
}
```

#### Melengkapi method index()
Hal berikutnya yang harus dilakukan adalah meneruskan data ini ke tampilan. Lengkapi method index() pada class News menjadi seperti ini:
```
<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data = [
            'news'  => $model->getNews(),
            'title' => 'News archive',
        ];

        return view('templates/header', $data)
            . view('news/index')
            . view('templates/footer');
    }

    // ...
}
```

#### Buat File news/index view
Buat **app/Views/news/index.php** dan tambahkan potongan baris kode ebrikut :
```
<h2><?= esc($title) ?></h2>

<?php if (! empty($news) && is_array($news)): ?>

    <?php foreach ($news as $news_item): ?>

        <h3><?= esc($news_item['title']) ?></h3>

        <div class="main">
            <?= esc($news_item['body']) ?>
        </div>
        <p><a href="/news/<?= esc($news_item['slug'], 'url') ?>">View article</a></p>

    <?php endforeach ?>

<?php else: ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

<?php endif ?>
```
#### Menambahkan method News::Show()
Kembali pada Controller New dan perbarui method `show` nya.
```
<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
    // ...

    public function show($slug = null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        return view('templates/header', $data)
            . view('news/view')
            . view('templates/footer');
    }
}
```
#### Membuat news/view view file
Letakkan kode berikut di file **app/Views/news/view.php**

### Buat Item Berita 
#### Mengaktifkan filter CSRF
Buka file **app/Config/Filters.php** dan perbarui $methods properti seperti berikut:
```
<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    // ...

    public $methods = [
        'post' => ['csrf'],
    ];

    // ...
}
```

#### Menambahkan routing
Tambahkan aturan Perutean (Routing) ke dalam file **app/Config/Routes.php**
```
<?php

// ...

use App\Controllers\News;
use App\Controllers\Pages;

$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']); // Add this line
$routes->post('news', [News::class, 'create']); // Add this line
$routes->get('news/(:segment)', [News::class, 'show']);

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
```

#### Membuat Form news/create
Untuk emmasukkan data ke dalam database, kita perlu membuat formulir dimana form tersebut dapat memasukkan informasi yang disimpan. 

Buat tampilan baru di **app/Views/news/create.php**.
Tambahkan kode berikut:
```
<h2><?= esc($title) ?></h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="/news" method="post">
    <?= csrf_field() ?>

    <label for="title">Title</label>
    <input type="input" name="title" value="<?= set_value('title') ?>">
    <br>

    <label for="body">Text</label>
    <textarea name="body" cols="45" rows="4"><?= set_value('body') ?></textarea>
    <br>

    <input type="submit" name="submit" value="Create news item">
</form>
```

#### Menambahkan News::new() untuk menampilkan form.
Kembali pada Controler News, lalu buatlah method untuk menampilkan form HTML yang telah dibuat.
```
<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
    // ...

    public function new()
    {
        helper('form');

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/create')
            . view('templates/footer');
    }
}
```
#### Tambahkan News::create() untuk membuat News Item

Kita akan melakukan tiga hal di sini:
- memeriksa apakah data yang dikirimkan lolos aturan validasi.
- menyimpan item berita ke database.
- mengembalikan halaman sukses.
Ikuti baris code berikut:
```
<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
    // ...

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['title', 'body']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return $this->new();
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        $model = model(NewsModel::class);

        $model->save([
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
        ]);

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/success')
            . view('templates/footer');
    }
}
```
#### Return Success Page
Buat tampilan di **app/Views/news/success.php** dan tulis pesan sukses.
```
<p>News item berhasil dibuat.</p>

```

#### Update model berita
Buka **app/Models/NewsModel.php** dan tambahkan kode berikut untuk melakukan pembaruan data.
```
<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    protected $allowedFields = ['title', 'slug', 'body'];
}
```
#### Membuat NewsItem 
Buka broser dan ketikkan URL **localhost:8080/news/new** isikan dengan beberapa news dan periksa apakah code tersebut berhasil.

##Ikhtisar codeigniter4
#### Direktori default
Instalasi baru memiliki lima direktori: **app/, public/, writable/, tests/dan vendor/atau system/**. Masing-masing direktori ini memiliki peran yang sangat spesifik untuk dimainkan.

#### App
Direktori app merupakan tempat semua kode aplikasi berada. Direktori ini hadir dengan struktur direktori default yang berfungsi dengan baik untuk banyak aplikasi.
```
app/
    Config/        
    Controllers/    
    Database/       
    Filters/        
    Helpers/      
    Language/     
    Libraries/   
    Models/    
    ThirdParty/    
    Views/   
```
#### System 
Direktori ini menyimpan file-file yang membentuk kerangka itu sendiri. 

#### Public 
Folder publik menampung bagian aplikasi web yang dapat diakses browser, mencegah akses langsung ke kode sumber. 

#### Writable 
Direktori ini menampung semua direktori yang mungkin perlu ditulisi selama masa pakai aplikasi. Ini termasuk direktori untuk menyimpan file cache, log, dan unggahan apa pun yang mungkin dikirim pengguna.

#### Test 
Direktori ini disiapkan untuk menyimpan file pengujian.

#### Vendor 
Direktori vendor berisi file yang digunakan framework.

### Model, View, Controller
#### Apa itu MVC?
Model, View, Controller atau MVC merupakan pola arsitektur dalam membuat sebuah aplikasi dengan cara memisahkan code menjadi 3 bagian yang terdiri dari :
- Model     
    Bagian yang bertugas untuk menyiapkan, mengatur, memanipulasi, dan mengorganisasikan data yang ada di database.

- View      
    Bagian yang bertugas untuk menampilkan informasi dalam bentuk Graphical User Interface (GUI).

- Controller       
    Bagian yang bertugas untuk menghubungkan serta mengatur model dan view agar dapat saling terhubung.
#### Alur Kerja MVC
Berikut alur kerja MVC  
1.  View meminta data untuk ditampilkan dalam bentuk grafis
2. Request tersebut diterima oleh controller dan diteruskan ke model untuk diproses
3. Model akan mencari dan mengolah permintaan data dalam database
4. Setelah data diolah model akan mengirimkan pada controller untuk ditampilkan pada view
5. Controller akan mengambil data hasil pengolahan dan mengaturnya di bagian view untuk ditampilkan pada user

## Membangun Respons
### Views
Views tidak pernah dipanggil secara langsung, Views harus dimuat oleh Controller atau Routes view

#### Membuat View
Buat file bernama **blog_view.php** pada direktori **app/Views** dan letakkan di dalamnya.
```
<html>
    <head>
        <title>My Blog</title>
    </head>
    <body>
        <h1>Welcome to my Blog!</h1>
    </body>
</html>
```
#### Menampilkan View
Buat file bernama **Blog.php** di direktori **app/Controllers**, letakkan baris kode berikut didalamnya.
```
<?php

namespace App\Controllers;

class Blog extends BaseController
{
    public function index()
    {
        return view('blog_view');
    }
}
```
Buka file routes yang terletak di **app/Config/Routes.php** dan tambahkan code berikut:

```
use App\Controllers\Blog;

$routes->get('blog', [Blog::class, 'index']);
```

Untuk mengunjungi URL maka masukkan URL localhost:8080/blog

## Helpers
Helper adalah kumpulan fungsi prosedural yang berguna.

Untuk mmuat file helper cukup sederhana hanya menggunakan method berikut 
```
<?php
helper('name');
```

### Helper date
File Helper date berisi fungsi yang membantu dalam bekerja dengan tanggal. Helper ini dibuat dengan baris kode berikut:
```
<?php

helper('date');
```

### Helper number
File Number Helper berisi fungsi yang membantu Anda bekerja dengan data numerik. Helper ini dimuat pada baris kode berikut :
```
<?php

helper('number');
```

#### Menerapkan Helper Date dan Helper Number
Buat file bernama **test_view.php** di direktori **app/Views**, letakkan baris kode berikut didalamnya.
```
<?php 
helper('number');
helper('date');

//number to size
echo "ini adalah Helper number : ";
echo number_to_size(456); // Returns 456 Bytes
echo number_to_size(4567); // Returns 4.5 KB
echo number_to_size(3456789); // Returns 3.3 MB
echo number_to_size(12345678912345); // Returns 1.8 GB
echo number_to_size(123456789123456789); // Returns 11,228.3 TB

//number to currency
?>
<br>
<?php
echo number_to_currency(1234.56, 'USD', 'en_US', 2);  // Returns $1,234.56
echo number_to_currency(1234.56, 'EUR', 'de_DE', 2);  // Returns 1.234,56 €
echo number_to_currency(1234.56, 'GBP', 'en_GB', 2);  // Returns £1,234.56
echo number_to_currency(1234.56, 'YEN', 'ja_JP', 2);  // Returns YEN 1,234.56

?>
<br>
<?php
echo "ini adalah helper Date : ";
echo date('Y-M-d H:i:s', now('Asia/Jakarta'));
```

Buat Controller dengan nama file **Test.php** pada direktori app/Controllers, letakkan baris kode betikut didalamnya.
```
<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index(): string
    {
        return view('test_view');
    }
}

```

Lakukan perutean pada **app/Config/Routes.php** denganmenambahkan kode berikut:
```
use App\Controllers\Test;

//..

//routes untuk Test Helper
$routes->get('test', [Test::class,'index']);
```
Untuk melakukan pengakseskan maka ketikkan URL **http://localhost:8080/test**
