@extends('layouts.print')

@section('title', trans_choice('Statement', 1) . ' ' . $data['account']->name)

@include('bank-statement::components.template')