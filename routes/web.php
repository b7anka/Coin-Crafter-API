<?php

Route::get('/', 'IndexController@indexNoLanguageDefined');
Route::get('/{lang}', 'IndexController@index');
Route::get('/support/{lang}', 'ContactController@showContactUs');
Route::get('/privacy/{lang}', 'PrivacyController@showPrivacy');

Route::post('/support/{lang}', 'ContactController@sendMessage');
