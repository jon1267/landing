<div style="margin: 0px 50px 0px 50px;">

@if($pages)

    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>№ </th>
                <th>Имя</th>
                <th>Псевдоним</th>
                <th>Текст</th>
                <th>Дата_создан</th>
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $k => $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td><a href="{{ route('pagesEdit', ['$page' => $page->id]) }}">{{ $page->name }}</a></td>
                    <td>{{ $page->alias }}</td>
                    <td>{{ $page->text }}</td>
                    <td>{{ $page->created_at }}</td>
                    <td>
                    <form action="{{ route('pagesEdit', ['$page' => $page->id]) }}" class="form-horizontal" method="post">
                        <!-- <input type="hidden" name="_method" value="delete">
                            тоже самое (строка ниже), через хелрер лары -->
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="submit" value="Удалить" class="btn btn-danger btn-sm">
                    </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endif

<a href="{{ route('pagesAdd') }}" class="btn btn-primary btn-sm">Новая страница</a>

</div>