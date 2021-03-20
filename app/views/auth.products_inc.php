<div class="row">
    <div class="card mb-4 w-100">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Таблица товаров
            <a class="float-right btn btn-dark" href="/auth/productor">
                <i class="fas fa-plus mr-1"></i>
                Добавить новый
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered display" id="dataTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Артикул</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Управление</th>
                    </tr>
                    </thead>
                    <tbody>
                    {products}
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Артикул</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Управление</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>