<x-layout>
    <div class="container mt-4">
        <h1>Create Polis</h1>

        <style>
            @media (max-width: 768px) {
                .two-column {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <form id="polisForm">
            @csrf

            <div class="" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 8px;">

                <!-- Kiri -->
                <div>
                    <div>
                        <label style="display:block; text-align:left; margin-top:0;">Okupasi</label>
                        <select id="okupasi" name="okupasi" required>
                            <option value="">-- Pilih Okupasi --</option>
                        </select>
                    </div>


                    <label style="display:block; text-align:left; margin-top:0;">Konstruksi</label>
                    <div>
                        <label>
                            <input type="radio" name="konstruksi" value="kelas 1" required>
                            Kelas 1
                        </label>
                    </div>

                    <div>
                        <label>
                            <input type="radio" name="konstruksi" value="kelas 2">
                            Kelas 2
                        </label>
                    </div>

                    <div>
                        <label>
                            <input type="radio" name="konstruksi" value="kelas 3">
                            Kelas 3
                        </label>
                    </div>

                    <div><label style="display:block; text-align:left; margin-top:0;">Jangka Waktu (1-10)</label>
                        <input type="number" name="jangka_waktu" min="1" max="10" required>
                    </div>

                    <div><label style="display:block; text-align:left; margin-top:0;">Harga Bangunan</label>
                        <input type="number" name="harga_bangunan" min="0" required>
                    </div>


                </div>

                <!-- RIGHT COLUMN -->
                <div>
                    <div>
                        <label style="display:block; text-align:left; margin-top:0;">Kota / Kabupaten</label>
                        <input style="margin-bottom: 12px;" type="text" name="kota_kabupaten" required>
                    </div>

                    <div><label style="display:block; text-align:left; margin-top:0;">Alamat</label>
                        <textarea style="margin-bottom: 12px;" name="alamat" required></textarea>
                    </div>

                    <div><label style="display:block; text-align:left; margin-top:0;">Provinsi</label>
                        <input type="text" name="provinsi" required>
                    </div>

                    <div><label style="display:block; text-align:left; margin-top:0;">Daerah</label>
                        <input type="text" name="daerah" required>
                    </div>


                    <div><label>
                            <input type="checkbox" name="gempa" value="1">
                            Termasuk Gempa
                        </label></div>

                </div>

            </div>

            <button type="submit">Submit</button>

        </form>
    </div>

    <script>
        // getInvoice
        fetch('/okupasi', {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(res => res.json())
            .then(data => {
                if (!data.error && data.data.length) {
                    const select = document.getElementById('okupasi');
                    data.data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.nama_okupasi;
                        option.text = item.nama_okupasi;
                        option.dataset.premi = item.premi;

                        select.appendChild(option);
                    });
                }
            });

        // createPolis
        document.getElementById('polisForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const kotaKabupaten = form.kota_kabupaten.value.trim();
            const parts = kotaKabupaten.split('/').map(p => p.trim());

            const selectedOption = form.okupasi.options[form.okupasi.selectedIndex];
            const premi = parseFloat(selectedOption.dataset.premi);

            const formData = {
                jangka_waktu: parseInt(form.jangka_waktu.value),
                okupasi: form.okupasi.value,
                harga_bangunan: parseFloat(form.harga_bangunan.value),
                konstruksi: form.konstruksi.value,
                alamat: form.alamat.value,
                provinsi: form.provinsi.value,
                kota: parts[0] || '',
                kabupaten: parts[1] || '',
                daerah: form.daerah.value,
                gempa: form.gempa.checked ? 1 : 0,
                jenis_penanggungan: 'Asuransi kebakaran',
                premi: premi
            };

            fetch('/create-polis', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.error) {
                        window.location.href = '/dashboard';
                    } else {
                        alert('Gagal membuat polis');
                    }
                })
                .catch(err => console.error(err));
        });
    </script>

</x-layout>