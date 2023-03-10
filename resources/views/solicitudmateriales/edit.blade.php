@extends('adminlte::page')

<!-- TITULO DE LA PESTAÑA -->
@section('title', 'Solicitar Materiales')

<!-- CABECERA DE LA PAGINA -->
@section('content_header')
    <h1>Solicitar Materiales</h1>
@stop

@section('content')
    <!-- COLOCA AQUI EL FORMULARIO QUE CREES -->
    <form action="/solmaterial/{{$solicitud->ID_SOLICITUD}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
        <label for="NOMBRE_SOLICITANTE" class="form-label">Nombre del solicitante:</label>
        <input type="text" id="NOMBRE_SOLICITANTE" name="NOMBRE_SOLICITANTE" class="form-control{{ $errors->has('NOMBRE_SOLICITANTE') ? ' is-invalid' : '' }}" value="{{ $solicitud->NOMBRE_SOLICITANTE }}">
        @if ($errors->has('NOMBRE_SOLICITANTE'))
            <div class="invalid-feedback">
                {{ $errors->first('NOMBRE_SOLICITANTE') }}
            </div>
        @endif
        </div>

        <div class="mb-3">
            <label for="RUT" class="form-label">RUT:</label>
            <input type="text" id="RUT" name="RUT" class="form-control{{ $errors->has('RUT') ? ' is-invalid' : '' }}" value="{{ $solicitud->RUT }}">
            @if ($errors->has('RUT'))
                <div class="invalid-feedback">
                    {{ $errors->first('RUT') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="DEPTO" class="form-label">Departamento:</label>
            <input type="text" id="DEPTO" name="DEPTO" class="form-control{{ $errors->has('DEPTO') ? ' is-invalid' : '' }}" value="{{ $solicitud->DEPTO }}">
            @if ($errors->has('DEPTO'))
                <div class="invalid-feedback">
                    {{ $errors->first('DEPTO') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="EMAIL" class="form-label">Email:</label>
            <input type="email" id="EMAIL" name="EMAIL" class="form-control{{ $errors->has('EMAIL') ? ' is-invalid' : '' }}" value="{{ $solicitud->EMAIL }}">
            @if ($errors->has('EMAIL'))
                <div class="invalid-feedback">
                    {{ $errors->first('EMAIL') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="TIPO_MAT_SOL" class="form-label">Tipo de material a solicitar:</label>
            <select id="TIPO_MAT_SOL" name="TIPO_MAT_SOL" class="form-control" onchange="filterMaterials(this.value)">
                @foreach($tipos as $tipo)
                    @if($solicitud->TIPO_MAT_SOL == $tipo->TIPO_MATERIAL)
                        <option value="{{$tipo->TIPO_MATERIAL}}" selected>{{$tipo->TIPO_MATERIAL}}</option>
                    @else
                        <option value="{{$tipo->TIPO_MATERIAL}}">{{$tipo->TIPO_MATERIAL}}</option>
                    @endif
                @endforeach
                <option value="Todos">Todos</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="MATERIAL_SOL" class="form-label">Material Solicitado:</label>
            <!-- Agregar botón para abrir modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalMateriales">Seleccionar materiales</button>

            <textarea id="MATERIAL_SOL" name="MATERIAL_SOL" class="form-control" style="height:40%;">{{$solicitud->MATERIAL_SOL}}</textarea>
        </div>

        <div class="mb-3">
            <label for="ESTADO_SOL" class="form-label">Estado de la Solicitud:</label>
            <select id="ESTADO-SOL" name="ESTADO_SOL" class="form-control">
                <option value="INGRESADO">INGRESADO</option>
                <option value="EN REVISION" selected>EN REVISION</option>
                <option value="ACEPTADO">APROBADO</option>
                <option value="RECHAZADO">RECHAZADO</option>
            </select>
        </div>

        <a href="/solmaterial" class="btn btn-secondary" tabindex="5">Cancelar</a>
        <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>

        <!-- Modal de materiales -->
        <div class="modal fade" id="modalMateriales" tabindex="-1" role="dialog" aria-labelledby="modalMaterialesLabel" aria-hidden="true" onload="loadAllMaterials()">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMaterialesLabel">Materiales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="materialTable">
                <thead>
                    <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($materiales as $material)
                    <tr id="material{{$material->ID_MATERIAL}}" style="display:none;">
                        <td>{{$material->NOMBRE_MATERIAL}}</td>
                        <td>{{$material->TIPO_MATERIAL}}</td>
                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
        </div>
</form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <!-- Agregar script para filtrar la lista de materiales según el tipo seleccionado -->
    <script>
        function filterMaterials(selectedType) {
            // obtener la tabla de materiales
            var table = document.getElementById("materialTable");

            // recorrer las filas de la tabla
            for (var i = 1, row; row = table.rows[i]; i++) {
                // obtener el valor de la columna de tipo
                var type = row.cells[1].innerText;
                // si el tipo no coincide con el seleccionado, ocultar la fila
                if (type != selectedType && selectedType != "Todos") {
                    row.style.display = "none";
                } else {
                    row.style.display = "";
                }
            }
        }
        // función para cargar todos los materiales al iniciar la página
        function loadAllMaterials() {
            // obtener la tabla de materiales
            var table = document.getElementById("materialTable");

            // recorrer las filas de la tabla
            for (var i = 1, row; row = table.rows[i]; i++) {
                // mostrar la fila
                row.style.display = "";
            }
        }

        // llamar a la función al cargar la página
        window.onload = function() {
            loadAllMaterials();
        };
</script>
@stop

