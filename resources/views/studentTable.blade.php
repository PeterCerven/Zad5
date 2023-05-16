<x-layout>
    <table id="winners_data" class="table display table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Meno</th>
            <th>Priezvisko</th>
            <th>Rok</th>
            <th>Mesto</th>
            <th>Typ</th>
            <th>Krajina</th>
            <th>Disciplína</th>
        </tr>
        </thead>
        <tbody>
        <?php
        showWinnersNoLogin($db);
        ?>
        </tbody>
    </table>
    <div class="mt-6 p-4">
        {{$students->links()}}
    </div>
    <script>
        $(document).ready(function () {
            $('#winners_data').DataTable({
                columnDefs: [{
                    targets: [5],
                    orderData: [5, 3],
                },],
                responsive: true
            });
            // $('#top10_data').DataTable({
            //     responsive: true,
            //     paging: false,
            //     info: false
            // });


        });
    </script>
</x-layout>
