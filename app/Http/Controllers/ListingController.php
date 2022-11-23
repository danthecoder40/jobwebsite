<?php
namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{

	//show all listings
    public function index(Request $request){
//dd(request('tag'));
      // dd(Listing::latest()->filter(request(['tag','search']))->get());
  return view('listings.index', [

   'heading' => 'Latest Listings',
    'listings'=>Listing::latest()->filter(request(['tag','search']))->paginate(6)
//simplepaginate(2) //for next and previous
    ]); 

    }


//show single listing
    public function show(Listing $listing){

  return view('listings.show',[

 	'listing'=>$listing

 ]

 );

    }
    //show create form
    public function create(){
      return view('listings.create');

    }

    //store listing Data

    public function store(Request $request){
      //dd($request->file('logo')->store());
        $formFields =$request->validate(
    [
   

    'title'=>'required',
    'company'=>['required',Rule::unique('listings','company')],

     'location'=>'required',
      'website'=>'required',
      'email'=>['required','email'],
      'tags'=>'required',
      'description'=>'required'

    ]);


if($request->hasFile('logo')){

$formFields['logo'] = $request->file('logo')->store('logos','public');


}

$formFields['user_id']= auth()->id();

Listing::create($formFields);
 
// Session::flash('message','Listing Created');

return redirect('/')->with('message','Listing created successfully!');
    }



    //Show Edit Form

    public function edit(Listing $listing){

     //dd($listing->description);
    return view('listings.edit',['listing'=>$listing]);



 




    }

  
    //Update listing Data

    public function update(Request $request,Listing $listing){
      //dd($request->file('logo')->store());

      //Make sure logged in user is owner

        if($listing->user_id != auth()->id()){

       abort(403,'Unauthorized Action');

        }




        $formFields =$request->validate(
    [
   

    'title'=>'required',
    'company'=>['required'],

     'location'=>'required',
      'website'=>'required',
      'email'=>['required','email'],
      'tags'=>'required',
      'description'=>'required'

    ]);


if($request->hasFile('logo')){

$formFields['logo'] = $request->file('logo')->store('logos','public');


}



$listing->update($formFields);
 
// Session::flash('message','Listing Created');

return back()->with('message','Listing updated successfully!');
    }

//Delete listing

    public function destroy(Listing $listing){

     //Make sure logged in user is owner

        if($listing->user_id != auth()->id()){

       abort(403,'Unauthorized Action');

        }



     $listing->delete();
     return redirect('/')->with('message','Listing Deleted successfully');

    }


//manage listings

    public function manage(){

//auth()->user()->listings->get(), gives us the login user
   return view('listings.manage',['listings'=>auth()->user()->listings()->get()]);

    }


}
