<script type="text/template" id="filter-render">
    <div class="col-md-12">
        <div class="panel-group" id="accordion" style="margin-bottom: 0">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            Поиск по скажине
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse">
                    <div class="panel-body">
                        <input class="form-control" type="text" name="name" placeholder="Наименование" data-type="oil">
                        <input class="form-control" type="text" name="field" placeholder="Месторождение" data-type="oil">
                        <input class="form-control" type="text" name="number" placeholder="Номер скважины" data-type="oil">
                        <input class="form-control" type="text" name="region" placeholder="Регион" data-type="oil">
                        <input class="form-control" type="text" name="status" placeholder="Текущее состояние" data-type="oil">
                        <input class="form-control" type="text" name="category" placeholder="Категория скважины по МПР" data-type="oil">
                        <button class="btn btn-success pull-right srchbtn">Поиск</button>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            Контекстный поиск
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <input class="form-control" name="name1" type="text" placeholder="Контекстный поиск">
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
