<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Validation\Rule;

class EditTask extends CreateTask
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = parent::rules();
        //Ruleクラスのinメソッドを使ってルールの文字列の作成
        $status_rule = Rule::in(array_keys(Task::STATUS));
        // -> 'in(1,2,3)'を出力する  

        return $rule + [
            //'status' => 'required|in(1, 2, 3)'と同義
            'status' => 'required|' . $status_rule,
        ];
    }

    //親クラスのCreateTaskのattributesメソッドの結果と合体した属性名リストを返却
    public function attributes()
    {
        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態',
        ];
    }

    //
    public function messages()
    {   
        //親クラスのメッセージメソッドにアクセス
        $messages = parent::messages();
        //Task::STATUS の各要素から label キーの値のみ取り出し
        $status_labels = array_map(function($item) {
            return $item['label'];
        }, Task::STATUS);
        //作成した配列に句読点をくっつける
        $status_labels = implode('、', $status_labels);
        //「状態 には 未着手、着手中、完了 のいずれかを指定してください。」というメッセージを返す
        return $messages + [
            'status.in' => ':attribute には ' . $status_labels. ' のいずれかを指定してください。',
        ];
    } 
}  



