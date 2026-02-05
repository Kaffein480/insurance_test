<!DOCTYPE html>
<html>

<head>
    <title>Update Okupasi</title>
</head>

<body>
    <h1>Update Okupasi</h1>

    <form id="okupasiForm">
        @csrf

        {{-- Select Okupasi --}}
        <label>Pilih Okupasi</label>
        <select id="okupasiSelect" required>
            <option value="">-- Pilih Okupasi --</option>
            @foreach ($okupasi as $o)
                <option value="{{ $o['id'] }}" data-nama="{{ $o['nama_okupasi'] }}" data-premi="{{ $o['premi'] }}">
                    {{ $o['nama_okupasi'] }}
                </option>
            @endforeach
        </select>
        <br><br>

        {{-- Nama Okupasi --}}
        <label>Nama Okupasi</label>
        <input type="text" id="namaOkupasi" required>
        <br><br>

        {{-- Premi --}}
        <label>Premi</label>
        <input type="number" id="premi" step="0.0001" required>
        <br><br>

        <button type="submit">Update</button>
    </form>

    <script>
        const okupasiSelect = document.getElementById('okupasiSelect');
        const namaInput = document.getElementById('namaOkupasi');
        const premiInput = document.getElementById('premi');
        let selectedId = null;

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

            fetch('http://127.0.0.1:8000/api/update-okupasi', {
                method: 'POST', // or PUT depending on your API
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(updatedData)
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                console.log(data);

                // Update the selected option text and data attributes dynamically
                const option = okupasiSelect.querySelector(`option[value="${selectedId}"]`);
                option.textContent = updatedData.nama_okupasi;
                option.dataset.nama = updatedData.nama_okupasi;
                option.dataset.premi = updatedData.premi;

            })
            .catch(err => console.error(err));
        });
    </script>
</body>

</html>
