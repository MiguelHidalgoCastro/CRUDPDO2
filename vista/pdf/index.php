<div class="container-fluid col-xl-6 col-sm-12">
    <h2 class="text-center mb-3">Generar PDF'S</h2>
    <div class="row mb-5">
        <form id="frm-pdf-retos" action="?c=pdf&a=generarretos" method="post" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label>PDF Listado Retos Disponibles</label>
            </div>
            <div class="text-right">
                <button class="btn btn-primary">Generar PDF</button>
            </div>
        </form>
    </div>
    <div class="row mb-5">
        <form id="frm-pdf-profesores" action="?c=pdf&a=generarprof" method="post" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label>PDF Listado Profesores</label>
            </div>
            <div class="text-right">
                <button class="btn btn-primary">Generar PDF</button>
            </div>
        </form>
    </div>

    <h2>CARGAR LISTADO PROFESORES</h2>
    <div class="row mb-5">
        <form id="frm-profesores" action="?c=pdf&a=actualizarprofesores" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="docprofesores" class="form-label">Documento excel profesores</label>
                <input class="form-control" type="file" name="docprofesores" id="docprofesores" accept=".xlsx">
            </div>
            <div class="text-right">
                <button class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

</body>

</html>