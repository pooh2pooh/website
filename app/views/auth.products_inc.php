<div class="container-fluid">
  <div class="btn-group w-100">
    <!-- <a class="btn btn-lg btn-light my-3" href="/auth/productor">
      <span>ЗАГРУЗИТЬ ИЗ ФАЙЛА</span>
    </a> -->
    <a class="btn btn-lg btn-light my-3" href="/auth/productor">
      <span class="fw-bold">СОЗДАТЬ</span>
    </a>
  </div>

  <div class="table-responsive my-5">
    <table class="table table-bordered display" id="dataTable">
      <thead>
        <tr class="bg-dark text-white">
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
        <tr class="bg-light">
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