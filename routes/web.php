<?php

Route::get('/', "BaseController@index");
Route::get('/change-country/{id}', "BaseController@changeCountry");
Route::get('/logout', "Profile@logout");
Route::get('/post-ad', "BaseController@ads");
Route::post('/post-ad', "BaseController@adsPosts");
Route::get('/ad-success-message', "BaseController@adSuccessMessage");
Route::get('/search', "BaseController@search");
Route::get('/about-us', "BaseController@aboutUs");
Route::get('/edit-ads/{id}', "BaseController@editAds");
Route::post('/edit-ads/{id}', "BaseController@updateAds");



################## Dynamic Url ######################
Route::get('/canada/{slug1}', 'DynamicController@country');
Route::get('/usa/{slug1}', 'DynamicController@country');
Route::get('/category/{slug1}/{slug2}', 'DynamicController@category');
Route::get('/city/{slug1}/{slug2}', 'DynamicController@city');
Route::get('/province/{slug1}/{slug2}', 'DynamicController@provinceState');
Route::get('/state/{slug1}/{slug2}', 'DynamicController@provinceState');
Route::get('/classified-ad/{slug1}/{slug2}', 'DynamicController@details');
Route::get('/email-user/{id}', "DynamicController@emailUser");
Route::post('/email-user/{id}', "DynamicController@emailUserConfirm");
Route::get('/new-item', "DynamicController@newItem");
Route::get('/used-item', "DynamicController@usedItem");
Route::get('/free-item', "DynamicController@freeItem");
Route::get('/seller/{id}', "DynamicController@sellerList");


################## Customer Profile ######################
Route::get('/dashboard', "Profile@index");
Route::get('/edit-profile', "Profile@editProfile");
Route::post('/edit-profile', "Profile@updateProfile");
Route::get('/myads/{id}', "Profile@myads");
Route::post('/myads/{id}', "Profile@myadsPost");
Route::get('/active-ads', "Profile@activeAds");
Route::get('/sold-ads', "Profile@soldAds");
Route::get('/expired-ads', "Profile@expiredAds");
Route::get('/hold-ads', "Profile@holdAds");
Route::get('/delete-ads/{id}', "Profile@deleteAds");


################## Login/Register ######################
Route::get('/login', "LoginController@loginAccount");
Route::post('/login', "LoginController@loginAccountCheck");
Route::get('/create-account', "LoginController@createAccount");
Route::post('/create-account', "LoginController@createAccountCheck");
Route::get('/forget-password', "LoginController@forgetPassword");
Route::post('/forget-password', "LoginController@forgetPasswordCheck");
Route::get('/password-recovery', "LoginController@passwordRecovery");
Route::get('/account-verification', "LoginController@accountVerification");
Route::get('/registration-message', "LoginController@registrationMessage");

################## Dropzone ######################

Route::post('/profile-picture-delete', "ImageUpload@profilePictureDelete");

################## Facebook Login ######################
Route::get('/login/facebook', 'LoginController@redirectToProvider');
Route::get('/login/facebook/callback', 'LoginController@handleProviderCallback');

################## Admin ######################

Route::get('/admin-state', "StateController@index");
Route::get('/admin-state/create', "StateController@create");
Route::post('/admin-state', "StateController@store");
Route::get('/admin-state/edit/{id}', "StateController@edit");
Route::post('/admin-state/edit', "StateController@update");
Route::get('/admin-state/delete/{id}', "StateController@delete");

Route::get('/admin-city', "CityController@index");
Route::get('/admin-city/create', "CityController@create");
Route::post('/admin-city', "CityController@store");
Route::get('/admin-city/edit/{id}', "CityController@edit");
Route::post('/admin-city/edit', "CityController@update");
Route::get('/admin-city/delete/{id}', "CityController@delete");

Route::get('/admin-category', "CategoryController@index");
Route::get('/admin-category/create', "CategoryController@create");
Route::post('/admin-category', "CategoryController@store");
Route::get('/admin-category/edit/{id}', "CategoryController@edit");
Route::post('/admin-category/edit', "CategoryController@update");

Route::get('/admin-about', "AdminController@about");
Route::post('/admin-about', "AdminController@aboutPost");
Route::get('/admin-home', "AdminController@home");
Route::post('/admin-home', "AdminController@homePost");
Route::get('/header-image', "AdminController@headerImg");
Route::post('/header-image', "AdminController@headerImgPost");


############ Paypal ##########################
Route::get('/purchase-ads', 'PaymentController@index');
Route::post('paypal', 'PaymentController@payWithpaypal');
Route::get('/status', 'PaymentController@getPaymentStatus');