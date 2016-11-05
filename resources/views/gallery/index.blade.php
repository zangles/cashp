<!-- Add jQuery library -->


<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="{{ asset('/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="{{ asset('/fancybox/source/jquery.fancybox.css?v=2.1.5') }}" type="text/css" media="screen" />
<script type="text/javascript" src="{{ asset('/fancybox/source/jquery.fancybox.pack.js?v=2.1.5') }}"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="{{ asset('/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5') }}" type="text/css" media="screen" />
<script type="text/javascript" src="{{ asset('/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5') }}"></script>
<script type="text/javascript" src="{{ asset('/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6') }}"></script>

<link rel="stylesheet" href="{{ asset('/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7') }}" type="text/css" media="screen" />
<script type="text/javascript" src="{{ asset('/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7') }}"></script>

<script>
    $(document).ready(function(){
        $(".fancybox").fancybox();
    });
</script>
<div class="row">
    <div class="col-md-12">
        {{ $images->links() }}
    </div>
</div>
    <div class="row">
        @foreach($images as $image)
            <div class="col-md-3 col-sm-4 col-xs-6" style="margin-top: 15px">
                <a class="fancybox" rel="group" href="{{ $image->path }}">
                    <img class="img-responsive" data-id="{{ $image->id }}" src="{{ $image->path }}" alt="" />
                </a>
            </div>
        @endforeach
    </div>
<div class="row">
    <div class="col-md-12">
        {{ $images->links() }}
    </div>
</div>
