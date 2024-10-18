@foreach($categorieCode as $section1 => $classCategories)
    <h3>{{ $section1 }}</h3>
    @foreach($classCategories as $section2 => $codeUnspscs)
        <h5>{{ $section2 }}</h5>
        <ul>
            @foreach($codeUnspscs as $codeUnspsc)
                <li class="licence-item" data-id="{{ $codeUnspsc->id_code_unspsc }}">
                    {{ $codeUnspsc->precision_categorie }}
                </li>
            @endforeach
        </ul>
    @endforeach
@endforeach