<nav id="categories_menu">
    <h3 class="categories_menu_title">Kategorie</h3>
<ul>
    @foreach ($eshop_categories as $category)
        @if($category->show_in_menu)
        <li>
            <a class="arrowed" href="{{url("/kategorie/{$category->url}")}}">{{$category->name}}</a>
        </li>
        @endif
    @endforeach
</ul>
</nav>
