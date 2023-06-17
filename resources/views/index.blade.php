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
            @foreach($admins as $admin)
            <tr class="bg-white border-b ">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                    {{$admin->username}}
                </th>
                <td class="px-6 py-4">
                    {{$admin->last_login}}
                </td>
                <td class="px-6 py-4">
                    {{$admin->created_at}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection