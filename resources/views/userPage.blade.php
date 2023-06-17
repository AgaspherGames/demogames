@extends('layout')
@section('content')
<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Username
                </th>
                <th scope="col" class="px-6 py-3">
                    Last Login
                </th>
                <th scope="col" class="px-6 py-3">
                    Register At
                </th>
            </tr>
        </thead>
        <tbody>

            <tr class="bg-white border-b ">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                    <a href="">
                        {{$user->username}}
                    </a>
                </th>
                <td class="px-6 py-4">
                    {{$user->last_login}}
                </td>
                <td class="px-6 py-4">
                    {{$user->created_at}}
                </td>
            </tr>
        </tbody>
    </table>

    <form class="flex flex-col gap-2" method="post" action="{{route('ban', $user->username)}}">
        @csrf
        <label for="countries" class="block  text-sm font-medium text-gray-900">Select Ban Reason</label>
        <select name="reason" id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="You have been blocked by an administrator">You have been blocked by an administrator</option>
            <option value="You have been blocked for spamming">You have been blocked for spamming</option>
            <option value="You have been blocked for cheating">You have been blocked for cheating</option>
        </select>
        <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 ">BAN!!!</button>
    </form>

</div>

@endsection