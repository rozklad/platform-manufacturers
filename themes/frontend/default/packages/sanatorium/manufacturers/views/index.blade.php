@extends('layouts/default')

{{-- Page title --}}
@section('title')
@parent
{{{ $manufacturer->manufacturer_title }}}
@stop

{{-- Meta description --}}
@section('meta-description')
{{{ $manufacturer->manufacturer_title }}}
@stop

{{-- Page content --}}
@section('page')




  @if ( class_exists('Product') )

    <?php $i = 0; ?>
    <?php $cols = 3; ?>

    @include('sanatorium/shop::catalog/order')

    <div class="clearfix"></div>

    @include('sanatorium/shop::catalog/row')

    <div class="clearfix"></div>

    @include('sanatorium/shop::catalog/navigation')

  @else
    <p class="alert alert-warning">
      {{ trans('sanatorium/shop::messages.errors.uninstalled') }}
    </p>
  @endif

@stop
