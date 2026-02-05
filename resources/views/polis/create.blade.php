<x-layout>
    <div class="container mt-4">
        <h1>Create Polis</h1>

        <form id="polisForm">
            @csrf

            <label>Okupasi</label>
            <select id="okupasi" name="okupasi" required>
                <option value="">-- Pilih Okupasi --</option>
            </select>
            <br><br>

            <label>Konstruksi</label>
            <select name="konstruksi" required>
                <option value="">-- Pilih Konstruksi --</option>
                <option value="kelas 1">Kelas 1</option>
                <option value="kelas 2">Kelas 2</option>
                <option value="kelas 3">Kelas 3</option>
            </select>
            <br><br>

            <label>Jangka Waktu (1-10)</label>
            <input type="number" name="jangka_waktu" min="1" max="10" required>
            <br><br>

            <label>Harga Bangunan</label>
            <input type="number" name="harga_bangunan" min="0" required>
            <br><br>

            <label>Kota / Kabupaten (gunakan "/")</label>
            <input type="text" name="kota_kabupaten" required>
            <br><br>

            <label>Alamat</label>
            <textarea name="alamat" required></textarea>
            <br><br>

            <label>Provinsi</label>
            <input type="text" name="provinsi" required>
            <br><br>

            <label>Daerah</label>
            <input type="text" name="daerah" required>
            <br><br>

            <label>
                <input type="checkbox" name="gempa" value="1"> Termasuk Gempa
            </label>
            <br><br>

            <button type="submit" class="mb-5">Submit</button>

        </form>
    </div>

    <script>
        fetch('/api/okupasi')
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