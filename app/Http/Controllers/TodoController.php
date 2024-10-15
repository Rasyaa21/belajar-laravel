<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(){
        $getAllData = Todo::all();
        return view ("welcome" , ['getAllData' => $getAllData]);
    }

    public function insert(Request $request){
        $todo = new Todo();
        if($request->title && $request->description){
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->save();
            notify()->success('data berhasil ditambahkan');
            return redirect('/home');
        }
        notify()->error('tolong lengkapi semua kolom');
        return redirect('/home');
    }

    public function delete(Todo $todo){
        $todo->delete();
        notify()->success('data berhasil dihapus');
        return redirect('/home');
    }

    public function update(Request $request, $todo) {
        $todo = Todo::findOrFail($todo);
        if ($request->title && $request->description) {
            $todo->title = $request->input('title');
            $todo->description = $request->input('description');
            $todo->save();
            notify()->success('Data berhasil diupdate');
            return redirect('/home');
        }
        notify()->error('Tolong lengkapi semua kolom');
        return redirect('/home');
    }

    public function checklist(Todo $todo){
        $todo->update(['status' => 'done']);
        if($todo->status === 'done'){
            notify()->success('Status berhasil diupdate');
            return redirect('/home');
        }
        return redirect('/home');
    }
}
