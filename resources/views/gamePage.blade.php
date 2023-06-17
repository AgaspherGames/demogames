@extends('layout')
@section('content')
<table class="w-full text-sm text-left text-gray-500 ">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
        <tr>
            <th scope="col" class="px-6 py-3">
                Title
            </th>
            <th scope="col" class="px-6 py-3">
                Description
            </th>
            <th scope="col" class="px-6 py-3">
                Thumbnail
            </th>
            <th scope="col" class="px-6 py-3">
                Author
            </th>
            <th scope="col" class="px-6 py-3">
                Versions
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg-white border-b ">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                {{$game->title}} @isset($game->deleted_at)(deleted) @endisset
            </th>
            <td class="px-6 py-4">
                {{$game->description}}
            </td>
            <td class="px-6 py-4">
                {{$game->thumbnail}}
            </td>
            <td class="px-6 py-4">
                {{$game->user->username}}
            </td>
            <td class="px-6 py-4">
                @foreach($game->game_versions->reverse() as $version)
                <b>{{$version->id}}:</b> {{$version->version}} <br>
                @endforeach
            </td>
        </tr>
    </tbody>

</table>
<form action="{{route('game',$game->slug)}}" class="mt-4" method="post">
    @csrf
    @method("DELETE")
    <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 ">DELETE!!!</button>
</form>
<form action="{{route('game.score.game',$game->slug)}}" class="mt-4" method="post">
    @csrf
    @method("DELETE")
    <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 ">DELETE ALL SCORES!!!</button>
</form>
@foreach($game->game_versions as $version)
<h2 class="text-xl">Scores at version: {{$version->id}}</h2> <br>
@foreach($version->game_scores as $score)
<div class="flex items-center gap-2">
    <p>
    <details class="relative">
        <summary>
            {{$score->user->username}}
        </summary>
        <div class="absolute p-8 bg-white z-10">
        <form action="{{route('game.score.game.user',[$game->slug, $score->user->id])}}" class="" method="post">
            @csrf
            @method("DELETE")
            <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-2 py-1 ">DELETE USER SCORES</button>
        </form>
        </div>
    </details>: {{$score->score}}</p>
    <form action="{{route('game.score',$score->id)}}" class="" method="post">
        @csrf
        @method("DELETE")
        <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-2 py-1 ">DELETE!!!</button>
    </form>
</div>
@endforeach
@endforeach

@endsection