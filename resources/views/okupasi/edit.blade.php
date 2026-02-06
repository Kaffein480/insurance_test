<x-layout>
    <div class="container mt-4">

        <h1>Edit Okupasi</h1>

        {{-- CREATE FORM --}}

        <div class="card mb-4">
            <h4 style="margin: 5px 0;">Tambah Okupasi</h4>
            <div class="card-body">
                <form id="createForm">
                    @csrf
                    <input type="text" id="nama_okupasi" placeholder="Nama Okupasi" class="form-control mb-2" required>
                    <input type="number" step="0.0001" id="premi" placeholder="Premi" class="form-control mb-2" required>
                    <button class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div style="width: 100%; margin: 0 auto;">
            <div class="card" style="width: 100%;">
                <div class="card-body" style="width: 100%;">
                    <table class="table table-bordered" style="width: 100%;">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama</th>
                                <th>Premi</th>
                                <th width="200">Action</th>
                            </tr>
                        </thead>
                        <tbody id="okupasiTable"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        const tableBody = document.getElementById('okupasiTable');
        const form = document.getElementById('createForm');

        const csrfToken = '{{ csrf_token() }}';


        // getOkupasi
        function loadOkupasi() {
            fetch('/okupasi')
                .then(res => res.json())
                .then(res => {
                    tableBody.innerHTML = '';

                    res.data.forEach(o => {
                        tableBody.innerHTML += `
                    <tr id="row-${o.id}">
                        <td>${o.nama_okupasi}</td>
                        <td>${o.premi}</td>
                        <td>
                            <button onclick="editRow(${o.id}, '${o.nama_okupasi}', ${o.premi})"
                                class="btn btn-warning btn-sm">Edit</button>

                            <button onclick="deleteRow(${o.id})"
                                class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                `;
                    });
                });
        }

        loadOkupasi();


        // createOkupasi
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            fetch('/create-okupasi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        nama_okupasi: document.getElementById('nama_okupasi').value,
                        premi: document.getElementById('premi').value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    form.reset();
                    loadOkupasi();
                });
        });


        // edit inline
        function editRow(id, nama, premi) {
            const row = document.getElementById(`row-${id}`);

            row.innerHTML = `
        <td>
            <input type="text" id="edit-nama-${id}" value="${nama}" class="form-control">
        </td>
        <td>
            <input type="number" step="0.0001" id="edit-premi-${id}" value="${premi}" class="form-control">
        </td>
        <td>
            <button onclick="updateRow(${id})" class="btn btn-success btn-sm">Save</button>
            <button onclick="loadOkupasi()" class="btn btn-secondary btn-sm">Cancel</button>
        </td>
    `;
        }


        // updateOkupasi
        function updateRow(id) {

            fetch(`/update-okupasi/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        nama_okupasi: document.getElementById(`edit-nama-${id}`).value,
                        premi: document.getElementById(`edit-premi-${id}`).value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    loadOkupasi();
                });
        }


        // deleteOkupasi
        function deleteRow(id) {

            if (!confirm('Yakin hapus?')) return;

            fetch(`/okupasi/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(res => res.json())
                .then(data => {
                    loadOkupasi();
                });
        }
    </script>

</x-layout>
