<x-layout>
    <div class="container mt-4">

        <h1>Edit Profile</h1>

        <form id="editProfileForm">

            @csrf

            <div>
                <label style="display:block; text-align:left;">Name</label>
                <input type="text" id="name" required>
            </div>

            <div>
                <label style="display:block; text-align:left;">Email</label>
                <input type="email" id="email" required>
            </div>

            <div style="margin-top:15px;">
                <button type="submit">Update Profile</button>
            </div>

            <p id="message" style="margin-top:10px;"></p>

        </form>

    </div>

    <script>
        const form = document.getElementById('editProfileForm');
        const messageBox = document.getElementById('message');

        // LOAD USER DATA
        function loadUser() {
            fetch('/get-user')
                .then(res => res.json())
                .then(data => {
                    if (!data.error) {
                        document.getElementById('name').value = data.data.name;
                        document.getElementById('email').value = data.data.email;
                    }
                })
                .catch(err => console.error(err));
        }

        loadUser();

        // UPDATE USER
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            fetch('/update-user', {
                    method: 'post',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: document.getElementById('name').value,
                        email: document.getElementById('email').value
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    window.location.reload();
                })
                .catch(err => {
                    messageBox.style.color = "red";
                    messageBox.innerText = "Something went wrong.";
                    console.error(err);
                });
        });
    </script>

</x-layout>