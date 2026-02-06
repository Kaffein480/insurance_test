<x-layout>
    <div class="container mt-4">

        <h1 class="mb-4">Edit Profile</h1>

        {{-- TABLE --}}
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Okupasi</th>
                            <th>Premi</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="okupasiTable">
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- UPDATE MODAL --}}
    <div class="modal fade" id="updateModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Okupasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Nama Okupasi</label>
                            <input type="text" id="edit_nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Premi</label>
                            <input type="number" step="0.0001" id="edit_premi" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const tableBody = document.getElementById('okupasiTable');
        const updateForm = document.getElementById('updateForm');
        const modal = new bootstrap.Modal(document.getElementById('updateModal'));

        // LOAD DATA
        function loadOkupasi() {
            fetch('/okupasi')
                .then(res => res.json())
                .then(data => {
                    tableBody.innerHTML = '';

                    data.data.forEach(o => {
                        tableBody.innerHTML += `
                        <tr>
                            <td>${o.nama_okupasi}</td>
                            <td>${o.premi}</td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick="openEditModal(${o.id}, '${o.nama_okupasi}', ${o.premi})">
                                    Update
                                </button>
                            </td>
                        </tr>
                    `;
                    });
                });
        }

        loadOkupasi();

        // OPEN MODAL + FILL OLD DATA
        function openEditModal(id, nama, premi) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_premi').value = premi;

            modal.show();
        }

        // SUBMIT UPDATE
        updateForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.getElementById('edit_id').value;
            const nama = document.getElementById('edit_nama').value;
            const premi = document.getElementById('edit_premi').value;

            fetch('/update-okupasi', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id,
                        nama_okupasi: nama,
                        premi: premi
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    modal.hide();
                    loadOkupasi();
                })
                .catch(err => console.error(err));
        });
    </script>

</x-layout>
