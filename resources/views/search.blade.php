@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Search Image') }}</div>
                <div class="card-body">
                </div>
                <div class="box-body" style="margin-left: 30px;">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{url('/image/result')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row" class="search">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-bank"></i> Site URL* (One or more URL in sepeart line) </label>
                                    <textarea class="form-control" id="txt_siteUrl" name="txt_siteUrl" required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-bank"></i> Tag Name * (One or more tag name seperated by comma) </label>
                                    <input class="form-control" type="text" id="txt_tag" name="txt_tag" required="" placeholder="e.g. media, football, player">
                                </div>
                                <div class="form-group">
                                    <label><i class="fa fa-phone"></i> Image File * </label>
                                    <input class="form-control" type="file" id="file_image" name="file_image" required="" accept="image/*">
                                </div>
                                <div class="form-group">
                                    <button id="btn-submit" type="submit" class="btn btn-block btn-success"> Match Now
                                    </button>
                                </div>
                                <div class="form-group">
                                    <p>&nbsp;</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection