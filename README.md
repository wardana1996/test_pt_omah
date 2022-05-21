step by step 
1. silahkan buat database di phpmyadmin dengan nama "test_omah" (sesuaikan dengan env) <br>
2. silahkan ketik perintah diterminal "php artisan migrate" <br>
3. silahkan ketik perintah diterminal "php artisan db:seed" <br>
4. silahkan ketik perintah diterminam "php artisan serve" <br>

endpoint <br>
1. post / 127.0.0.1:8000/api/user/checkout <br>
2. post / 127.0.0.1:8000/api/user/checkout/detail <br>
3. post / 127.0.0.1:8000/api/user/checkout/detail_all <br>
4. get / 127.0.0.1:8000/api/seller/order <br>
5. post / 127.0.0.1:8000/api/seller/confirmed <br>
6. get / 127.0.0.1:8000/api/admin/order <br>
7. post / 127.0.0.1:8000/api/admin/nonactive <br>
8. post / 127.0.0.1:8000/api/admin/order/delete <br>

note : untuk method post sesuaikan dengan request yang ada di controller
