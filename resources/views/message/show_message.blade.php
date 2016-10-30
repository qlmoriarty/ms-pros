@foreach($Message['items'] as $item)
    <div class="item">
        @if(!empty($item['User']['Avatar']))
            {!! Html::image($item['User']['Avatar'], 'user image') !!}
        @else
            {!! Html::image('dist/img/user-null-128x128.jpg', 'user image') !!}
        @endif
        <p class="message">
            <a href="#" class="name">
                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {!! $item['DateAddCarbon'] !!}
                </small>
                {!! $item['User']['Name'] !!}
            </a>
            {!! $item['Text'] !!}
        </p>
    </div><!-- /.item -->
@endforeach