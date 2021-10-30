<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{   
    //タスク作成ページの表示
    public function showCreateForm()
    {
        return view('folders/create');
    }
    //引数にインポートしたHttp\Request\CreateFolderクラスを受け入れる
    public function create(CreateFolder $request)
    {
        // フォルダモデルのインスタンスを作成する
        $folder = new Folder();
        // タイトルに入力値を代入する
        $folder->title = $request->title;
        // ユーザーに紐づけてインスタンスの状態をデータベースに書き込む
        Auth::user()->folders()->save($folder);
     
        //タスク一覧ページにリダイレクト処理
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }
}
