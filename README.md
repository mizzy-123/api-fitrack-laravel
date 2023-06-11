## Cara install

masuk ke folder yang ingin anda taruh semua file ini lewat terminal/command prompt
kemudian ketikkan command ini

$git clone https://github.com/mizzy-123/api-fitrack-laravel.git

masuk ke folder tempat semua file ini di taruh lewat terminal/command prompt
kemudiadn ketikkan command ini

$composer update

$cp .env.example .env

$php artisan key:generate

kemudian ubah didalam .env sesuai dengan database anda

## API Documentation

POST /user/login
Berhasil

{
"status" : true,
"user" : {
"name" : "xxxxxxx"
"email" : "xxxxxxx"
}
}

Gagal

{
"status" : false
}

GET /user/logout
Berhasil

{
"message" : "logout succesfull"
}

POST /user/register
Berhasil

{
"status" : true,
"message" : "Register Berhasil"
}

Gagal

{
"status" : false,
"message" : "Register Gagal"
}

POST /user/image/{email}
Berhasil

{
"status" : true,
"message" : "Gambar berhasil di upload"
}

Gagal

{
"status" : false,
"messsage" : "Gambar gagal di upload"
}

DELETE /user/image/{email}
Berhasil

{
"status" : true,
"messsage" : "Gambar berhasil dihapus"
}

Gagal

{
"status" : false,
"message" : "Gambar gagal dihapus"
}
