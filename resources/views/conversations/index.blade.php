@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="messagerie">
            <Messagerie :user="{{ Auth::user()->id }}"></Messagerie>
        </div>
    </div>
@endsection
