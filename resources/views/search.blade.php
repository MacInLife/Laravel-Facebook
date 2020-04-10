@extends('layouts.app')
@section('title')
Laravel Facebook - Recherche
@endsection

@section('style')
<!--Ici insérer votre style CSS propre à la page -->
@endsection
@section('content')
<!--Ici insérer votre contenu de recherche -->

@foreach($user as $users)
<th scope="row">1</th>
<td><a href="{{ url('/user').'/'.$users->id }}">show</a></td>
<td>{{$users->name}}</td>
<td>{{$users->city}}</td>
<td>{{$users->phone}}</td>
<td>{{$users->street}}</td>
<td>{{$users->national_id}}</td>
<td>{{$users->name}}</td>

</tr>
@endforeach

@endsection
