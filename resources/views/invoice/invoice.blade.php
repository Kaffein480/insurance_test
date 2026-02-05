<x-layout>

    <head>
        <title>Invoice</title>
    </head>

    <body>
        <h1>Invoice</h1>

        <form id="invoiceForm">
            @csrf

            {{-- Select Polis --}}
            <label>Pilih Polis</label>
            <select name="polis_id" id="polisSelect" required>
                <option value="">-- Pilih Polis --</option>
            </select>
            <br><br>

            {{-- Show Polis Data --}}
            <div id="polisDetails" style="border: 1px solid #ccc; padding: 10px; display: none;">
                <h3>Detail Polis</h3>
                <p><strong>ID:</strong> <span id="polisId"></span></p>
                <p><strong>Okupasi:</strong> <span id="polisOkupasi"></span></p>
                <p><strong>Konstruksi:</strong> <span id="polisKonstruksi"></span></p>
                <p><strong>Jangka Waktu:</strong> <span id="polisJangkaWaktu"></span></p>
                <p><strong>Harga Bangunan:</strong> <span id="polisHargaBangunan"></span></p>
                <p><strong>Alamat:</strong> <span id="polisAlamat"></span></p>
                <p><strong>Provinsi:</strong> <span id="polisProvinsi"></span></p>
                <p><strong>Kota:</strong> <span id="polisKota"></span></p>
                <p><strong>Kabupaten:</strong> <span id="polisKabupaten"></span></p>
                <p><strong>Daerah:</strong> <span id="polisDaerah"></span></p>
                <p><strong>Gempa:</strong> <span id="polisGempa"></span></p>
                <p><strong>Premi:</strong> <span id="polisPremi"></span></p>
            </div>
            <br>

            <button type="submit">Create Invoice</button>
        </form>

        <script>
            let polisData = [];
            let okupasiData = [];

            // Fetch Polis
            fetch('get-polis')
                .then(res => res.json())
                .then(data => {
                    if (!data.error && data.data.length) {
                        polisData = data.data;
                        const select = document.getElementById('polisSelect');
                        data.data.forEach(polis => {
                            const option = document.createElement('option');
                            option.value = polis.id;
                            option.text = `${polis.okupasi} - ${polis.kota}/${polis.kabupaten} (ID: ${polis.id})`;
                            select.appendChild(option);
                        });
                    }
                });

            // Fetch Okupasi
            fetch('get-okupasi')
                .then(res => res.json())
                .then(data => {
                    if (!data.error && data.data.length) {
                        okupasiData = data.data;
                    }
                });

            // Show Polis details and premi when selected
            document.getElementById('polisSelect').addEventListener('change', function() {
                const polisId = parseInt(this.value);
                const detailsDiv = document.getElementById('polisDetails');

                if (!polisId) {
                    detailsDiv.style.display = 'none';
                    return;
                }

                const polis = polisData.find(p => p.id === polisId);
                if (!polis) return;

                // Find premi based on okupasi
                const okupasi = okupasiData.find(o => o.nama_okupasi === polis.okupasi);
                const premi = okupasi ? parseFloat(okupasi.premi) : 0;

                // Fill Polis details
                document.getElementById('polisId').textContent = polis.id;
                document.getElementById('polisOkupasi').textContent = polis.okupasi;
                document.getElementById('polisKonstruksi').textContent = polis.konstruksi;
                document.getElementById('polisJangkaWaktu').textContent = polis.jangka_waktu;
                document.getElementById('polisHargaBangunan').textContent = polis.harga_bangunan;
                document.getElementById('polisAlamat').textContent = polis.alamat;
                document.getElementById('polisProvinsi').textContent = polis.provinsi;
                document.getElementById('polisKota').textContent = polis.kota;
                document.getElementById('polisKabupaten').textContent = polis.kabupaten;
                document.getElementById('polisDaerah').textContent = polis.daerah;
                document.getElementById('polisGempa').textContent = polis.gempa ? 'Ya' : 'Tidak';
                document.getElementById('polisPremi').textContent = premi;

                detailsDiv.style.display = 'block';
            });

            // Submit Invoice
            document.getElementById('invoiceForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const polisId = parseInt(document.getElementById('polisSelect').value);
                const premi = parseFloat(document.getElementById('polisPremi').textContent);

                if (!polisId || isNaN(premi)) {
                    alert('Silahkan pilih Polis yang valid!');
                    return;
                }

                const invoiceData = {
                    id: polisId,
                    premi: premi
                };

                fetch('http://127.0.0.1:8000/api/create-invoice', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(invoiceData)
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert(data.message);
                        console.log(data);
                    })
                    .catch(err => console.error(err));
            });
        </script>
    </body>

    <x-layout>