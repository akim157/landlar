<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Page;

class PagesAddController extends Controller
{
    //
    public function execute(Request $request)
    {
        if($request->isMethod('post'))
        {
            $input = $request->except('_token');
            $rules = [
                'name'      =>  'required|max:255',
                'alias'     =>  'required|max:255|unique:pages',
                'text'      =>  'required'
            ];
            $messages = [
                'required'      =>  'Поле :attribute обязательно к заполнению',
                'unique'        =>  'Поле :attribute должно быть уникальным',
                'max'           =>  'Поле :attribute превышен количество символов в :max раз'
            ];
            $validator = Validator::make($input, $rules, $messages);
            if($validator->fails())
            {
                return redirect()->route('pages_add')->withErrors($validator)->withInput();
            }
            if($request->hasFile('images'))
            {
                $file = $request->file('images'); //UploasdedFile - path\symfony\http-foundation\File\UploadedFile
                $input['images'] = $file->getClientOriginalName();
//              $path = $file->storeAs(public_path().'/assets/img/', $input['images']);
                $file->move(public_path().'/assets/img', $input['images']);
                $page = new Page();
                //$page->unguard(); //разрешает на заполнения
                $page->fill($input);
                if($page->save())
                {
                    return redirect()->route('admin')->with('status', 'Страница добавлена');
                }
                return redirect()->route('pages_add')->with('status', 'Страница не добавлена');
            }
        }
        if(view()->exists('admin.pages_add'))
        {
            $data = ['title' => 'Добавить страницу'];
            return view('admin.pages_add', $data);
        }
        abort(404);
    }
}
