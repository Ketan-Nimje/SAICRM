
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/scroller/1.4.3/css/scroller.dataTables.min.css" rel="stylesheet">

<table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>First name</th>
                <th>Last name</th>
                <th>ZIP / Post code</th>
                <th>Country</th>
            </tr>
        </thead>
    </table>
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/scroller/1.4.3/js/dataTables.scroller.min.js"></script>
<script>
    $(document).ready(function() {
    $('#example').DataTable( {
        serverSide: true,
        ordering: false,
        searching: true,
        ajax: function ( data, callback, settings ) {
            var out = [];
 
            for ( var i=data.start, ien=data.start+data.length ; i<ien ; i++ ) {
                out.push( [ i+'-1', i+'-2', i+'-3', i+'-4', i+'-5' ] );
            }
 
            setTimeout( function () {
                callback( {
                    draw: data.draw,
                    data: out,
                    recordsTotal: 5000000,
                    recordsFiltered: 5000000
                } );
            }, 50 );
        },
        scrollY: 200,
        scroller: {
            loadingIndicator: true
        }
    } );
} );
</script>