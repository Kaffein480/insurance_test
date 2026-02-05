<x-layout>
    <div class="container mt-4">

        <h1 class="mb-4">Update Okupasi</h1>

        <form id="okupasiForm" class="mb-5">
            @csrf

            {{-- Select Okupasi --}}
            <div class="mb-3">
                <label for="okupasiSelect" class="form-label">Pilih Okupasi</label>
                <select id="okupasiSelect" class="form-select" required>
                    <option value="">-- Pilih Okupasi --</option>
                    @foreach ($okupasi ?? [] as $o)
                    <option value="{{ $o['id'] }}"
                        data-nama="{{ $o['nama_okupasi'] }}"
                        data-premi="{{ $o['premi'] }}">
                        {{ $o['nama_okupasi'] }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Okupasi --}}
            <div class="mb-3">
                <label for="namaOkupasi" class="form-label">Nama Okupasi</label>
                <input type="text" id="namaOkupasi" class="form-control" required>
            </div>

            {{-- Premi --}}
            <div class="mb-3">
                <label for="premi" class="form-label">Premi</label>
                <input type="number" id="premi" class="form-control" step="0.0001" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script>
        const okupasiSelect = document.getElementById('okupasiSelect');
        const namaInput = document.getElementById('namaOkupasi');
        const premiInput = document.getElementById('premi');
        let selectedId = null;

        fetch('okupasi')
            .then(res => res.json())
            .then(data => {
                data.data.forEach(o => {
                    const option = document.createElement('option');
                    option.value = o.id;
                    option.textContent = o.nama_okupasi;
                    option.dataset.nama = o.nama_okupasi;
                    option.dataset.premi = o.premi;
                    okupasiSelect.appendChild(option);
                });
            });

        // Fill inputs when selecting okupasi
        okupasiSelect.addEventListener('change', function() {
            const option = this.selectedOptions[0];
            if (!option.value) {
                namaInput.value = '';
                premiInput.value = '';
                selectedId = null;
                return;
            }

            selectedId = parseInt(option.value);
            namaInput.value = option.dataset.nama;
            premiInput.value = option.dataset.premi;
        });

        // Submit update
        document.getElementById('okupasiForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!selectedId) {
                alert('Silahkan pilih Okupasi terlebih dahulu!');
                return;
            }

            const updatedData = {
                id: selectedId,
                nama_okupasi: namaInput.value.trim(),
                premi: parseFloat(premiInput.value)
            };

            fetch('update-okupasi', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(updatedData)
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    console.log(data);

                    const option = okupasiSelect.querySelector(`option[value="${selectedId}"]`);
                    option.textContent = updatedData.nama_okupasi;
                    option.dataset.nama = updatedData.nama_okupasi;
                    option.dataset.premi = updatedData.premi;
                })
                .catch(err => console.error(err));
        });
    </script>
</x-layout>