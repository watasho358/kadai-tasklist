@extends('layouts.app')

@section('content')

    <h1>id: {{ $task->id }} のタスク編集ページ</h1>

<div class="row">
    <div class="col-xs-12">
    <div class="col-sm-8">
    <div class="col-md-8">
    <div class="col-lg-6">
        
    {!! Form::model($task, ['route' => ['tasks.update', $task->id], 'method' => 'put']) !!}

        <div class="form-group">
　　　　{!! Form::label('status', 'ステータス:') !!}
        {!! Form::text('status') !!}
        </div>
        
        <div class="form-group">
        {!! Form::label('content', 'タスク:') !!}
        {!! Form::text('content') !!}
        </div>
        
        {!! Form::submit('更新', ['class' => 'btn btn-default']) !!}

    {!! Form::close() !!}
</div>
    </div>
    </div>
    </div>
    </div>
@endsection