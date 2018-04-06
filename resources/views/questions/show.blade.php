@extends('layouts.app')
<style>
    .pull-right{
        float: right;
        margin-top: 10px;
    }
    #edui1{
        height: 100%;
        border: 0;
    }
</style>
@section('content')
@include('vendor.ueditor.assets')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $question->title }}
                    @foreach($question->topics as $topic)
                    <a class="topic" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                    @endforeach
                </div>

                <div class="card-body">
                    {!! $question->body !!}
                </div>
                <div class="actions">
                    @if(Auth::check() && Auth::user()->owns($question))
                        <span class="edit"><a href="/questions/{{ $question->id }}/edit">编辑</a></span>
                        <form action="/questions/{{ $question->id }}" method="POST" class="delete-form">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="button is-naked delete-button">删除</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header question-follow">
                    <h2>{{ $question->followers_count }}</h2>   
                    <span>关注问题者</span>
                </div>
                <div class="card-body" style="justify-content: space-between;display: flex;">
                    <question-follow-button question="{{$question->id}}"></question-follow-button>
                    <a href="#editor" class="btn btn-primary">撰写答案</a>
                </div>
            </div>
        </div>
        <div class="col-md-8" style="margin-top:20px">
            <div class="card">
                <div class="card-header">
                   {{ $question->answers_count }} 个答案
                </div>
                <div class="card-body">
                    @foreach($question->answers as $answer)
                        <div class="media" style="margin-bottom:1.2em;justify-content: center;">
                            <div class="media-left">
                                    <img width="48" src="{{ $answer->user->avatar }}" alt="{{ $answer->user->name }}">
                                    <user-vote-button answer="{{$answer->id}}" count="{{$answer->votes_count}}"></user-vote-button>
                            </div>
                            <div class="media-body" style="margin-left: 10px;">
                                <h5 class="media-heading">
                                    <a href="/user/{{ $answer->user->name }}">{{ $answer->user->name }}</a>
                                </h5>
                                {!! $answer->body !!}
                            </div>
                        </div>
                    @endforeach
                    @if(Auth::check())
                        <form action="/questions/{{$question->id}}/answer" method="post">
                            {!! csrf_field() !!}
                            <!-- 编辑器容器 -->
                            <label for="body">描述</label>
                            <div class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" style="padding:0em;width: 100%;height: 160;">
                                <script id="container" name="body" type="text/plain">
                                    {!! old('body') !!} 
                                </script>
                            </div>
                            @if ($errors->has('body'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                            @endif
                            <button class="btn btn-success pull-right" type="submit">提交答案</button>
                        </form>
                    @else
                        <a href="/login" class="btn btn-success btn-block">登录提交答案</a>
                    @endif
                </div>
            
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header question-follow">
                    <h5>关于作者</h5>   
                </div>
                <div class="card-body">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img width="36" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="">{{ $question->user->name }}</a>
                            </h4>
                        </div>
                    </div>
                    <div class="user-statics" >
                        <div class="statics-item text-center">
                            <div class="statics-text">问题</div>
                            <div class="statics-count">{{ $question->user->questions_count }}</div>
                        </div>
                        <div class="statics-item text-center">
                            <div class="statics-text">回答</div>
                            <div class="statics-count">{{ $question->user->answers_count }}</div>
                        </div>
                        <div class="statics-item text-center">
                            <div class="statics-text">关注者</div>
                            <div class="statics-count">{{ $question->user->followers_count }}</div>
                        </div>  
                    </div>
                        <user-follow-button user="{{$question->user_id}}"></user-follow-button>
                        <send-message user="{{$question->user_id}}"></send-message>    
                </div>
            </div>
        </div>
    </div>
</div>

    @section('js')
        <script type="text/javascript">
            var ue = UE.getEditor('container', {
                toolbars: [
                        ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
                    ],
                elementPathEnabled: false,
                enableContextMenu: false,
                autoClearEmptyNode:true,
                wordCount:false,
                imagePopup:false,
                autotypeset:{ indent: true,imageBlockLine: 'center' }
            });
            ue.ready(function() {
                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
            });
        </script>
    @endsection
@endsection
