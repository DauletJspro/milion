@extends('layouts.dashboard')
@section('title')
    Новости
@endsection
@section('dashboard-content')
    <div class="card" style="padding: 10px;">
        @role('admin|moderator')
        <div class="card-header">
            <a href="{{route('news.create')}}" class="btn btn-success text-white">
                <i class="fa fa-newspaper"></i> &nbsp; Добавить новость
            </a>
        </div>
        @endrole
        <div class="card-body">
            <div class="row">
                @foreach($news as  $item)
                    <div class="card ml-4" style="width: 18rem;height: 24rem;">
                        <img class="card-img-top"
                             style="
                                 height: 55%;
                                 background-position: center;
                                 background-size: contain;
                                 background-image: url('{{asset('files/images/' . $item->image)}}');
                                 background-repeat: no-repeat;
                                 ">
                        <div class="card-body">
                            <h5 class="card-title">{{$item->name}}</h5>
                            <p class="card-text">{{$item->title}}</p>
                            @role('admin|moderator')
                            <div class="btn-group">
                                <a href="{{route('news.edit', ['news' => $item->id])}}" class="btn btn-primary">Редактировать</a>
                                <form action="{{route('news.destroy',['news' => $item->id])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 btn btn-danger">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                            @endrole
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
