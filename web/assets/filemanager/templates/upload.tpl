<script type="text/template" id="upload-template">
    <input class="btn btn-success form-control btn-upload" type="button" name="btn-upload" value="Загрузить файл">
    <input class="form-control hide" name="upload-file" type="file" multiple>
    <div class="upload-drop-file">
        Перенесите файлы сюда
    </div>
</script>

<script type="text/template" id="upload-file-status">
    <%= name %>
    <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
            <span class="sr-only"></span>
        </div>
    </div>
</script>