<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Validator;
use DB;

class ServiceEditController extends Controller
{
    //
    public function execute(Service $service, Request $request)
    {
        if($request->isMethod('delete'))
        {
            $service->delete();
            return redirect('admin')->with('status', 'Сервис удален');
        }
        if($request->isMethod('post'))
        {
            $input = $request->except('_token');

            $rules = [
                'name'  =>  'required|max:100',
                'icon'  =>  'required|max:100',
                'text'  =>  'required'
            ];
            $messages = [
                'required' => 'Поле :attribute обязательно для ввода',
                'max'       =>  'В поле :attribute превышен порог символов :max'
            ];
            $validator = Validator::make($input, $rules, $messages);
            if($validator->fails())
            {
                return redirect()->route('service_edit')->withErrors($validator)->withInput();
            }
            $res = DB::table('services')->where('id',$input['id'])->update([
                'name'  => $input['name'],
                'icon'  =>  $input['icon'],
                'text'  =>  $input['text']
            ]);
            if($res)
            {
                return redirect('admin')->with('status', 'Сервис '.$input['name'].' отредактирован');
            }
            return redirect()->route('service_edit')->with('status', 'Ошибка')->withInput();
        }
        if(view()->exists('admin.services_edit'))
        {
            $input = $service->toArray();

            $data = [
                'title' =>  'Редактирование сервиса - '. $input['name'],
                'data'  =>  $input
            ];
            return view('admin.services_edit', $data);
        }
        abort(404);
    }
}
