<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFolder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    //authorize メソッドはリクエストの内容に基づいた権限チェックのために使用される。今回はリクエストを受け付けるためtrue
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    //requiredで必須入力、max:20で最大文字20に指定
    public function rules()
    {
        return [
            'title' => 'required|max:20',
        ];
    }

    public function attributes()
    {   
        //エラーメッセージの'title'をフォルダ名に変更
        return [
            'title' => 'フォルダ名',
        ];
    }
}
