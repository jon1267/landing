<div class="wrapper container-fluid">

    <form action="{{ route('pagesEdit', ['page' => $data['id']]) }}" class="form-horizontal" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <input type="hidden" name="id" value="{{ $data['id']}}">
            <label for="name" class="col-xs-2 control-label">Название</label>
            <div class="col-xs-8">
                <input class="form-control" type="text" name="name"
                       placeholder="Введите название страницы" value="{{ $data['name'] }}">
            </div>
        </div>

        <div class="form-group">
            <label for="alias" class="col-xs-2 control-label">Псевдоним</label>
            <div class="col-xs-8">
                <input class="form-control" type="text" name="alias"
                       placeholder="Введите псевдоним страницы" value="{{ $data['alias'] }}">
            </div>
        </div>

        <div class="form-group">
            <label for="text" class="col-xs-2 control-label">Текст статьи</label>
            <div class="col-xs-8">
                <textarea name="text" id="editor" class="form-control" rows="5"
                          placeholder="Введите текст статьи" >{{ $data['text'] }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="old_images" class="col-xs-2 control-label">Изображение</label>
            <div class="col-xs-4 col-xs-offset-1">
                <img src="{{ asset('assets/img/'.$data['images']) }}" alt="" class="img-circle">
                <input type="hidden" name="old_images" value="{{ $data['images'] }}">
            </div>
        </div>

        <div class="form-group">
            <label for="images" class="col-xs-2 control-label">Изображение</label>
            <div class="col-xs-8">
                <input type="file" name="images" class="filestyle" data-buttonText="Выберите изображение"
                       data-buttonName="btn-primary" data-placeholder="Файла нет" >
            </div>
        </div>


        {{ csrf_field() }}
        <div class="form-group">
            <div class="col-xs-10 col-xs-offset-2">
                <input type="submit" value="Сохранить" class="btn btn-primary">
            </div>
        </div>

    </form>

    <script>CKEDITOR.replace('editor');</script>
</div>