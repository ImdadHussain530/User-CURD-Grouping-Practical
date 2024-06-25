<x-layout>
    <div class="container">
        <h1>Create Users</h1>
        <div>
            <a href="{{ route('users.index') }}" type="button" class="btn btn-primary">All Users</a>
        </div>
        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                    name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"
                    name="dob" value="{{ old('dob') }}">
                @error('dob')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" class="form-control @error('age') is-invalid @enderror" id="age"
                    name="age" readonly value="{{ old('age') }}">
                @error('age')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ old('address') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="country">Country:</label>
                <select id="country" name="country" class="form-control">
                    <option value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="state">State:</label>
                <select id="state" name="state" class="form-control">
                    <option value="">Select State</option>
                </select>
                @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="city">City:</label>
                <select id="city" name="city" class="form-control">
                    <option value="">Select City</option>
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </select>
            </div>
            <div class="form-group">
                <label for="city">Proof</label>
                <input type="file" class="" id="proof" @error('proof') is-invalid @enderror name="proof[]"
                    multiple accept="image/jpeg, image/png, application/pdf" aria-describedby="proofAddon">

                @error('proof')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small id="fileHelp" class="form-text text-muted">You can upload up to 5 files.</small>


            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        
        
        @section('script')
        <script>
            $(document).ready(function() {
                $('#country').on('change', function() {
                    var countryId = this.value;
                    $("#state").html('');
                    $.ajax({
                        url: "{{ url('get-states') }}",
                        type: "POST",
                        data: {
                            country_id: countryId,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#state').html('<option value="">Select State</option>');
                            $.each(result.states, function(key, value) {
                                $("#state").append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                            $('#city').html('<option value="">Select City</option>');
                        }
                    });
                });

                $('#state').on('change', function() {
                    var stateId = this.value;
                    $("#city").html('');
                    $.ajax({
                        url: "{{ url('get-cities') }}",
                        type: "POST",
                        data: {
                            state_id: stateId,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#city').html('<option value="">Select City</option>');
                            $.each(result.cities, function(key, value) {
                                $("#city").append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                        }
                    });
                });
            });
            document.getElementById('proof').addEventListener('change', function() {
                var files = this.files;
                if (files.length > 5) {
                    alert('You can upload a maximum of 5 files.');
                    this.value = ''; // Clear the input
                }
            });

            // // Update the label with the number of selected files
            // document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            //     var fileName = Array.from(e.target.files).map(file => file.name).join(', ');
            //     var nextSibling = e.target.nextElementSibling;
            //     nextSibling.innerText = fileName;
            // });

            function calculateAge(dateOfBirth) {
                // Parse the date of birth string to a Date object
                var dob = new Date(dateOfBirth);

                // Get the current date
                var currentDate = new Date();

                // Calculate the difference in milliseconds between the current date and date of birth
                var timeDiff = currentDate.getTime() - dob.getTime();

                // Calculate age in years
                var age = Math.floor(timeDiff / (1000 * 3600 * 24 * 365.25));

                return age;
            }
            $('#dob').change((event) => {
                let dob = event.target.value;
                let age = calculateAge(dob);
                // console.log(age);

                $('#age').val(age);
            })
        </script>
        @endsection
        
</x-layout>
