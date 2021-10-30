@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="panel panel-default">
          <div class="panel-heading">本当に削除しますか？</div>
          <div class="panel-body">
            <form
                action="{{ route('tasks.delete', ['folder' => $task->folder_id, 'task' => $task->id]) }}"
                method="POST"
            >
              @csrf
              <div class="form-group">
                {{ $task->title }}
              </div>
              <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
              <div class="form-group">
                {{ $task->formatted_due_date }}
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">削除</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection
