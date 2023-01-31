<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Listing;


class ListingController extends Controller
{
    //Show all listings
    public function index(){
        return view('listings.index',[
            'listing' => Listing::latest()->filter(request(['tag','search']))->paginate(4) //simplePaginate(4)
         ]);
    }

    //show single listing
    public function show(Listing $listing){
        return view('listings.show',[
            'listing' => $listing
            ]);
    }

    //show create form
    public function create(Listing $listing){
        return view('listings.create');
    }

    //Store Formfields to database
    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'company' => 'required', //['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $formFields['user_id'] = auth()->id(); 
        Listing::create($formFields);
        //session()->flash('message', 'Gig created');
        return redirect('/')->with('message', 'Gig created');
    }

    //show Edit form
    public function edit(Listing $listing){
        return view('listings.edit', ['listing'=>$listing]);
    }

    //Update Formfields in database
    public function update(Request $request, Listing $listing){
        //Make sure logged in user is the owner.
        if ($listing->user_id != auth()->id()) {
            abort('403','Unauthorized Action');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'company' => 'required', //['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);
        //session()->flash('message', 'Gig created');
        return back()->with('message', 'Listing updated');
    }

    //Delete record from database
    public function destroy(Listing $listing){
        //Make sure logged in user is the owner.
        if ($listing->user_id != auth()->id()) {
            abort('403','Unauthorized Action');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Gig deleted');
    }

    //show single listing
    public function manage(){
        return view('listings.manage',[
            'listings' => auth()->user()->listings()->get()
        ]);
    }
} 
