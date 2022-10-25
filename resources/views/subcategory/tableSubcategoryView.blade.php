<!DOCTYPE html>
<html>
    <body>
        <div class="card">
            <div class="card-header">
                <h6>Lista de subcategor&iacute;as</h6>
            </div>
            <div class="card-body">
                <div class="table-wrapper">
                    <table class="table table-wrapper">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripci&oacute;n</th>
                                <th>Encargado (a)</th>
                                <th>Acci&oacute;n</th>
                            </tr>
                        </thead>
                        <tbody id="table_list_complemet"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>

<style>
    .table-wrapper {
        width: 100%;
        height: 300px; /* Altura de ejemplo */
        overflow: auto;
    }

    .table-wrapper table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-wrapper table thead {
        position: -webkit-sticky; /* Safari... */
        position: sticky;
        top: 0;
        left: 0;
    }

    .table-wrapper table thead th,
    .table-wrapper table tbody td {
        background-color: #FFF;
    }
</style>