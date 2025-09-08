<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('id')->get();
        return view('contact.create', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $data = $request->validated();
        session(['contact' => $data]);
        return view('contact.confirm', $data + ['category' => Category::find($data['category_id'])]);
    }

    public function store(Request $request)
    {
        $data = session('contact');
        abort_unless($data, 419);
        Contact::create($data);
        $request->session()->forget('contact');
        return redirect()->route('contact.thanks');
    }

    public function thanks()
    {
        return view('contact.thanks');
    }
}
