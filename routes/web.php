<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;

use App\Models\Listing;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//common Resource Routes

// index- show all listings

//show-show single listing

//create-show form to create new listing

//store- store new listing

//edit-show form to edit listing

//update-update listing

//destroy- delete listing


//All Listings

Route::get('/', [ListingController::class,'index']);




//show Ceate Form

Route::get('/listings/create', [ListingController::class,'create'])->middleware('auth');


//Store Listing Data

Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');




//Show edit Form
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');




//Update Listing
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');



//Delete Listing
Route::delete('/listings/{listing}',[ListingController::class,'destroy'])->middleware('auth');



//Manage Listings
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');



//Single LIsting

Route::get('/listings/{listing}', [ListingController::class,'show']);




//Show Register/Create Form
Route::get('/register',[UserController::class,'create'])->middleware('guest');




//Create New User

Route::get('/users',[UserController::class,'store']);



//log user Out

Route::post('/logout',[UserController::class,'logout'])->middleware('auth');


//show login form
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');


//log in User

Route::post('/users/authenticate',[UserController::class,'authenticate']);








//single listing
//Route::get('//listings/{listing}',[ListingController::class,'show']);

//{
	//$listing = Listing::find($id);


// if($listing){

// return view('//listing',[

// 	'listing'=>$listing

// ]


// );



// }else{

// 	abort('404');
// }


// return view('listing',[

//  	'listing'=>$listing

//  ]

//  );

// });