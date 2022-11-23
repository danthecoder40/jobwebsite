<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show register/create form

    public function create(){

   return view('users.register');


    }

//Create New user

    public function store(Request $request){

       $formFields = $request->validate([
          //min:3, means atlest three characters
      'name'=>['required','min:3'],
       'email'=>['required','email', Rule::unique('users','email')],
       'password'=>'required|confirmed|min:6'





       ]);


   //Hash Password

       $formFields['password']= bcrypt($formFields['password']);
    

       //Create User
       $user =User::create($formFields);

       //login

       auth()->login($user);

       return redirect('/')->with('message','User created and Logged in');

    }



    //Logout User

    public function logout(Request $request ){

     auth()->logout();


     
      $request->session()->invalidate();
      $request->session()->regenerateToken();

      //redirect back to the home page, with a message , you have been logged out


      return redirect('/')->with('message','You have been logged out!');




    }


//show login form

    public function login(){

    	return view('users.login');



    }

    //Authenticate User

    public function authenticate(Request $request){
        $formFields = $request->validate([
       'email'=>['required','email'],
       'password'=>'required'





       ]);

       if(auth()->attempt($formFields)){
         //regenerate the session id

       	$request->session()->regenerate();

       	return redirect('/')->with('message','You are now logged in!');


       }
        //if the attend above did not work

       return back()->withErrors(['email' =>'invalid Credentals'])->onlyInput('email');

    }

}
