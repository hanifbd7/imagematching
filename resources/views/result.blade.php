@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold;">{{ __('Matching Results') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>
                <div class="box-body" style="margin-left: 30px;">
                    <div class="result">
                        <div>
                            <h3> Matched Images </h3>
                            <hr>
                            @forelse ($matched_images as $img)
                            <a href="{{ $img }}" data-lightbox="example-set1" data-title=""> {{ $img }}</a> <br/>
                            @empty
                            No match found!
                            @endforelse
                            
                        </div>
                        <div>&nbsp;</div>
                        <div>
                            <h3> Possible Matches </h3>
                            <hr>
                            @forelse ($matched_tags as $tag)
                            <a href="{{ $tag }}" data-lightbox="example-set2" data-title=""> {{ $tag }}</a> <br/>
                            @empty
                            No match found!
                            @endforelse
                        </div>
                    </div>
                    <div>&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
lightbox.option({
'maxHeight': 500,
'maxWidth': 600,
'fitImagesInViewport':true
})
</script>