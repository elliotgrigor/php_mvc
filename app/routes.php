<?php

Router::get('/',                 ['PageController', 'index'],    'home');
Router::get('/about',            ['PageController', 'about'],    'about');
Router::get('/products',         ['PageController', 'products'], 'products');
Router::get('/products/:id|int', ['PageController', 'products']);