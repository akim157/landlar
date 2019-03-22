<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Validator;

class ServiceAddController extends Controller
{
    //
    public function execute(Request $request)
    {
        if($request->isMethod('post'))
        {
            $input = $request->except('_token');

            $rules = [
                'name'  =>  'required|max:100',
                'icon'  =>  'required|max:100',
                'text'  =>  'required'
            ];
            $messages = [
                'required'  =>  'Поле :attribute обязательно для ввода',
                'max'       =>  'Поле :attribute превысил лимит символов в :max'
            ];
            $validator = Validator::make($input, $rules, $messages);
            if($validator->fails())
            {
                return redirect()->route('service_add')->withErrors($validator)->withInput();
            }
            $services = new Service;
            $services->fill($input);
            if($services->save())
            {
                return redirect('admin')->with('status', 'Сервис сохранен');
            }
            return redirect()->route('service_add')->with('status', 'Ошибка')->withInput();
        }
        if(view()->exists('admin.services_add'))
        {
            $data = [
                'title' =>  'Добавить сервис'
            ];
            return view('admin.services_add', $data);
        }
        abort(404);
    }
}
