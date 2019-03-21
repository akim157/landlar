<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Portfolio;
use Validator;

class PortfolioEditController extends Controller
{
    //
    public function execute(Portfolio $portfolio, Request $request)
    {
        if($request->isMethod('post'))
        {
            $input = $request->except('_token');
            $rules = [
                'name'      =>  'required|max:255',
                'filter'    =>  'required|max:100'
            ];
            $messages = [
                'required'  =>  'Поле :attribute обязательно для ввода',
                'max'       =>  'Превышено колиечство :max в поле :attribute'
            ];
            $validator = Validator::make($input, $rules, $messages);
            if($validator->fails())
            {
                return redirect()->route('portfolio_edit')->withErrors($validator)->withInput();
            }
            if($request->hasFile('images'))
            {
                $file = $request->file('images');
                $input['images'] = $file->getClientOriginalName();
                $file->move(public_path().'/assets/img', $input['images']);
            }
            else
            {
                $input['images'] = $input['old_images'];
            }
            unset($input['old_images']);
            $portfolio->fill($input);
            if($portfolio->update())
            {
                return redirect('admin')->with('status', 'Портфолио обнавлено');
            }
            return redirect('admin')->with('status', 'Ошибка');
        }
        if(view()->exists('admin.portfolios_edit'))
        {
            $old = $portfolio->toArray();
            $data = [
                'title' =>  'Редактирование портфолио - ' . $old['name'],
                'data'   =>  $old
            ];
            return view('admin.portfolios_edit', $data);
        }
        abort(404);
    }
}
