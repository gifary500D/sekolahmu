<?php

test('halaman publik dapat dibuka', function () {
    $this->get('/')->assertStatus(200);
    $this->get('/daftar')->assertStatus(200);
    $this->get('/cek-status')->assertStatus(200);
});
