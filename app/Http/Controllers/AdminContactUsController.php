<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Validation\Rule;


class AdminContactUsController extends Controller
{
    

    public function index(){
        $contacts=Contact::where('status', '!=', 'closed')->orderBy('created_at', 'asc')->paginate(15);
        return view('admin.contact_us.index', ['contacts'=>$contacts, 'page'=>'Messages from Contact Us page']);
    }

    public function closed(){
        $contacts=Contact::where('status', 'closed')->orderBy('created_at', 'asc')->paginate(15);
        return view('admin.contact_us.index', ['contacts'=>$contacts, 'page'=>'Closed messages from Contact Us page']);
    }

    public function edit($id){
        $contact=Contact::findOrFail($id);
        return view('admin.contact_us.edit', ['contact'=>$contact, 'page'=>'Edit']);

    }

    public function update(Request $request, $id){
        $contact=Contact::findOrFail($id);

        $this->validate($request, [
            'status'=>['required', Rule::in(['pending', 'email_sent', 'closed'])],
            'solution'=>['required', Rule::in(['pending', 'discarded', 'answered'])]
            
        ]);

        $contact->status=$request->status;
        $contact->solution=$request->solution;
        $contact->save();
        session()->flash('success', 'Updated successfully!');
        
        return redirect()->route('admin.contact.us.edit', ['id'=>$contact->id]);


    }
}

/*
p p / e p/ c d/ c a/
p d/ p a/e d/e a/ c p/
*/
