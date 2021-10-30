<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //URLの変数部分を{Folder}として$folderで受け取っている
    public function index(Folder $folder)
    {        
        
        //ユーザーのフォルダを取得する
        $folders = Auth::user()->folders()->get();


        //選ばれたフォルダに紐づくタスクを取得する(hasManyによりこの記述可能)
        $tasks = $folder->tasks()->get();
        
        //タスク一覧ページにルーティング
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);

        
    }

    //タスク作成ページの表示
    public function showCreateForm(Folder $folder)
    {
        return view('tasks/create', [
            'folder_id' => $folder->id,
        ]);
    }

    //タスク作成メソッド CreateTaskクラスを受け入れる
    public function create(Folder $folder, CreateTask $request)
    {
        //$current_folder = Folder::find($id);

        //タスクモデルのインスタンスを作成
        $task = new Task();
        //タスクタイトルに入力値を代入
        $task->title = $request->title;
        //タスク期限日に入力値を代入
        $task->due_date = $request->due_date;
        //インスタンスの情報をデータベースに保存
        $folder->tasks()->save($task);

        //タスク一覧ページにリダイレクト
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }

    
    //編集対象のタスクデータを取得し、タスク編集ページの表示
    public function showEditForm(Folder $folder, Task $task)
    {
        //$task = Task::find($task_id);

        $this->checkRelation($folder, $task);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    
    //編集メソッド
    public function edit(Folder $folder, Task $task, EditTask $request)
    {

        $this->checkRelation($folder, $task);

        //  リクエストされたIDでタスクデータを取得
        //$task = Task::find($task_id);

        //タスクタイトルに入力値を代入
        $task->title = $request->title;
        //タスク状態に入力値を代入
        $task->status = $request->status;
        //タスク期限日に入力値を代入
        $task->due_date = $request->due_date;
        //データベースに保存
        $task->save();

        //タスク一覧ページにリダイレクト
        return redirect()->route('tasks.index', [
            'folder' => $task->folder_id,
        ]);
    }

    public function showDeleteForm(Folder $folder,Task $task)
    {
        $this->checkRelation($folder, $task);

        return view('tasks/delete', [
            'task' => $task,
        ]);
    }
    //削除メソッド
    public function delete(Folder $folder,Task $task)
    {

        //タスク削除処理
        $task->delete();

        //タスク一覧ページにリダイレクト
        return redirect()->route('tasks.index', [
            'folder' => $folder->id,
        ]);
    }


    //リレーションが存在しない場合、404を返す
    private function checkRelation(Folder $folder, Task $task)
    {
        if ($folder->id !== $task->folder_id) {
            abort(404);
        }
    }

}
