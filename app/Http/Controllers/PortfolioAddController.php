<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portfolio;
use Validator;

class PortfolioAddController extends Controller
{
    //
    public function execute(Request $request)
    {
        if($request->isMethod('post'))
        {
            $input = $request->except('_token');
            $rules = [
                'name'      =>  'required|max:255',
                'filter'    =>  'required|max:255',
                'images'    =>  'required'
            ];
            $messages = [
                'required'  =>  'Поле :attribute должно быть заполнено',
                'max'       =>  'Поле :attribute превышает количество символ :max'
            ];
            $validator = Validator::make($input, $rules, $messages);
            if($validator->fails())
            {
                return redirect()->route('portfolio_add')->withErrors($validator)->withInput();
            }
            if($request->hasFile('images'))
            {
                $file = $request->file('images');
                $input['images'] = $file->getClientOriginalName();
                $file->move(public_path().'/assets/img', $input['images']);
                $portfolios = new Portfolio();
                $portfolios->fill($input);
                if($portfolios->save())
                {
                    return redirect('admin')->with('status', 'Портфолио добавлено');
                }
                return redirect('admin')->with('status', 'Портфолио не добавлно');
            }
            return redirect()->route('portfolio_add')->with('status', 'Ошибка сохранения')->withInput();
        }
        if(view()->exists('admin.portfolios_add'))
        {
            $data = ['title' => 'Добавить портфолио'];
            return view('admin.portfolios_add', $data);
        }
        abort(404);
    }
}
